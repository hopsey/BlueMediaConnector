<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 13:01
 */

namespace BlueMediaConnector\ValueObject;


final class Hash extends StringValue
{
    public function toNative()
    {
        // nie mozna wyciagnac z hasha danych wejsciowych. Error logiczny
        throw new \LogicException("Operation not supported");
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}