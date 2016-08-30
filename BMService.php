<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 12:44
 */

namespace BlueMediaConnector;


use BlueMediaConnector\ValueObject\Currency;
use BlueMediaConnector\ValueObject\Email;
use BlueMediaConnector\ValueObject\FloatNumber;
use BlueMediaConnector\ValueObject\IntegerNumber;
use BlueMediaConnector\ValueObject\StringValue;

/**
 * Klasa reprezentujaca funkcjonalnosci API BM
 * TODO w przyszlosci przeimplementowac na komendy
 * @package BlueMediaConnector
 */
class BMService
{
    public function __construct(Connector $connector)
    {

    }

    public function makeTransaction(FloatNumber $amount, StringValue $description = null, IntegerNumber $gatewayId = null,
        Currency $currency = null, Email$customerEmail = null)
    {

    }
}