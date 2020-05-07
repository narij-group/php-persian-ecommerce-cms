<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/NewsDataSource.inc';
$new = new News();
$new->NewsId = $_GET['id'];

$nds = new NewsDataSource();
$nds->open();
$nds->Delete($_GET['id']);
$nds->close();
header('Location:News.php');
