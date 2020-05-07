<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/SubGroupDataSource.inc';
$subgroup = new SubGroup();
$subgroup->Group = $_POST['group'];
$subgroup->Name = $_POST['name'];
$subgroup->LatinName = $_POST['latinname'];


$sgds= new SubGroupDataSource();
$sgds->open();
$sgds->Insert($subgroup);
$sgds->close();
header('Location:SubGroups.php');
