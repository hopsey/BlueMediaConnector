<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 12:54
 */

namespace BlueMediaConnector\ValueObject;


class FloatNumber implements ValueObjectInterface
{
    const ERR_NOT_FLOAT = 'notFloat';

    use SimpleValueObjectTrait;

    public function __construct($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidNativeArgumentException("Supplied number " . $value . " is not a number",
                self::ERR_NOT_FLOAT);
        }
        $this->value = (float)$value;
    }

}