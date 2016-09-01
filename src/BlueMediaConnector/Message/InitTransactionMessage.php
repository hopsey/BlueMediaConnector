<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 17:54
 */

namespace BlueMediaConnector\Message;


use BlueMediaConnector\ValueObject\Currency;
use BlueMediaConnector\ValueObject\Email;
use BlueMediaConnector\ValueObject\FloatNumber;
use BlueMediaConnector\ValueObject\Hash\ArgsTransport\TransactionArgs;
use BlueMediaConnector\ValueObject\Hash\HashFactoryInterface;
use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\OrderId;
use BlueMediaConnector\ValueObject\StringValue;

class InitTransactionMessage implements OutgoingMessageInterface
{
    /**
     * @var FloatNumber
     */
    private $amount;

    /**
     * @var IntegerNumber
     */
    private $serviceId;

    /**
     * @var StringValue
     */
    private $description = null;

    /**
     * @var IntegerNumber
     */
    private $gatewayID = null;

    /**
     * @var Currency
     */
    private $currency = null;

    /**
     * @var Email
     */
    private $customerEmail = null;

    /**
     * @var OrderId
     */
    private $orderId;

    private $mappedFieldsToExecute = [
        'amount' => 'Amount',
        'serviceId' => 'ServiceID',
        'orderId' => 'OrderId',
        'gatewayID' => 'OrderID',
        'description' => 'Description',
        'currency' => 'Currency',
        'customerEmail' => 'CustomerEmail',
    ];

    /**
     * InitTransactionMessage constructor.
     * @param FloatNumber $amount
     * @param IntegerNumber $serviceId
     * @param StringValue $description
     * @param IntegerNumber $gatewayID
     * @param Currency $currency
     * @param Email $customerEmail
     */
    public function __construct(FloatNumber $amount, IntegerNumber $serviceId, StringValue $description = null,
                                IntegerNumber $gatewayID = null, Currency $currency = null, Email $customerEmail = null)
    {
        $this->orderId = OrderId::fromNative();
        $this->amount = $amount;
        $this->serviceId = $serviceId;
        $this->description = $description;
        $this->gatewayID = $gatewayID;
        $this->currency = $currency;
        $this->customerEmail = $customerEmail;
    }


    public function computeHash(HashFactoryInterface $hashFactory)
    {
        $args = new TransactionArgs();

        foreach ($this->mappedFieldsToExecute as $fieldLocal => $fieldExternal) {
            if ($this->{$fieldLocal} === null) {
                continue;
            }
            $args[$fieldExternal] = $this->{$fieldLocal};
        }

        return $hashFactory->build($args);
    }

    public function getArrayToExecute()
    {
        $args = [];
        foreach ($this->mappedFieldsToExecute as $fieldLocal => $fieldExternal) {
            if ($this->{$fieldLocal} === null) {
                continue;
            }
            $args[$fieldExternal] = $this->{$fieldLocal};
        }
        return $args;
    }


    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return null;
    }
}