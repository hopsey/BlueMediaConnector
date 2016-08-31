<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 18:18
 */

namespace BlueMediaConnector\Message;


interface OutgoingMessageInterface extends MessageInterface
{
    public function getArrayToExecute();
}