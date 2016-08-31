<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 14:57
 */

namespace BlueMediaConnector\Event;


use BlueMediaConnector\Message\MessageInterface;
use BlueMediaConnector\Message\OutgoingMessageInterface;
use BlueMediaConnector\ValueObject\Hash\ArgsTransport\TransactionArgs;
use BlueMediaConnector\ValueObject\OrderId;
use Zend\EventManager\Event;

class PreTransactionEvent extends Event
{
    /**
     * @var OutgoingMessageInterface
     */
    private $message;

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
     * @param OutgoingMessageInterface $message
     */
    public function setMessage(OutgoingMessageInterface $message)
    {
        $this->message = $message;
        $this->setParam('message', $message);
    }
}