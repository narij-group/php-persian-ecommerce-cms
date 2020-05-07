<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';

$linkbox = new LinkBox();
$linkbox->LinkBoxId = $_POST['id'];
$linkbox->Content = $_POST['content'];
$linkbox->HaveForm = $_POST['contactus'];


$lds = new LinkBoxDataSource();
$lds->open();
$lds->UpdateContent($linkbox);
$lds->close();
header('Location:LinkBoxes.php');
