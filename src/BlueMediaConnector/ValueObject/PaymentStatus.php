<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 23:05
 */

namespace BlueMediaConnector\ValueObject;


class PaymentStatus extends Enum
{
    const PENDING = 'PENDING';
    const SUCCESS = 'SUCCESS';
    const FAILURE = 'FAILURE';
}