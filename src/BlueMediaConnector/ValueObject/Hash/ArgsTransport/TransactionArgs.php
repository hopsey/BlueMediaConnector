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
            'ServiceId', 'OrderId', 'Amount', 'Description', 'GatewayId', 'Currency', 'CustomerEmail', 'ValidityTime', 'LinkValidityTime'
        ];
    }
}