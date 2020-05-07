<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
$guarantee = new GuaranteeDataSource();
$guarantee->open();
$guarantee->Delete($_GET['id']);
if (!isset($_GET['pid'])) {
    header('Location:Guarantees.php');
} else {
    header('Location:Guarantees.php?id=' . $_GET['pid']);
}
