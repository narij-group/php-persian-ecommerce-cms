<?php

require_once 'Template/top2.php';
require_once __DIR__ .DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/ColorListDataSource.inc';
$colorlist = new ColorList();
$colorlist->ColorListId = $_POST['id'];
$colorlist->Name = $_POST['name'];
$colorlist->Sample = $_POST['sample'];


$clsd = new ColorListDataSource();
$clsd->open();
$clsd->Update($colorlist);
$clsd->close();
header('Location:ColorLists.php');
