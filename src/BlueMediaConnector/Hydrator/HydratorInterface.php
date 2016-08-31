<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 12:35
 */

namespace BlueMediaConnector\Hydrator;


interface HydratorInterface
{
    public function extract($object);
    public function hydrate($object, $data);
    public function build($class, $data);
}