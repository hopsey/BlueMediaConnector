<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 01/09/16
 * Time: 23:07
 */

namespace BlueMediaConnector\Message\ResultResponse;

use BlueMediaConnector\Hydrator\StaticHydrator;
use BlueMediaConnector\Hydrator\ValueObject;
use BlueMediaConnector\ValueObject\ConfirmationResult;
use BlueMediaConnector\ValueObject\OrderId;

class TransactionResult
{
    /**
     * @var OrderId
     */
    private $orderID;

    /**
     * @var ConfirmationResult
     */
    private $confirmation;

    /**
     * TransactionResult constructor.
     * @param OrderId $orderId
     * @param ConfirmationResult $confirmation
     */
    public function __construct(OrderId $orderId, ConfirmationResult $confirmation)
    {
        $this->orderID = $orderId;
        $this->confirmation = $confirmation;
    }

    public function toArray()
    {
        return StaticHydrator::extract(ValueObject::class, $this);
    }
}