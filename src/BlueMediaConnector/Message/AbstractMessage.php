<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 01/09/16
 * Time: 23:58
 */

namespace BlueMediaConnector\Message;


use BlueMediaConnector\ValueObject\Hash\ArgsTransport\ArgsTransportInterface;
use BlueMediaConnector\ValueObject\Hash\HashFactoryInterface;

abstract class AbstractMessage implements MessageInterface
{
    /**
     * @return ArgsTransportInterface
     */
    abstract protected function getArgsToComputeHash();

    public function computeHash(HashFactoryInterface $hashFactory)
    {
        $args = $this->getArgsToComputeHash();
        return $hashFactory->build($args);
    }
}