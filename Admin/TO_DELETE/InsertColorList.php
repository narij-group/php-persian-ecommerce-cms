<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';
$colorlist = new ColorList();
$colorlist->Name = $_POST['name'];
$colorlist->Sample = $_POST['sample'];
$clds = new ColorListDataSource();
$clds->open();
$clds->Insert($colorlist);
$clds->close();
header('Location:ColorLists.php');
