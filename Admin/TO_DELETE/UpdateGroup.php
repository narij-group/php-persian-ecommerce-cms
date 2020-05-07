<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
$gds = new GroupDataSource();
$gds->open();

$group = new Group();
$group->GroupId = $_POST['id'];
$group->Name = $_POST['name'];
$group->LatinName = $_POST['latinname'];
$gds->Update($group);
$gds->close();
header('Location:Groups.php');
