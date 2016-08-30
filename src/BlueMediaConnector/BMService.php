<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 12:44
 */

namespace BlueMediaConnector;


use BlueMediaConnector\Event\PreTransactionEvent;
use BlueMediaConnector\Transaction\ModeInterface;
use BlueMediaConnector\ValueObject\Currency;
use BlueMediaConnector\ValueObject\Email;
use BlueMediaConnector\ValueObject\FloatNumber;
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
        $args = ['Amount' => $amount];
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

        $orderId = OrderId::fromNative();
        $args['OrderId'] = $orderId;
        $args['Hash'] = HashFactory::build($args, $this->connector->getSecret());

        $event = new PreTransactionEvent($orderId);
        $event->setArgs($args);
        $this->getEventManager()->triggerEvent($event);

        $mode->serve($this->connector, $args);
    }
}