<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 15:08
 */

namespace BlueMediaConnector\Transaction;


use BlueMediaConnector\Connector;
use BlueMediaConnector\Message\MessageInterface;
use BlueMediaConnector\Message\OutgoingMessageInterface;
use BlueMediaConnector\ValueObject\Hash\ArgsTransport\TransactionArgs;
use BlueMediaConnector\ValueObject\Hash\HashFactoryInterface;
use BlueMediaConnector\ValueObject\ValueObjectInterface;

class RedirectMode implements ModeInterface
{
    public function serve(Connector $connector, HashFactoryInterface $hashFactory, OutgoingMessageInterface $message)
    {
        $connector->getServiceUrl();

        $argsArray = $message->getArrayToExecute();
        $argsArray = array_map(function ($value) {
            return (string)$value;
        }, $argsArray);

        $argsArray['Hash'] = (string)$message->computeHash($hashFactory);

        header("Location: " . (string)$connector->getServiceUrl() . "?" . \http_build_query($argsArray));
        exit;
    }
}