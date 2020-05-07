<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
$price = new Price();
$price->PriceId = $_POST['id'];
$_POST['value'] = str_replace(',', '', $_POST['value']);
$price->Value = $_POST['value'];


$pds = new PriceDataSource();
$pds->open();
$pds->Update($price);
$pds->close();

if (!isset($_POST['pid'])) {
    header('Location:Prices.php');
} else {
    header('Location:Prices.php?id=' . $_POST['pid']);
}

