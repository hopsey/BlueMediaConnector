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

    /**
     * @param string|null orderId
     * @return OrderId
     */
    public static function fromNative()
    {
        $arg = @\func_get_arg(0);
        return new static($arg ?: md5(microtime() . rand(0,100000)));
    }
}