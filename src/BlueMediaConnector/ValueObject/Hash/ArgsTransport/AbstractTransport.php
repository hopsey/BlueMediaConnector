<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 14:54
 */

namespace BlueMediaConnector\ValueObject\Hash\ArgsTransport;


abstract class AbstractTransport implements ArgsTransportInterface
{
    private $args = [];

    public function count()
    {
        return count($this->args);
    }

    public function current()
    {
        return current($this->args);
    }

    public function next()
    {
        return next($this->args);
    }

    public function key()
    {
        return key($this->args);
    }

    public function valid()
    {
        return key($this->args) !== null;
    }

    public function rewind()
    {
        return reset($this->args);
    }

    public function offsetExists($offset)
    {
        return isset($this->args[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->args[$offset];
    }

    abstract protected function hashParamsOrder();

    public function offsetSet($offset, $value)
    {
        $hashParamOrder = $this->hashParamsOrder();

        if (!in_array($offset, $hashParamOrder)) {
            throw new \InvalidArgumentException("Invalid parameter " . $offset);
        }

        $this->args[$offset] = $value;
        uksort($this->args, function ($key1, $key2) use ($hashParamOrder) {
            return array_search($key1, $hashParamOrder) - array_search($key2, $hashParamOrder);
        });
    }

    public function offsetUnset($offset)
    {
        unset($this->args[$offset]);
    }

}