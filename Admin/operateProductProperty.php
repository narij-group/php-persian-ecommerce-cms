<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $productProperty = new ProductProperty();
        $productProperty->ProductPropertyId = $_POST['id'];
        $productProperty->Name = $_POST['name'];
        $productProperty->Value = $_POST['value'];
//$productProperty->Group = $_POST['subgroup'];
        $ppds = new ProductPropertyDataSource();
        $ppds->open();
        $ppds->Update($productProperty);
        $ppds->close();

    } else {
        $productProperty = new ProductProperty();
        $productProperty->Name = $_POST['name'];
        $productProperty->Value = $_POST['value'];
        $productProperty->Group = $_POST['subgroup'];

        $ppds = new ProductPropertyDataSource();
        $ppds->open();
        $ppds->Insert($productProperty);
        $ppds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($role->DeleteProductProperty != 1) {
        header('Location:Index.php');
        die();
    }
    $ppds = new ProductPropertyDataSource();
    $ppds->open();
    $ppds->Delete($_GET['id']);
    $ppds->close();
}

header('Location:ProductProperties.php');


