<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 01/09/16
 * Time: 23:04
 */

namespace BlueMediaConnector\Message;


use BlueMediaConnector\Message\ResultResponse\TransactionResult;
use BlueMediaConnector\ValueObject\Hash\ArgsTransport\ResultResponseArgs;
use BlueMediaConnector\ValueObject\IntegerNumber;

class ResultResponseMessage extends AbstractMessage implements OutgoingMessageInterface
{
    /**
     * @var IntegerNumber
     */
    private $serviceId;

    /**
     * @var TransactionResult[]
     */
    private $results = [];

    /**
     * ResultResponseMessage constructor.
     * @param IntegerNumber $serviceId
     */
    public function __construct(IntegerNumber $serviceId)
    {
        $this->serviceId = $serviceId;
    }

    /**
     * @param TransactionResult $result
     */
    public function attachTransactionResult(TransactionResult $result)
    {
        $this->results[] = $result;
    }

    protected function getArgsToComputeHash()
    {
        $args = new ResultResponseArgs();
        $args['serviceID'] = $this->serviceId;
        foreach ($this->results as $transaction) {
            $args->attachTransactionResult($transaction);
        }

        return $args;
    }

    public function getArrayToExecute()
    {
        $structure = [
            'confirmationList' => [
                'serviceID' => (string)$this->serviceId,
                'transactionsConfirmations' => [
                    'transactionConfirmed' => []
                ]
            ]
        ];

        if (count($this->results) > 0) {
            foreach ($this->results as $result) {
                $structure['confirmationList']['transactionsConfirmations']['transactionConfirmed'][] = $result->toArray();
            }
        }

        return $structure;
    }

}