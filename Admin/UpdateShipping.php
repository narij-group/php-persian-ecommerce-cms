<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';
$sds = new ShippingDataSource();
$sds->open();
$shipping = new Shipping();
$shipping->ShippingId = $_POST['id'];
$_POST['price'] = str_replace(',', '', $_POST['price']);
$shipping->Price = $_POST['price'];
$sds->Update($shipping);
$sds->close();
header('Location:Shippings.php');