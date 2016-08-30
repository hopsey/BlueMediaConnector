<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 14:18
 */

namespace BlueMediaConnector\ValueObject;


use Zend\Validator\StaticValidator;

class Url implements ValueObjectInterface
{
    use SimpleValueObjectTrait;

    const ERR_INVALID_URL = 'invalidUrl';

    public function __construct($url)
    {
        if (!StaticValidator::execute($url, "Uri")) {
            throw new InvalidNativeArgumentException("Invalid URL", self::ERR_INVALID_URL);
        }

        $this->value = $url;
    }
}