<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 14:54
 */

namespace BlueMediaConnector\ValueObject\Hash\ArgsTransport;


use BlueMediaConnector\ValueObject\Hash;

abstract class AbstractTransport implements ArgsTransportInterface
{
    /**
     * @var array
     */
    protected $args = [];

    public function count()
    {
        return count($this->args);
    }

    public function offsetExists($offset)
    {
        return isset($this->args[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->args[$offset];
    }

    /**
     * @return array
     */
    abstract protected function hashParamsOrder();

    public function offsetSet($offset, $value)
    {
        $hashParamOrder = $this->hashParamsOrder();

        if (!in_array($offset, $hashParamOrder)) {
            throw new \InvalidArgumentException("Invalid parameter " . $offset);
        }

        $this->args[$offset] = $value;
        $this->orderByKey($this->args, $hashParamOrder);
    }

    protected function orderByKey(&$array, $paramOrder)
    {
        uksort($array, function ($key1, $key2) use ($paramOrder) {
            return array_search($key1, $paramOrder) - array_search($key2, $paramOrder);
        });
    }

    public function offsetUnset($offset)
    {
        unset($this->args[$offset]);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->args;
    }
}