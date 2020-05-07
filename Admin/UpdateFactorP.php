<?php
if ($_POST['paymentstatus'] != -1 && $_POST['paymentmethod'] != -1) {
    require_once __DIR__ .DIRECTORY_SEPARATOR .   "../ClassesEx/datasource/FactorProductDataSource.inc";

    $fp = new FactorProductDataSource();
    $fp ->open();
    $fps = $fp->FillByCode($_POST['p-tracecode']);

    foreach ($fps as $f) {
        $fp->UpdatePaymentStatus($f->FactorProductId , $_POST['paymentstatus']);
        $fp->UpdatePaymentMethod( $f->FactorProductId , $_POST['paymentmethod']);
    }
    $fp->close();
}
header('location:FactorProducts.php?code=' . $_POST['p-tracecode']);
