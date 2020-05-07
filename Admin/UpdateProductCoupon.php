<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';

$productCoupon = new ProductCoupon();
$productCoupon->ProductCouponId = $_POST['id'];
$productCoupon->Date = date("Y/m/d");
$productCoupon->Value = $_POST['value'];
$productCoupon->Product = $_POST['product'];
$pcds = new ProductCouponDataSource();
$pcds->open();
$pcds->Update($productCoupon);
$pcds->close();

header('Location:ProductCoupons.php');
