<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 15:07
 */

namespace BlueMediaConnector\Transaction;


use BlueMediaConnector\Connector;
use BlueMediaConnector\ValueObject\Hash\ArgsTransport\TransactionArgs;

interface ModeInterface
{
    public function serve(Connector $connector, TransactionArgs $args);
}