<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
$productAndProperty = new ProductAndPropertyDataSource();
$productAndProperty->open();
$productAndProperty->Delete($_GET['id']);
$productAndProperty->close();
header('Location:ProductAndPropertiesIFrame.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);