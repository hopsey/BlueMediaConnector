<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 16:05
 */

namespace BlueMediaConnector\ValueObject;


class PaymentStatusDetails extends Enum
{
    const AUTHORIZED = 'AUTHORIZED';
    const ACCEPTED = 'ACCEPTED';
    const REJECTED = 'REJECTED';
    const INCORRECT_AMOUNT = 'INCORRECT_AMOUNT';
    const EXPIRED = 'EXPIRED';
    const CANCELLED = 'CANCELLED';
    const ANOTHER_ERROR = 'ANOTHER_ERROR';
}