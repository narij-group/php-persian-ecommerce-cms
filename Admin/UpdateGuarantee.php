<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
$guarantee = new Guarantee();
$guarantee->GuaranteeId = $_POST['id'];
$guarantee->Name = $_POST['name'];
$guarantee->Guarantee = $_POST['guarantee'];

$gds = new GuaranteeDataSource();
$gds->open();
$gds->Update($guarantee);
$gds->close();

if (!isset($_POST['pid'])) {
    header('Location:Guarantees.php');
} else {
    header('Location:Guarantees.php?id=' . $_POST['pid']);
}

