<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LogoDataSource.inc';
$lds = new LogoDataSource();
$lds->open();
$logo = new Logo();
$logo->LogoId = $_POST['id'];
$_POST['image'] = str_replace('/DigitalShopV1/CompanyLogos//', 'CompanyLogos/', $_POST['image']);
$logo->Image = $_POST['image'];
$logo->Name = $_POST['name'];
$logo->Activated = $_POST['activated'];
$logo->LatinName = $_POST['latinname'];
$lds->Update($logo);
$lds->close();
header('Location:Logos.php');
