<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 22:59
 */

namespace BlueMediaConnector\Message;


use BlueMediaConnector\Hydrator\StaticHydrator;
use BlueMediaConnector\Hydrator\ValueObject;
use BlueMediaConnector\ValueObject\Amount;
use BlueMediaConnector\ValueObject\Currency;
use BlueMediaConnector\ValueObject\CustomerData;
use BlueMediaConnector\ValueObject\DateTime;
use BlueMediaConnector\ValueObject\Hash;
use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\OrderId;
use BlueMediaConnector\ValueObject\PaymentStatus;
use BlueMediaConnector\ValueObject\StringValue;
use BlueMediaConnector\ValueObject\ValueObjectInterface;

class ItnMessage extends AbstractMessage
{
    /**
     * @var IntegerNumber
     */
    private $serviceID;

    /**
     * @var OrderId
     */
    private $orderID;

    /**
     * @var StringValue
     */
    private $remoteID;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var PaymentStatus
     */
    private $paymentStatus;

    /**
     * @var DateTime
     */
    private $paymentDate;

    /**
     * @var StringValue
     */
    private $paymentStatusDetails;

    /**
     * @var IntegerNumber|null
     */
    private $gatewayID = null;

    /**
     * @var StringValue|null
     */
    private $addressIP = null;

    /**
     * @var StringValue|null
     */
    private $title = null;

    /**
     * @var CustomerData|null
     */
    private $customerData = null;

    /**
     * @var Amount
     */
    private $startAmount;

    /**
     * @var Hash
     */
    private $docHash;

    /**
     * ItnMessage constructor.
     * @param IntegerNumber $serviceID
     * @param OrderId $orderID
     * @param StringValue $remoteID
     * @param Amount $amount
     * @param Currency $currency
     * @param PaymentStatus $paymentStatus
     * @param IntegerNumber|null $gatewayID
     * @param StringValue|null $addressIP
     * @param StringValue|null $title
     * @param CustomerData|null $customerData
     * @param Hash $docHash
     */
    public function __construct(IntegerNumber $serviceID = null, OrderId $orderID, StringValue $remoteID, Amount $amount, Currency $currency, DateTime $paymentDate,
        PaymentStatus $paymentStatus, StringValue $paymentStatusDetails = null, IntegerNumber $gatewayID = null, StringValue $addressIP = null, StringValue $title = null,
        CustomerData $customerData = null, Hash $docHash, Amount $startAmount = null)
    {
        $this->serviceID = $serviceID;
        $this->orderID = $orderID;
        $this->remoteID = $remoteID;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->paymentDate = $paymentDate;
        $this->paymentStatus = $paymentStatus;
        $this->paymentStatusDetails = $paymentStatusDetails;
        $this->gatewayID = $gatewayID;
        $this->addressIP = $addressIP;
        $this->title = $title;
        $this->customerData = $customerData;
        $this->docHash = $docHash;
        $this->startAmount = $startAmount;
    }

    protected function getArgsToComputeHash()
    {
        $args = new Hash\ArgsTransport\ItnArgs();

        $properties = get_object_vars($this);
        unset($properties['docHash']);
        unset($properties['customerData']);

        foreach ($properties as $key => $value) {
            if (null === $value || (!is_object($value) && !$value instanceof ValueObjectInterface)) {
                continue;
            }
            $args[$key] = $value;
        }
        if ($this->customerData !== null) {
            $args['customerData'] = $this->customerData->toNative();
        }

        $args['paymentDate'] = preg_replace('/[\s\-\:]+/', '', $args['paymentDate']->toNative());

        return $args;
    }

    public function isHashValid(Hash\HashFactoryInterface $hashFactory)
    {
        return (string)$this->docHash == (string)$this->computeHash($hashFactory);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return null;
    }

    public function toArray()
    {
        $properties = get_object_vars($this);
        unset($properties['docHash']);
        unset($properties['customerData']);
        $array = [];
        foreach ($properties as $propertyName => $property) {
            if (!is_object($property) && !$property instanceof ValueObjectInterface) {
                continue;
            }
            $array[$propertyName] = $property->toNative();
        }
        $array['customerData'] = StaticHydrator::extract(ValueObject::class, $this->customerData);
        return $array;
    }
}