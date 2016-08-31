<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 14:00
 */

namespace BlueMediaConnector;


use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\StringValue;
use BlueMediaConnector\ValueObject\Url;
use Zend\Validator\StaticValidator;

class Connector
{
    /**
     * @var Url
     */
    private $serviceUrl;

    /**
     * @var IntegerNumber
     */
    private $serviceId;

    /**
     * @var StringValue
     */
    private $secret;

    /**
     * Connector constructor.
     * @param $serviceUrl
     * @param $serviceId
     * @param $secret
     */
    public function __construct(Url $serviceUrl, IntegerNumber $serviceId, StringValue $secret)
    {
        $this->serviceUrl = $serviceUrl;
        $this->serviceId = $serviceId;
        $this->secret = $secret;
    }

    /**
     * @return StringValue
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @return IntegerNumber
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @return Url
     */
    public function getServiceUrl()
    {
        return $this->serviceUrl;
    }
}