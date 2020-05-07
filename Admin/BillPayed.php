<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->EditFactorProduct != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';

$FactorProduct = new FactorProductDataSource();
$FactorProduct->open();
$records = $FactorProduct->FillByCode($_GET['code']);
foreach ($records as $record) {
    $FactorProduct->UpdatePaymentStatus($record->FactorProductId, 1);
}
$FactorProduct->close();
header('Location:FactorProducts.php?code=' . $_GET['code']);
