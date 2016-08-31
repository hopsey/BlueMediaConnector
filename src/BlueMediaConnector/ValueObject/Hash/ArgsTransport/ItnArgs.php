<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 16:26
 */

namespace BlueMediaConnector\ValueObject\Hash\ArgsTransport;


use BlueMediaConnector\Message\Itn\Transaction;

class ItnArgs extends AbstractTransport
{
    private static $customerData = [
        'fName', 'lName', 'streetName', 'streetHouseNo', 'streetStaircaseNo', 'streetPremiseNo', 'postalCode', 'city', 'nrb'
    ];

    private static $transactionData = ['orderID', 'remoteID', 'amount', 'currency', 'gatewayID', 'paymentDate', 'paymentStatus',
        'paymentStatusDetails', 'addressIP', 'title', 'customerData'];

    /**
     * @var Transaction[]
     */
    private $transactions = [];

    /**
     * @param Transaction $transaction
     */
    public function addTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;
    }

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

            if (isset($result['customerData_' . $key])) {
                $customerData = $result['customerData_' . $key];
                unset($result['customerData_' . $key]);
                $this->orderByKey($customerData, self::$customerData);

                foreach ($customerData as $cKey => $data) {
                    $result[$cKey . "_" . $key] = $data;;
                }
            }
        }
        return $result;
    }
}