<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorDataSource.inc';

$color = new Color();
$color->ColorId = 1;
if ($_POST['green'] != "#000000") {
    $color->Green = $_POST['green'];
}
if ($_POST['darkblue'] != "#000000") {
    $color->DarkBlue = $_POST['darkblue'];
}
if ($_POST['lightblue'] != "#000000") {
    $color->LightBlue = $_POST['lightblue'];
}

$cds = new ColorDataSource();
$cds->open();
$cds->Update($color);
$cds->close();
header('Location:Colors.php');
