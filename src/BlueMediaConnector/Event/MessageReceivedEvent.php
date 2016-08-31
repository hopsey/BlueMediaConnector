<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 18:50
 */

namespace BlueMediaConnector\Event;


use BlueMediaConnector\Message\MessageInterface;
use BlueMediaConnector\ValueObject\OrderId;
use Zend\EventManager\Event;

class MessageReceivedEvent extends Event
{
    /**
     * @var MessageInterface
     */
    private $message;

    const EVENT_MESSAGE_RECEIVED = 'messageReceived';

    /**
     * PreTransactionEvent constructor.
     * @param null $target
     * @param null $params
     */
    public function __construct($target = null, $params = null)
    {
        parent::__construct(self::EVENT_MESSAGE_RECEIVED, $target, $params);
    }

    /**
     * @param MessageInterface $message
     */
    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
        $this->setParam('message', $message);
    }
}