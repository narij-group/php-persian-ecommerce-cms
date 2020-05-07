<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

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


    } else {

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


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteDiscount != 1) {
        header('Location:Index.php');
        die();
    }

    $dds = new DiscountDataSource();
    $dds->open();
    $dds->Delete($_GET['id']);
    $dds->close();
    $route = 'Discounts.php';
    if (isset($_SESSION[SESSION_INT_PRODUCT_ID]) == TRUE) {
        $route = $route . '?id=' . $_SESSION[SESSION_INT_PRODUCT_ID];
    }
    header('Location:' . $route);


}




