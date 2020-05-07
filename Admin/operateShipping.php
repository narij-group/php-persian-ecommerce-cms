<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';
        $sds = new ShippingDataSource();
        $sds->open();
        $shipping = new Shipping();
        $shipping->ShippingId = $_POST['id'];
        $_POST['price'] = str_replace(',', '', $_POST['price']);
        $shipping->Price = $_POST['price'];
        $sds->Update($shipping);
        $sds->close();
        header('Location:Shippings.php');


    } else {

        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';
        $sds = new ShippingDataSource();
        $sds->open();
        for ($i = 0; isset($_POST["fieldvalue$i"]); $i++) {
            $shipping = new Shipping();
            $shipping->City = $_POST["fieldname$i"];
            $_POST["fieldvalue$i"] = str_replace(',', '', $_POST["fieldvalue$i"]);
            $shipping->Price = $_POST["fieldvalue$i"];
            if (trim($shipping->Price) != "") {
                $sds->Insert($shipping);
            }
        }


        $sds->close();
        header('Location:Shippings.php');

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
    require_once 'Template/top2.php';
    if ($role->DeleteShipping != 1) {
        header('Location:Index.php');
        die();
    }
    require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/ShippingDataSource.inc';
    $sds = new ShippingDataSource();
    $sds->open();
    $sds->Delete($_GET['id']);
    $sds->close();
    header('Location:Shippings.php');
}




