<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $productCoupon = new ProductCoupon();
        $productCoupon->ProductCouponId = $_POST['id'];
        $productCoupon->Date = date("Y/m/d");
        $productCoupon->Value = $_POST['value'];
        $productCoupon->Product = $_POST['product'];
        $pcds = new ProductCouponDataSource();
        $pcds->open();
        $pcds->Update($productCoupon);
        $pcds->close();



    } else {

        $productCoupon = new ProductCoupon();
        $productCoupon->Date = date("Y/m/d");
        $productCoupon->Value = $_POST['value'];
        $productCoupon->Product = $_POST['product'];
        $productCoupon->User = $_POST['user'];


        $pcds = new ProductCouponDataSource();
        $pcds->open();
        $pcds->Insert($productCoupon);
        $pcds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteProductCoupon != 1) {
        header('Location:Index.php');
        die();
    }

    $pcds = new ProductCouponDataSource();
    $pcds->open();
    $pcds->Delete($_GET['id']);
    $pcds->close();


}

header('Location:ProductCoupons.php');



