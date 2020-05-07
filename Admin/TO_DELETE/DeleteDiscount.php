<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteDiscount != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';

$dds = new DiscountDataSource();
$dds->open();
$dds->Delete($_GET['id']);
$dds->close();
$route = 'Discounts.php';
if (isset($_SESSION[SESSION_INT_PRODUCT_ID]) == TRUE) {
    $route = $route . '?id=' . $_SESSION[SESSION_INT_PRODUCT_ID];
}
header('Location:' . $route);


