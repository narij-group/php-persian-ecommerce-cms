<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

$userCoupon = new UserCoupon();
$userCoupon->Value = $_POST['value'];
$userCoupon->Date = date("Y/m/d");
$userCoupon->Time = time();
$Customer = new CustomerDataSource();
$Customer->open();
$userCoupon->Customer = $Customer->FindOneCustomerWithNCode($_POST['customer']);
$Customer->close();

$uds = new UserCouponDataSource();
$uds->open();
$uds->Insert($userCoupon);
$uds->close();
header('Location:UserCoupons.php');