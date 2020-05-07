<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/OrderDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Globals/Sessions.php';
date_default_timezone_set("Asia/Tehran");
$dateNow = date_create();

session_start();
if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
    $cds = new CustomerDataSource();
    $cds->open();
    $customer = $cds->FindOneCustomerBasedOnId($_COOKIE[COOKIE_CUSTOMER_ID]);
    $cds->close();

    $ods = new OrderDataSource();
    $ods->open();
    $order = new Order();

    if (!file_exists($_FILES['file']['tmp_name'] . '/' . $_FILES['file']['name'])) {
        $order->Customer = $customer->getCustomerId();
        $order->Content = $_POST['content'];
        $order->SupperGroup = $_POST['suppergroup'];
        $order->File = "";
        $order->Date = $dateNow->format("Y/m/d");
        $order->Status = 0;
        $order->Replay = "";
        $order->OrderId = $ods->Insert($order);

        $path = __DIR__ . "/OrderFiles/" . $order->OrderId . "/";


        if (!is_dir($path)) {
            @mkdir($path);
        }

        $path = $path . $_FILES['file']['name'];


        move_uploaded_file($_FILES['file']['tmp_name'], $path);

        if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
            $path2 = "/DigitalShopV2/OrderFiles/" . $order->OrderId . "/" . $_FILES['file']['name'];
        } else {
            $path2 = "OrderFiles/" . $order->OrderId . "/" . $_FILES['file']['name'];;
        }

        $order->File = $path2;
        $ods->Update($order);
        $ods->close();
        header("location:Order.php?status=OK");

    } else {
        $order->Customer = $customer->getCustomerId();
        $order->Content = $_POST['content'];
        $order->SupperGroup = $_POST['suppergroup'];
        $order->File = "";
        $order->Date = $dateNow->format("Y/m/d");
        $order->Status=0;
        $order->Replay="";
        $ods->Insert($order);
        header("location:Order.php?status=OK");
    }


}
