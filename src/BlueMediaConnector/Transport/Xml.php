<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 20:39
 */

namespace BlueMediaConnector\Transport;


use LaLit\Array2XML;

class Xml implements TransportInterface
{
    public function decode($content)
    {
        $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA);

        $array = (array)$xml->transactions->transaction;

        $array['serviceID'] = (string)$xml->serviceID;
        $array['docHash'] = (string)$xml->hash;
        return $array;


        // TODO ten fragment dotyczy tylko jednej wiadomości. nalezy to stad wyseparować, bo to uniwersalna klasa.
        $array = $array['Body']['Transaction'];
        $array['currency'] = $array['amount']['currency'];
        $array['amount'] = $array['amount']['value'];
        return $array;
    }

    public function encode(array $array)
    {
        $array = $array['Confirmation'];
        $arr = [
            'serviceID' => $array['serviceID'],
            'transactionsConfirmations' => [
                'transactionConfirmed' => [
                    'orderID' => $array['orderID'],
                    'confirmation' => $array['confirmation']
                ]
            ],
            'hash' => $array['docHash']
        ];

//        $soapArray = [
//            '@attributes' => [
//                'xmlns:env' => 'http://schemas.xmlsoap.org/soap/envelope/'
//            ],
//            'env:Header' => [],
//            'env:Body' => $array
//        ];
        return Array2XML::createXML('confirmationList', $arr)->saveXML();
    }
}