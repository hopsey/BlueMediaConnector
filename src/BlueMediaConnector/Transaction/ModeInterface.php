<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 15:07
 */

namespace BlueMediaConnector\Transaction;


use BlueMediaConnector\Connector;

interface ModeInterface
{
    public function serve(Connector $connector, array $args);
}