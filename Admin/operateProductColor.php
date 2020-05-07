<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

        $productcolor = new ProductColor();
        $productcolor->ProductColorId = $_POST['id'];
        $productcolor->Name = $_POST['name'];
        $productcolor->Quantity = $_POST['quantity'];

        $pds = new ProductColorDataSource();
        $pds->open();
        $pds->Update($productcolor);
        $pds->close();
        if (!isset($_POST['pid'])) {
            header('Location:ProductColors.php');
        } else {
            header('Location:ProductColors.php?id=' . $_POST['pid']);
        }




    } else {

        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

        $productcolor = new ProductColor();
        $productcolor->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
        $productcolor->Name = $_POST['name'];
        $productcolor->Quantity = $_POST['quantity'];

        $pcds = new ProductColorDataSource();
        $pcds->open();
        $pcds->Insert($productcolor);
        $pcds->close();
        header('Location:ProductColors.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
    require_once 'Template/top2.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/ProductColorDataSource.inc';
    $productcolor = new ProductColorDataSource();
    $productcolor ->open();
    $productcolor->Delete($_GET['id']);
    $productcolor ->close();
    if (!isset($_GET['pid'])) {
        header('Location:ProductColors.php');
    } else {
        header('Location:ProductColors.php?id=' . $_GET['pid']);
    }

}




