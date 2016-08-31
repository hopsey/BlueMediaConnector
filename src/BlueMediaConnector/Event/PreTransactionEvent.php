<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 14:57
 */

namespace BlueMediaConnector\Event;


use BlueMediaConnector\ValueObject\Hash\ArgsTransport\TransactionArgs;
use BlueMediaConnector\ValueObject\OrderId;
use Zend\EventManager\Event;

class PreTransactionEvent extends Event
{
    /**
     * @var TransactionArgs
     */
    private $args;

    /**
     * @var OrderId
     */
    private $orderId;

    const EVENT_PRE_TRANSACTION = 'preTransaction';

    /**
     * PreTransactionEvent constructor.
     * @param null $target
     * @param null $params
     */
    public function __construct(OrderId $orderId, $target = null, $params = null)
    {
        $this->orderId = $orderId;
        parent::__construct(self::EVENT_PRE_TRANSACTION, $target, $params);
    }

    /**
     * @param TransactionArgs $args
     */
    public function setArgs(TransactionArgs $args)
    {
        $this->args = $args;
        $this->setParam('args', $args);
    }
}