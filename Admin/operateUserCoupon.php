<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $userCoupon = new UserCoupon();
        $userCoupon->UserCouponId = $_POST['id'];
        $userCoupon->Value = $_POST['value'];
        $userCoupon->Date = date("Y/m/d");
        $userCoupon->Time = time();
        $Customer = new CustomerDataSource();
        $Customer->open();
        $userCoupon->Customer = $Customer->FindOneCustomerWithNCode($_POST['customer']);
        $Customer->close();

        $uds = new UserCouponDataSource();
        $uds->open();
        $uds->Update($userCoupon);
        $uds->close();


    } else {


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

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteUserCoupon != 1) {
        header('Location:Index.php');
        die();
    }
    $userCoupon = new UserCouponDataSource();
    $userCoupon->open();
    $userCoupon->Delete($_GET['id']);
    $userCoupon->close();

}
header('Location:UserCoupons.php');




