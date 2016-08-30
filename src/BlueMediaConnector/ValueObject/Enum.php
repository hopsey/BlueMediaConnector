<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 13:37
 */

namespace BlueMediaConnector\ValueObject;


namespace Application\Model\Domain\ValueObject;

use BlueMediaConnector\ValueObject\InvalidNativeArgumentException;
use BlueMediaConnector\ValueObject\ValueObjectInterface;
use MabeEnum\Enum as BaseEnum;

abstract class Enum extends BaseEnum implements ValueObjectInterface
{
    const ERR_VAL_NOT_IN_STACK = 'valNotInStack';

    public static function fromNative()
    {
        try {
            return static::get($value = func_get_arg(0));
        } catch(\InvalidArgumentException $e) {
            throw new InvalidNativeArgumentException("Value (" . $value . ") does not exist in the stack", self::ERR_VAL_NOT_IN_STACK);
        }
    }

    public function toNative()
    {
        return parent::getValue();
    }

    public function __toString()
    {
        return \strval($this->toNative());
    }
}