<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 12:35
 */

namespace BlueMediaConnector;


use BlueMediaConnector\ValueObject\Hash\HashFactory;
use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\StringValue;
use BlueMediaConnector\ValueObject\Url;

final class Factory
{
    /**
     * @param string $serviceUrl
     * @param string $serviceId
     * @param string $secret
     * @return BMService
     */
    public static function build($serviceUrl, $serviceId, $secret)
    {
        $connector = new Connector(
            Url::fromNative($serviceUrl),
            IntegerNumber::fromNative($serviceId),
            StringValue::fromNative($secret)
        );

        $bmService = new BMService($connector);
        $bmService->setHashFactory(new HashFactory(
            $connector->getSecret()
        ));
        return $bmService;
    }
}