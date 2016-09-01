<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 12:44
 */

namespace BlueMediaConnector;


use BlueMediaConnector\Event\MessageReceivedEvent;
use BlueMediaConnector\Event\PreTransactionEvent;
use BlueMediaConnector\Hydrator\StaticHydrator;
use BlueMediaConnector\Hydrator\ValueObject;
use BlueMediaConnector\Message\InitTransactionMessage;
use BlueMediaConnector\Message\InvalidHashException;
use BlueMediaConnector\Message\Itn;
use BlueMediaConnector\Message\ItnMessage;
use BlueMediaConnector\Transaction\ModeInterface;
use BlueMediaConnector\Transport\TransportInterface;
use BlueMediaConnector\Transport\Xml;
use BlueMediaConnector\ValueObject\Amount;
use BlueMediaConnector\ValueObject\Currency;
use BlueMediaConnector\ValueObject\CustomerData;
use BlueMediaConnector\ValueObject\Email;
use BlueMediaConnector\ValueObject\FloatNumber;
use BlueMediaConnector\ValueObject\Hash;
use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\StringValue;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Stdlib\Message;

/**
 * Klasa reprezentujaca funkcjonalnosci API BM
 * TODO w przyszlosci przeimplementowac na komendy aby było w zgodzie z SRP.
 * @package BlueMediaConnector
 */
class BMService
{
    use EventManagerAwareTrait;

    private static $transport = null;

    /**
     * @var Hash\HashFactoryInterface
     */
    private $hashFactory;

    /**
     * @param Hash\HashFactoryInterface $hashFactory
     */
    public function setHashFactory(Hash\HashFactoryInterface $hashFactory)
    {
        $this->hashFactory = $hashFactory;
    }

    /**
     * @return Hash\HashFactoryInterface
     */
    public function getHashFactory()
    {
        return $this->hashFactory;
    }

    /**
     * @return TransportInterface
     */
    public static function getTransport()
    {
        if (null === self::$transport) {
            // domyslny transport zgodny z BM
            self::$transport = new Xml();
        }
        return self::$transport;
    }

    /**
     * @param TransportInterface $transport
     */
    public static function setTransport(TransportInterface $transport)
    {
        self::$transport = $transport;
    }

    /**
     * @var Connector
     */
    private $connector;

    /**
     * BMService constructor.
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function makeTransaction(ModeInterface $mode, $amount, $description = null, $gatewayId = null,
        $currency = null, $customerEmail = null)
    {
        $initTransactionMessage = new InitTransactionMessage(
            Amount::fromNative($amount),
            $this->connector->getServiceId(),
            $description === null ? null : StringValue::fromNative($description),
            $gatewayId === null ? null : IntegerNumber::fromNative($gatewayId),
            $currency === null ? null : Currency::fromNative($currency),
            $customerEmail === null ? null : Email::fromNative()
        );

        $event = new PreTransactionEvent($initTransactionMessage->orderId);
        $event->setMessage($initTransactionMessage);
        $this->getEventManager()->triggerEvent($event);

        $mode->serve($this->connector, $this->hashFactory, $initTransactionMessage);
    }

    public function receiveItnResult($document)
    {
        $documentArray = self::getTransport()->parse($document);

        // TODO zaimplementować fabrykę do budowania wiadomości bazujących na otrzymanych danych
        $itn = new ItnMessage(
            IntegerNumber::fromNative($documentArray['serviceID']),
            Hash::fromNative($documentArray['hash'])
        );

        if (count($documentArray['transactions']) > 0) {
            foreach ($documentArray['transactions'] as $transaction) {

                if (isset($transaction['customerData']) && is_array($transaction['customerData'])) {
                    $transaction['customerData'] = StaticHydrator::build(ValueObject::class, CustomerData::class, $transaction['customerData']);
                }

                $itn->attachTransaction(
                    StaticHydrator::build(ValueObject::class, Itn\Transaction::class, $transaction)
                );
            }
        }

        // TODO odseparować logikę obsługującą odebranie wiadomości do oddzielnego serwisu, aby można to było ponownie wykorzystać
        $hash = $itn->computeHash($this->hashFactory);
        if ((string)$hash != (string)$itn->hash) {
            throw new InvalidHashException($itn);
        }

        $event = new MessageReceivedEvent();
        $event->setMessage($itn);
        $this->getEventManager()->triggerEvent($event);
    }
}