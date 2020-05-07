<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeletePrice != 1) {
   header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';

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
