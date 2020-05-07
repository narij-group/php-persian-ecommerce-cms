<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OrderDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {
        $ods = new OrderDataSource();
        $ods->open();
        $order = new Order();
        $order->OrderId = $_POST['id'];
        $order->Customer = $_POST['customer'];
        $order->Content = $_POST['content'];
        $order->SupperGroup = $_POST['suppergroup'];
        $order->File = $_POST['file'];
        $order->Date = $_POST['date'];
        $order->Status = $_POST['status'];;
        $order->Replay = $_POST['replay'];
        $ods->Update($order);
        $ods->close();
    } else {

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->EditOrder != 1) {
        header('Location:Index.php');
        die();
    }
    $path = __DIR__ . DIRECTORY_SEPARATOR . "../OrderFiles/" . $_GET['id'];
    $ods = new OrderDataSource();
    $ods->open();
    $ods->Delete($_GET['id']);
    echo $path;
    echo $ods->DeleteFolder($path);
    $ods->close();
}
header('Location:Orders.php');