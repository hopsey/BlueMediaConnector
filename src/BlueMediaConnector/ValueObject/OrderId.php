<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 14:27
 */

namespace BlueMediaConnector\ValueObject;


class OrderId implements ValueObjectInterface
{
    use SimpleValueObjectTrait;

    public static function fromNative()
    {
        return new static(md5(microtime() . rand(0,100000)));
    }
}