<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorDataSource.inc';
$factor = new FactorDataSource();
$factor->open();
$factor->Delete($_GET['id']);
$factor->close();
header('Location:Factores.php');
