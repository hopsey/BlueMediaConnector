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
    private static $transactionData = [
        'orderID', 'confirmation'
    ];

    /**
     * @var TransactionResult[]
     */
    private $transactions = [];

    /**
     * @param TransactionResult $transaction
     */
    public function attachTransactionResult(TransactionResult $transaction)
    {
        $this->transactions[] = $transaction;
    }

    /**
     * @return array
     */
    protected function hashParamsOrder()
    {
        return ['serviceID'];
    }

    public function toArray()
    {
        $result = $this->args;
        foreach ($this->transactions as $key => $transaction) {
            $transactionArray = $transaction->toArray();
            $this->orderByKey($transactionArray, self::$transactionData);

            foreach ($transactionArray as $keyT => $value) {
                $result[$keyT . "_" . $key] = $value;
            }
        }
        return $result;
    }
}