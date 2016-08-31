<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 15:08
 */

namespace BlueMediaConnector\Transaction;


use BlueMediaConnector\Connector;
use BlueMediaConnector\ValueObject\Hash\ArgsTransport\TransactionArgs;
use BlueMediaConnector\ValueObject\ValueObjectInterface;

class RedirectMode implements ModeInterface
{
    public function serve(Connector $connector, TransactionArgs $args)
    {
        $connector->getServiceUrl();

        $argsArray = [];
        foreach ($args as $key => $arg) {
            $argsArray[$key] = (string)$arg;
        }

        header("Location: " . (string)$connector->getServiceUrl() . "?" . \http_build_query($argsArray));
    }
}