<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';

$dds = new DiscountDataSource();
$dds->open();

$d = $dds->FindOneDiscountBasedOnId($_POST['discountId']);
if ($d->SpecialOffer == 1) {
    $d->SpecialOffer = 0;
    $dds->SetSpecialOffer($d);
} else {
    $d->SpecialOffer = 1;
    $dds->SetSpecialOffer($d);
}    
