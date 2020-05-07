<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';

$purchasebasket = new PurchaseBasketDataSource();
$purchasebasket->open();
$purchasebasket->Delete($_GET['id']);
$purchasebasket->close();
header('Location:../Purchase.php');
