<?php

require_once 'vendor/autoload.php';


$bmService = \BlueMediaConnector\Factory::build(
    'https://pay-accept.bm.pl/payment',
    100510,
    '050371b93e39f68c531722b65f0a9ab9952879ba'
);

var_dump($bmService->receiveItnResult(file_get_contents('../test/untitled.xml')));

exit;

$bmService->makeTransaction(new \BlueMediaConnector\Transaction\RedirectMode(), 10.50);