<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 13:37
 */

namespace BlueMediaConnector\ValueObject;



class Currency extends Enum
{
    const PLN = 'PLN';

    public static function fromNative()
    {
        if(($value = strval(func_get_arg(0))) == "") {
            // wartosc domyslna i poki co jedyna w ofercie BM
            $value = self::PLN;
        }
        return parent::fromNative($value);
    }
}