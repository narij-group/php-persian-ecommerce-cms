<?php

//TODO ERROR
require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/FactorProductDataSource.inc";
$factorproduct = new FactorProductDataSource();
$factorproduct->open();
$fps = $factorproduct->FillByCode($_GET['code']);
foreach ($fps as $f) {
    $factoramount = $f->Amount;
    $factor = $factorproduct->FindOneFactorProductBasedOnId($f->FactorProductId);
}

$MerchantID = '4ae923a0-6a2d-11e7-bb3b-000c295eb8fc'; //Required
$Amount = $factoramount; //Amount will be based on Toman - Required
$Description = 'پرداخت صورتحساب از درگاه زرین پال'; // Required
$Email = $factor->Factor->Customer->Email; // Optional
$Mobile = $factor->Factor->Customer->Mobile; // Optional
$domain = $_SERVER['SERVER_NAME'];
$CallbackURL = 'http://' . $domain . '/VerifyPayment2.php'; // Required

$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

$result = $client->PaymentRequest(
    [
        'MerchantID' => $MerchantID,
        'Amount' => $Amount,
        'Description' => $Description,
        'Email' => $Email,
        'Mobile' => $Mobile,
        'CallbackURL' => $CallbackURL,
    ]
);


$factorproduct->Authority = $result->Authority;
foreach ($fps as $f) {
    $f->Authority = $result->Authority;
    $factorproduct->UpdateAuthority($f);
}

$factorproduct->close();


if ($result->Status == 100) {
    header('Location: https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
} else {
    echo 'ERR: ' . $result->Status;
}
