<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
$price = new PriceDataSource();
$price->open();
$prices = $price->Fill();
$Increase = $_POST['value'];
foreach ($prices as $p) {
    $price2 = new Price();
    $price2->PriceId = $p->PriceId;
    $price2->Value = $p->Value + ($p->Value * ($Increase / 100));
    $price->Update($price2);
}
$price->close();
header('Location:Prices.php');

