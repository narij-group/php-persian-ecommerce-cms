<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

$product = new Product();
$product->ProductId = $_SESSION[SESSION_INT_PRODUCT_ID];
$product->Keywords = $_POST['keywords'];
$product->MetaDescription = $_POST['metadescription'];

$pds = new ProductDataSource();
$pds->open();

$pds->InsertSEO($product);
$pds->close();
header('Location:Products.php');
