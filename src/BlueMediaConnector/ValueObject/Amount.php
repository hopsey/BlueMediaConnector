<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 01/09/16
 * Time: 13:50
 */

namespace BlueMediaConnector\ValueObject;


class Amount extends FloatNumber
{
    public function __toString()
    {
        return trim(sprintf("%10.2f", $this->toNative()));
    }
}