<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 14:54
 */

namespace BlueMediaConnector\ValueObject\Hash\ArgsTransport;


use BlueMediaConnector\ValueObject\Hash;

interface ArgsTransportInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}