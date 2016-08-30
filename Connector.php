<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 14:00
 */

namespace BlueMediaConnector;


use Zend\Validator\StaticValidator;

class Connector
{
    public function __construct($serviceUrl, $serviceId, $secret)
    {
        if (!StaticValidator::execute($serviceUrl, "Uri")) {
            throw new \InvalidArgumentException("");
        }
    }
}