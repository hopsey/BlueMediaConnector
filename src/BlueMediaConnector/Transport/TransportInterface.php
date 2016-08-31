<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 20:38
 */

namespace BlueMediaConnector\Transport;


interface TransportInterface
{
    public function parse($content);
}