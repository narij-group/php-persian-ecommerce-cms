<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$mds = new MainMenuDataSource();
$mds->open();

$mainmenu = new MainMenu();
$mainmenu->MainMenuId = $_POST['id'];
$mnu = $mds->FindOneMainMenuBasedOnId($_POST['id']);
$mainmenu->Group = $_POST['group'];
$mainmenu->Number = $mnu->Number;

$mds->Update($mainmenu);
$mds->close();
header('Location:MainMenus.php');
