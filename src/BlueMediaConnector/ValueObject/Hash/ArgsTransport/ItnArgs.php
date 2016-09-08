<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 16:26
 */

namespace BlueMediaConnector\ValueObject\Hash\ArgsTransport;


class ItnArgs extends AbstractTransport
{
    private static $customerData = [
        'fName', 'lName', 'streetName', 'streetHouseNo', 'streetStaircaseNo', 'streetPremiseNo', 'postalCode', 'city', 'nrb', 'senderData'
    ];

    protected function hashParamsOrder()
    {
        return ['serviceID', 'orderID', 'remoteID', 'amount', 'currency', 'gatewayID', 'paymentDate', 'paymentStatus', 'paymentStatusDetails',
            'paymentStatusDetails', 'addressIP', 'title', 'customerData'];
    }

    public function toArray()
    {
        $result = $this->args;

        if (isset($result['customerData'])) {
            $customerData = $result['customerData'];
            unset($result['customerData']);
            $this->orderByKey($customerData, self::$customerData);

            foreach ($customerData as $cKey => $data) {
                $result[$cKey] = $data;
            }
        }
        return $result;
    }
}