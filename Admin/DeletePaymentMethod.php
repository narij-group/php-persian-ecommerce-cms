<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeletePaymentMethod != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PaymentMethodDataSource.inc';
$pmds = new PaymentMethodDataSource();
$pmds->open();
$pmds->Delete($_GET["id"]);
$pmds->close();
//$paymentmethod = new PaymentMethod();
//$paymentmethod->PaymentMethodId = $_GET["id"];
//$paymentmethod->Delete();
header('Location:PaymentMethods.php');
