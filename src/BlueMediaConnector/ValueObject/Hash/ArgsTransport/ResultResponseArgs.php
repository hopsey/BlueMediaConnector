<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 01/09/16
 * Time: 23:46
 */

namespace BlueMediaConnector\ValueObject\Hash\ArgsTransport;


use BlueMediaConnector\Message\ResultResponse\TransactionResult;

class ResultResponseArgs extends AbstractTransport
{
    /**
     * @return array
     */
    protected function hashParamsOrder()
    {
        return ['serviceID', 'orderID', 'confirmation'];
    }
}