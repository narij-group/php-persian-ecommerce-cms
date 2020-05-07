<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SettingsDataSource.inc';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();
if ($settings->Tax != 0) {
    $tax = (100 + $settings->Tax) / 100;
} else {
    $tax = 1;
}

require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/GuaranteeDataSource.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/PriceDataSource.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/DiscountDataSource.inc";
$price = new PriceDataSource();
$price->open();
$discount = new DiscountDataSource();
$discount->open();
$g = new GuaranteeDataSource();
$g->open();
if ($_POST['guaranteeId'] != 0) {
    $guarantee = $g->FindOneGuaranteeBasedOnId($_POST['guaranteeId']);
    $guaranteePrice = $guarantee->Guarantee->Price;
} else {
    $guaranteePrice = 0;
}

echo number_format(($price->GetLastPriceForOneProduct($_POST['product']) - ($price->GetLastPriceForOneProduct($_POST['product']) * $discount->GetLastDiscountForOneProduct($_POST['product']) / 100) + $guaranteePrice) * $tax);
