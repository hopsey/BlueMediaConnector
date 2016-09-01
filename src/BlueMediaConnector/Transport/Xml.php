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
        $json = json_encode($xml);
        $array = json_decode($json, true);

        // TODO ten fragment dotyczy tylko jednej wiadomości. nalezy to stad wyseparować, bo to uniwersalna klasa.
        if (isset($array['transactions']['transaction'])) {
            $array['transactions'] = array_key_exists(0, $array['transactions']['transaction']) ? $array['transactions']['transaction']
            : [$array['transactions']['transaction']];
        }
        return $array;
    }

    public function encode(array $array)
    {
        $rootNode = key($array);
        return Array2XML::createXML($rootNode, $array[$rootNode])->saveXML();
    }
}