<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 13:49
 */

namespace BlueMediaConnector\ValueObject;


use Zend\Filter\StaticFilter;
use Zend\Validator\StaticValidator;

class Email extends StringValue
{
    const ERR_INVALID_EMAIL = 'invalidEmail';

    public function __construct($value)
    {
        parent::__construct($value);
        $value = StaticFilter::execute($value, 'StringTrim');
        if(!StaticValidator::execute($value, 'EmailAddress')) {
            throw new InvalidNativeArgumentException("Invalid e-mail address", self::ERR_INVALID_EMAIL);
        }

        $this->value = $value;
    }
}