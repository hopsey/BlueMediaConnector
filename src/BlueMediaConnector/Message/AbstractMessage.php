<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 12:21
 */

namespace BlueMediaConnector\Message;


abstract class AbstractMessage
{
    public function __get($name, $value)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return null;
    }
}