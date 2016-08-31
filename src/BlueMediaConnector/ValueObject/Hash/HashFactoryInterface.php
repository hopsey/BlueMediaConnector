<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 16:19
 */

namespace BlueMediaConnector\ValueObject\Hash;


use BlueMediaConnector\ValueObject\Hash\ArgsTransport\ArgsTransportInterface;

interface HashFactoryInterface
{
    public function build(ArgsTransportInterface $args);
}