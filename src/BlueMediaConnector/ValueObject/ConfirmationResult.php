<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 01/09/16
 * Time: 23:08
 */

namespace BlueMediaConnector\ValueObject;


class ConfirmationResult extends Enum
{
    const CONFIRMED = 'CONFIRMED';
    const NOT_CONFIRMED = 'NOTCONFIRMED';
}