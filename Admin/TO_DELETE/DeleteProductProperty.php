<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteProductProperty != 1) {
   header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';
$ppds = new ProductPropertyDataSource();
$ppds->open();
$ppds->Delete($_GET['id']);
$ppds->close();
header('Location:ProductProperties.php');