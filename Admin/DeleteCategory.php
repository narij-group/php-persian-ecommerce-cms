<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CategoryDataSource.inc';

require_once 'Template/top2.php';
$category = new CategoryDataSource();
$category->open();
$category->Delete($_GET['id']);
$category->close();
header('Location:Categories.php');