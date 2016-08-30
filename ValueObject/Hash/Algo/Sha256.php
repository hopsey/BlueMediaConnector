<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 13:17
 */

namespace BlueMediaConnector\ValueObject\Hash\Algo;


final class Sha256 implements AlgoInterface
{
    /**
     * @param string $string
     * @return string
     */
    public function hash($string)
    {
        return hash("sha256", $string);
    }
}