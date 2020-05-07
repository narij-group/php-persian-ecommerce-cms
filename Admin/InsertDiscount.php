<?php
require_once 'Template/top2.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
$discount = new Discount();
$discount->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$discount->Value = $_POST['value'];
$discount->User = $_POST['user'];

$dds = new DiscountDataSource();
$dds->open();
$dds->Insert($discount);
$dds->close();
if (trim($_SESSION[SESSION_INT_PRODUCT_ID]) == "") {
    header('Location:Discounts.php');
} else {
    header('Location:Discounts.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);
}
