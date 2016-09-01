<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 15:00
 */

namespace BlueMediaConnector\ValueObject\Hash\ArgsTransport;


class TransactionArgs extends AbstractTransport
{
    protected function hashParamsOrder()
    {
        return [
            'ServiceID', 'OrderID', 'Amount', 'Description', 'GatewayId', 'Currency', 'CustomerEmail', 'ValidityTime', 'LinkValidityTime'
        ];
    }
}