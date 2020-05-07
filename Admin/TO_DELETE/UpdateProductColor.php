<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

$productcolor = new ProductColor();
$productcolor->ProductColorId = $_POST['id'];
$productcolor->Name = $_POST['name'];
$productcolor->Quantity = $_POST['quantity'];

$pds = new ProductColorDataSource();
$pds->open();
$pds->Update($productcolor);
$pds->close();
if (!isset($_POST['pid'])) {
    header('Location:ProductColors.php');
} else {
    header('Location:ProductColors.php?id=' . $_POST['pid']);
}

