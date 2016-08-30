<?php

require_once 'vendor/autoload.php';

$bmService = \BlueMediaConnector\Factory::build(
    'https://pay-accept.bm.pl/payment',
    100510,
    'secret'
);

