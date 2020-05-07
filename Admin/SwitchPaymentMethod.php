<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PaymentMethodDataSource.inc';

$pmds = new PaymentMethodDataSource();
$pmds->open();


$paymentmethod = new PaymentMethod();
$paymentmethod->PaymentMethodId = $_GET["id"];
$paymentmethod = $pmds->FindOnePaymentMethodBasedOnId($_GET["id"]);
if ($paymentmethod->Activated == 0) {
    $paymentmethod->Activated = 1;
} else {
    $paymentmethod->Activated = 0;
}

$pmds->SwitchStatus($paymentmethod);
$pmds->close();
//$paymentmethod->SwitchStatus();
header('Location:PaymentMethods.php');
