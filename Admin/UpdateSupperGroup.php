<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
$suppergroup = new SupperGroup();
$suppergroup->SupperGroupId = $_POST['id'];
$suppergroup->Group = $_POST['group'];
$suppergroup->SubGroup = $_POST['subgroup'];
$suppergroup->Name = $_POST['name'];
$suppergroup->LatinName = $_POST['latinname'];

$sgds = new SupperGroupDataSource();
$sgds->open();

$sgds->Update($suppergroup);
$sgds->close();
header('Location:SupperGroups.php');
