<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';
$productProperty = new ProductProperty();
$productProperty->ProductPropertyId = $_POST['id'];
$productProperty->Name = $_POST['name'];
$productProperty->Value = $_POST['value'];
//$productProperty->Group = $_POST['subgroup'];
$ppds = new ProductPropertyDataSource();
$ppds->open();
$ppds->Update($productProperty);
$ppds->close();
header('Location:ProductProperties.php');