<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteUserCoupon != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';
$userCoupon = new UserCouponDataSource();
$userCoupon->open();
$userCoupon->Delete($_GET['id']);
$userCoupon->close();
header('Location:UserCoupons.php');
