<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
$price = new Price();
$price->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$_POST['value'] = str_replace(',', '', $_POST['value']);
$price->Value = $_POST['value'];
$price->User = $_POST['user'];
$price->Date = date("Y/m/d");

$pds = new PriceDataSource();
$pds->open();
$pds->Insert($price);
$pds->close();


header('Location:Prices.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);
