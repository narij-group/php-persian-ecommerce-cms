<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $price = new Price();
        $price->PriceId = $_POST['id'];
        $_POST['value'] = str_replace(',', '', $_POST['value']);
        $price->Value = $_POST['value'];


        $pds = new PriceDataSource();
        $pds->open();
        $pds->Update($price);
        $pds->close();

        if (!isset($_POST['pid'])) {
            header('Location:Prices.php');
        } else {
            header('Location:Prices.php?id=' . $_POST['pid']);
        }



    } else {

        $price = new Price();
        $price->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
        $_POST['value'] = str_replace(',', '', $_POST['value']);
        $price->Value = $_POST['value'];
        $price->User = $_POST['user'];
        $price->Date = date("Y/m/d");

        $pds = new PriceDataSource();
        $pds->open();
        $pds->Insert($price);
        $pds->close();


        header('Location:Prices.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeletePrice != 1) {
        header('Location:Index.php');
        die();
    }

    $pds = new PriceDataSource();
    $pds->open();
    $pds->Delete($_GET['id']);
    $pds->close();


    if (!isset($_GET['pid']))
    {
        header('Location:Prices.php');
    }
    else {
        header('Location:Prices.php?id='.$_GET['pid']);
    }

}




