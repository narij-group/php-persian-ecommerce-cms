<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';
$lds = new LinkBoxDataSource();
$lds->open();
$linkbox = new LinkBox();
$linkbox->LinkBoxId = $_POST['id'];
$linkbox->Name = $_POST['name'];
$linkbox->Link = $_POST['link'];
$linkbox->LinkboxTitle = $_POST['linkboxtitle'];

$lds->Update($linkbox);
$lds->close();
header('Location:LinkBoxes.php');
