<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteBrand != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LogoDataSource.inc';

$lds = new LogoDataSource();
$lds->open();

$logos = $lds->FindOneLogoBasedOnId($_GET['id']);
if (file_exists("../" . $logos->Image)) {
    unlink('../' . $logos->Image);
}

$lds->Delete($_GET['id']);
header('Location:Logos.php');
