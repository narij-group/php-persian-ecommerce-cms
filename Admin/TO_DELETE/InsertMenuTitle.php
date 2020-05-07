<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';

$menutitle = new MenuTitle();
$menutitle->Name = $_POST['name'];
$menutitle->SubMenu = $_POST['submenu'];
$menutitle->Column = $_POST['column'];

$mds = new MenuTitleDataSource();
$mds->open();
$mds->Insert($menutitle);
$mds->close();
header('Location:MenuTitles.php');
