<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteProductCoupon != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';


$pcds = new ProductCouponDataSource();
$pcds->open();
$pcds->Delete($_GET['id']);
$pcds->close();


header('Location:ProductCoupons.php');