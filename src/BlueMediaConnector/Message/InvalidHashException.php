<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 17:43
 */

namespace BlueMediaConnector\Message;


class InvalidHashException extends \InvalidArgumentException
{
    private $messageInterface;

    public function getMessageInterface()
    {
        return $this->messageInterface;
    }

    public function __construct(MessageInterface $message)
    {
        $this->messageInterface = $message;
        parent::__construct("Invalid hash received");
    }
}