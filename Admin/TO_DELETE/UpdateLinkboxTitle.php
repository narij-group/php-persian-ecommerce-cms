<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkboxTitleDataSource.inc';
$lds = new LinkboxTitleDataSource();
$lds->open();
$linkboxtitle = new LinkboxTitle();
$linkboxtitle->LinkboxTitleId = $_POST['id'];
$linkboxtitle->Name = $_POST['name'];
$lds->Update($linkboxtitle);
$lds->close();
header('Location:LinkboxTitles.php');
