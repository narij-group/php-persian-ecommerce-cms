<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
$productAndProperty = new ProductAndProperty();
$productAndProperty->ProductAndPropertyId = $_POST['id'];
$productAndProperty->Value = $_POST['value'];
$productAndProperty->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$productAndProperty->ProductProperty->ProductPropertyId = $_POST['productPropertyId'];

$ppds = new ProductAndPropertyDataSource();
$ppds->open();
$ppds->Update($productAndProperty);
$ppds->close();
header('Location:ProductAndProperties.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);