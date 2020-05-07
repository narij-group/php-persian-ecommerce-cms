<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';

$smds = new SubMenuDataSource();
$smds->open();

$submenu = new SubMenu();
$_POST['image'] = str_replace('/DigitalShopV1/SubMenuImages//', 'SubMenuImages/', $_POST['image']);
$submenu->Image = $_POST['image'];
$submenu->Name = $_POST['name'];
$submenu->MainMenu = $_POST['mainmenu'];
$submenu->SubGroup = $_POST['subgroup'];
$submenu->Number = $smds->MaxNumber() + 1;
if ($smds->MaxNumber() == null) {
    $submenu->Number = 1;
}
$smds->Insert($submenu);
$smds->close();
header('Location:SubMenus.php');
