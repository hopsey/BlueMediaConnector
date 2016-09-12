<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 01/09/16
 * Time: 23:04
 */

namespace BlueMediaConnector\Message;


use BlueMediaConnector\Message\ResultResponse\TransactionResult;
use BlueMediaConnector\ValueObject\ConfirmationResult;
use BlueMediaConnector\ValueObject\Hash\ArgsTransport\ResultResponseArgs;
use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\OrderId;

class ResultResponseMessage extends AbstractMessage implements OutgoingMessageInterface
{
    /**
     * @var IntegerNumber
     */
    private $serviceID;

    /**
     * @var OrderId
     */
    private $orderID;

    /**
     * @var ConfirmationResult
     */
    private $confirmation;

    /**
     * TransactionResult constructor.
     * @param IntegerNumber $serviceId
     * @param OrderId $orderId
     * @param ConfirmationResult $confirmation
     */
    public function __construct(IntegerNumber $serviceId, OrderId $orderId, ConfirmationResult $confirmation)
    {
        $this->serviceID = $serviceId;
        $this->orderID = $orderId;
        $this->confirmation = $confirmation;
    }


    protected function getArgsToComputeHash()
    {
        $args = new ResultResponseArgs();
        $args['serviceID'] = $this->serviceID;
        $args['orderID'] = $this->orderID;
        $args['confirmation'] = $this->confirmation;

        return $args;
    }

    public function getArrayToExecute()
    {
        $structure = [
            'Confirmation' => [
                '@attributes' => [
                    "xmlns" => "http://company.corp/service"
                ],
                'serviceID' => (string)$this->serviceID,
                'orderID' => (string)$this->orderID,
                'confirmation' => (string)$this->confirmation,
            ]
        ];

        return $structure;
    }

}