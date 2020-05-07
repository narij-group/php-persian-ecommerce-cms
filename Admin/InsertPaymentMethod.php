<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PaymentMethodDataSource.inc';
$paymentmethod = new PaymentMethod();
$paymentmethod->Name = $_POST["name"];
$paymentmethod->Activated = $_POST["activated"];
$pmds = new PaymentMethodDataSource();
$pmds->open();
$pmds->Insert($paymentmethod);
$pmds->close();
header('Location:PaymentMethods.php');
