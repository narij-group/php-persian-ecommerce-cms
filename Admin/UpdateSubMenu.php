<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';

$smds = new SubMenuDataSource();
$smds->open();

$submenu = new SubMenu();
$_POST['image'] = str_replace('/DigitalShopV1/SubMenuImages//', 'SubMenuImages/', $_POST['image']);
$submenu->Image = $_POST['image'];
$submenu->SubGroup = $_POST['subgroup'];
$submenu->SubMenuId = $_POST['id'];
$s = $smds->FindOneSubMenuBasedOnId($_POST['id']);
$submenu->MainMenu = $_POST['mainmenu'];
$submenu->Number = $s->Number;


$smds->Update($submenu);
$smds->close();
header('Location:SubMenus.php');
