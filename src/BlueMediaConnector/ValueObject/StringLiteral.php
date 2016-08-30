<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 13:24
 */

namespace BlueMediaConnector\ValueObject;


class StringLiteral
{
    use SimpleValueObjectTrait;

    const ERR_INVALID_STRING = 'invalidString';

    public function __construct($value)
    {
        if (false === \is_string($value)) {
            throw new InvalidNativeArgumentException("No value or value isn't a string", self::ERR_INVALID_STRING);
        }
        $this->value = $value;
    }
}