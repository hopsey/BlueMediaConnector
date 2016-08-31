<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 22:59
 */

namespace BlueMediaConnector\Message;


use BlueMediaConnector\Message\Itn\Transaction;
use BlueMediaConnector\ValueObject\Hash;
use BlueMediaConnector\ValueObject\IntegerNumber;

class Itn
{
    /**
     * @var IntegerNumber
     */
    private $serviceId;

    /**
     * @var Hash
     */
    private $hash;

    /**
     * @var Transaction[]
     */
    private $transactions = [];

    /**
     * Itn constructor.
     * @param IntegerNumber $serviceId
     * @param Hash $hash
     */
    public function __construct(IntegerNumber $serviceId, Hash $hash)
    {
        $this->serviceId = $serviceId;
        $this->hash = $hash;
    }

    /**
     * @param Transaction $transaction
     */
    public function attachTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;
    }

    /**
     * @return Itn\Transaction[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
}