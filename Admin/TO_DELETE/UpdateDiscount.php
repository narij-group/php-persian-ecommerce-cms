<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
$discount = new Discount();
$discount->DiscountId = $_POST['id'];
$discount->Value = $_POST['value'];
$dds = new DiscountDataSource();
$dds->open();
$dds->Update($discount);
$dds->close();

if (trim($_SESSION[SESSION_INT_PRODUCT_ID]) == "") {
    header('Location:Discounts.php');
} else {
    header('Location:Discounts.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);
}

