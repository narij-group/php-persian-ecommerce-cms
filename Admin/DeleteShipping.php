<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteShipping != 1) {
   header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/ShippingDataSource.inc';
$sds = new ShippingDataSource();
$sds->open();
$sds->Delete($_GET['id']);
$sds->close();
header('Location:Shippings.php');