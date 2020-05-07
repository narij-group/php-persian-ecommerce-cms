<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
$menutitle = new MenuTitleDataSource();
$menutitle->open();
$menutitle->Delete($_GET['id']);
$menutitle->close();
header('Location:MenuTitles.php');
