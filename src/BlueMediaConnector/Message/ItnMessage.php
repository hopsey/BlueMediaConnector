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

class ItnMessage extends AbstractMessage
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

    protected function getArgsToComputeHash()
    {
        $args = new Hash\ArgsTransport\ItnArgs();
        $args['serviceID'] = $this->serviceId;
        foreach ($this->transactions as $transaction) {
            $args->addTransaction($transaction);
        }

        return $args;
    }

    public function isHashValid(Hash\HashFactoryInterface $hashFactory)
    {
        return (string)$this->hash == (string)$this->computeHash($hashFactory);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return null;
    }

    public function toArray()
    {
        $array = [
            'serviceID' => (string)$this->serviceId,
            'hash' => (string)$this->hash,
            'transactions' => []
        ];
        foreach ($this->transactions as $transaction) {
            $array['transactions'][] = $transaction->toArray();
        }
        return $array;
    }
}