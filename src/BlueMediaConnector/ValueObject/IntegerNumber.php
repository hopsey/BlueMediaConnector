<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 27/08/16
 * Time: 14:20
 */

namespace BlueMediaConnector\ValueObject;

class IntegerNumber implements ValueObjectInterface
{
    use SimpleValueObjectTrait;

    const ERR_NOT_INT = 'notInt';

    public function __construct($value)
    {
        if(!is_numeric($value)) {
            throw new InvalidNativeArgumentException("Value is not a number", self::ERR_NOT_INT);
        }
        $this->value = (int)$value;
    }
}