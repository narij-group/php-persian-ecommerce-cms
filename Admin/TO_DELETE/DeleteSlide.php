<?php
//TODO NOT OPTIMISED
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
if ($role->DeleteSlide != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SlideDataSource.inc';
$sds = new SlideDataSource();
$sds->open();

$slide->SlideId = $_GET['id'];
$slides = $sds->FindOneSlideBasedOnId($_GET['id']);
if (file_exists("../" . $slides->Image)) {
    unlink('../' . $slides->Image);
}
$sds->Delete($_GET['id']);
$sds->close();
header('Location:Slides.php');
