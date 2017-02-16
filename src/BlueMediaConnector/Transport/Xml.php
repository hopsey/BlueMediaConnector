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
        $content = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $content);
        $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        $row = $array['transactions']['transaction'];
        $row['serviceID'] = $array['serviceID'];
        return $row;


        // TODO ten fragment dotyczy tylko jednej wiadomości. nalezy to stad wyseparować, bo to uniwersalna klasa.
        $array = $array['Body']['Transaction'];
        $array['currency'] = $array['amount']['currency'];
        $array['amount'] = $array['amount']['value'];
        return $array;
    }

    public function encode(array $array)
    {
        $soapArray = [
            '@attributes' => [
                'xmlns:env' => 'http://schemas.xmlsoap.org/soap/envelope/'
            ],
            'env:Header' => [],
            'env:Body' => $array
        ];
        return Array2XML::createXML('env:Envelope', $soapArray)->saveXML();
    }
}