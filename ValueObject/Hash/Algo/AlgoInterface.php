<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 13:16
 */

namespace BlueMediaConnector\ValueObject\Hash\Algo;


interface AlgoInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function hash($string);
}