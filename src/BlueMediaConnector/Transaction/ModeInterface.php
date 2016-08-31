<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 15:07
 */

namespace BlueMediaConnector\Transaction;


use BlueMediaConnector\Connector;
use BlueMediaConnector\Message\MessageInterface;
use BlueMediaConnector\Message\OutgoingMessageInterface;
use BlueMediaConnector\ValueObject\Hash\ArgsTransport\TransactionArgs;
use BlueMediaConnector\ValueObject\Hash\HashFactoryInterface;

interface ModeInterface
{
    public function serve(Connector $connector, HashFactoryInterface $hashFactory, OutgoingMessageInterface $message);
}