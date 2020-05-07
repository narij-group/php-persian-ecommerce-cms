<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';

$suppermenu = new SupperMenu();
$suppermenu->SubMenu = $_POST['submenu'];
$suppermenu->SupperGroup = $_POST['suppergroup'];
$suppermenu->Title = $_POST['title'];
$suppermenu->MainMenu = $_POST['mainmenu'];

$smds = new SupperMenuDataSource();
$smds->open();
$smds->Insert($suppermenu);
$smds->close();
header('Location:SupperMenus.php');
