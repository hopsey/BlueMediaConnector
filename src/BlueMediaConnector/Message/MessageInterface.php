<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 17:46
 */

namespace BlueMediaConnector\Message;


use BlueMediaConnector\ValueObject\Hash\HashFactoryInterface;

interface MessageInterface
{
    public function computeHash(HashFactoryInterface $hashFactory);
}