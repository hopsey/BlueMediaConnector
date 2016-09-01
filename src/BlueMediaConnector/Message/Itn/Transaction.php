<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 23:01
 */

namespace BlueMediaConnector\Message\Itn;
use BlueMediaConnector\Hydrator\StaticHydrator;
use BlueMediaConnector\Hydrator\ValueObject;
use BlueMediaConnector\ValueObject\Amount;
use BlueMediaConnector\ValueObject\Currency;
use BlueMediaConnector\ValueObject\CustomerData;
use BlueMediaConnector\ValueObject\FloatNumber;
use BlueMediaConnector\ValueObject\Hash;
use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\OrderId;
use BlueMediaConnector\ValueObject\PaymentStatus;
use BlueMediaConnector\ValueObject\StringValue;


class Transaction
{
    /**
     * @var OrderId
     */
    private $orderID;

    /**
     * @var StringValue
     */
    private $remoteID;

    /**
     * @var FloatNumber
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
     * Transaction constructor.
     * @param OrderId $orderID
     * @param StringValue $remoteID
     * @param Amount $amount
     * @param Currency $currency
     * @param PaymentStatus $paymentStatus
     * @param IntegerNumber|null $gatewayID
     * @param StringValue|null $addressIP
     * @param StringValue|null $title
     * @param CustomerData|null $customerData
     */
    public function __construct(OrderId $orderID, StringValue $remoteID, Amount $amount, Currency $currency,
        PaymentStatus $paymentStatus, IntegerNumber $gatewayID = null, StringValue $addressIP = null, StringValue $title = null,
        CustomerData $customerData = null)
    {
        $this->orderID = $orderID;
        $this->remoteID = $remoteID;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->paymentStatus = $paymentStatus;
        $this->gatewayID = $gatewayID;
        $this->addressIP = $addressIP;
        $this->title = $title;
        $this->customerData = $customerData;
    }

    public function toArray()
    {
        return StaticHydrator::extract(ValueObject::class, $this);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return null;
    }
}