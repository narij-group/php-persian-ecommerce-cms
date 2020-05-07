<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->EditFactorProduct != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
$factorproduct = new FactorProductDataSource();
$factorproduct->open();
$factorproducts = $factorproduct->FillByCode($_GET['code']);

foreach ($factorproducts as $f) {
    if ($f->PaymentStatus == 0 && $f->Status == 0) {

        $pcds = new ProductColorDataSource();
        $pcds->open();
        $productcolor = $pcds->FindOneProductColor2($f->Color, $f->Product->ProductId);
        $productcolor->Quantity = $productcolor->Quantity + $f->Count;
        $pcds->UpdateQuantity($productcolor);
        $pcds->close();

    }
    $factorproduct->Delete($f->FactorProductId);
}

$factorproduct->close();
header('Location:FactorProductsTable.php');