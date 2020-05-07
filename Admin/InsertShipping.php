<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';
$sds = new ShippingDataSource();
$sds->open();
for ($i = 0; isset($_POST["fieldvalue$i"]); $i++) {
    $shipping = new Shipping();
    $shipping->City = $_POST["fieldname$i"];
    $_POST["fieldvalue$i"] = str_replace(',', '', $_POST["fieldvalue$i"]);
    $shipping->Price = $_POST["fieldvalue$i"];
    if (trim($shipping->Price) != "") {
        $sds->Insert($shipping);
    }
}


$sds->close();
header('Location:Shippings.php');