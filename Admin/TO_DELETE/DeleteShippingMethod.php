<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteShippingMethod != 1) {
   header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingMethodDataSource.inc';
$smds = new ShippingMethodDataSource();
$smds->open();
$smds->Delete($_GET["id"]);
$smds->close();
header('Location:ShippingMethods.php');
