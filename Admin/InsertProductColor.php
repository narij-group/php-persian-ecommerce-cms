<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

$productcolor = new ProductColor();
$productcolor->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$productcolor->Name = $_POST['name'];
$productcolor->Quantity = $_POST['quantity'];

$pcds = new ProductColorDataSource();
$pcds->open();
$pcds->Insert($productcolor);
$pcds->close();
header('Location:ProductColors.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);
