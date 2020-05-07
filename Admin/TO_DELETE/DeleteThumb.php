<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteThumb != 1) {
    header('Location:Index.php');
    die();
}

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ThumbDataSource.inc';
$tds = new ThumbDataSource();
$tds->open();
$thumb->ThumbId = $_GET['id'];
$thumbs = $tds->FindOneThumbBasedOnId($_GET['id']);
if (file_exists("../" . $thumbs->Image)) {
    unlink('../' . $thumbs->Image);
}
$tds->Delete($_GET['id']);
header('Location:Thumbs.php');