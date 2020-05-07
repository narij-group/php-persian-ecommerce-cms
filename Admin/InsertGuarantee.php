<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
$guarantee = new Guarantee();
$guarantee->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$guarantee->Name = $_POST['name'];
$guarantee->Guarantee = $_POST['guarantee'];
$guarantee->Date = date("Y/m/d");

$gds = new GuaranteeDataSource();
$gds->open();
$gds->Insert($guarantee);
$gds->close();
header('Location:Guarantees.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);
