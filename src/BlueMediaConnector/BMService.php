<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 12:44
 */

namespace BlueMediaConnector;


use BlueMediaConnector\Event\PreTransactionEvent;
use BlueMediaConnector\Hydrator\StaticHydrator;
use BlueMediaConnector\Hydrator\ValueObject;
use BlueMediaConnector\Message\Itn;
use BlueMediaConnector\Transaction\ModeInterface;
use BlueMediaConnector\Transport\TransportInterface;
use BlueMediaConnector\Transport\Xml;
use BlueMediaConnector\ValueObject\Currency;
use BlueMediaConnector\ValueObject\CustomerData;
use BlueMediaConnector\ValueObject\Email;
use BlueMediaConnector\ValueObject\FloatNumber;
use BlueMediaConnector\ValueObject\Hash;
use BlueMediaConnector\ValueObject\Hash\HashFactory;
use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\OrderId;
use BlueMediaConnector\ValueObject\StringValue;
use Zend\EventManager\EventManagerAwareTrait;

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

    public function makeTransaction(ModeInterface $mode, FloatNumber $amount, StringValue $description = null, IntegerNumber $gatewayId = null,
        Currency $currency = null, Email $customerEmail = null)
    {
        $args = new Hash\ArgsTransport\TransactionArgs();

        $args['Amount'] = $amount;
        if ($description !== null) {
            $args['Description'] = $description;
        }

        if ($gatewayId !== null) {
            $args['GatewayID'] = $gatewayId;
        }

        if ($currency !== null) {
            $args['Currency'] = $currency;
        }

        if ($customerEmail !== null) {
            $args['CustomerEmail'] = $customerEmail;
        }

        $orderId = OrderId::fromNative(200);
        $args['OrderId'] = $orderId;
        $args['ServiceId'] = $this->connector->getServiceId();

        $args['Hash'] = HashFactory::build($args, $this->connector->getSecret());

        $event = new PreTransactionEvent($orderId);
        $event->setArgs($args);
        $this->getEventManager()->triggerEvent($event);

        $mode->serve($this->connector, $args);
    }

    private function arrayValuesRecursive($ary)
    {
        $lst = array();
        foreach( array_keys($ary) as $k ){
            $v = $ary[$k];
            if (is_scalar($v)) {
                $lst[] = $v;
            } elseif (is_array($v)) {
                $lst = array_merge( $lst,
                    $this->arrayValuesRecursive($v)
                );
            }
        }
        return $lst;
    }

    public function receiveItnResult($document, TransportInterface $transport = null)
    {
        $documentArray = self::getTransport()->parse($document);

        // TODO zaimplementować fabrykę
        $itn = new Itn(
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



        return $itn;
    }
}