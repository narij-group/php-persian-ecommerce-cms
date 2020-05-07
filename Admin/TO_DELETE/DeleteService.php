<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";


require_once 'Template/top2.php';
if ($role->DeleteService != 1) {
   header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ServiceDataSource.inc';

$sds = new ServiceDataSource();
$sds->open();
$sds->Delete($_GET["id"]);
$sds->close();
header('Location:Services.php');
