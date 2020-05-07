<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';

$suppermenu = new SupperMenuDataSource();
$suppermenu->open();
$suppermenu->Delete($_GET['id']);
$suppermenu->close();
header('Location:SupperMenus.php');