<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ServiceDataSource.inc';

$sds = new ServiceDataSource();
$sds->open();
$service = new Service();
$service->Name = $_POST["name"];
$service->Activated = $_POST["activated"];
$_POST['price'] = str_replace(',', '', $_POST['price']);
$service->Price = $_POST["price"];
//$service->Insert();
$sds->Insert($service);
$sds->close();

header('Location:Services.php');
