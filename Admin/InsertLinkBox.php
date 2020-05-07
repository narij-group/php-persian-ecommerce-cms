<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';
$lds = new LinkBoxDataSource();
$lds->open();

$linkbox = new LinkBox();
$linkbox->Name = $_POST['name'];
$linkbox->Link = $_POST['link'];
$linkbox->LinkboxTitle = $_POST['linkboxtitle'];
$linkbox->User = $_POST['user'];
$lds->Insert($linkbox);
$lds->close();
header('Location:LinkBoxes.php');
