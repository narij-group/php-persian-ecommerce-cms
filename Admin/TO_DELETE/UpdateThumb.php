<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ThumbDataSource.inc';
$thumb = new Thumb();
$thumb->ThumbId = $_POST['id'];
$thumb->Name = $_POST['name'];
$_POST['image'] = str_replace('/DigitalShopV1/ThumbImage//', 'ThumbImage/', $_POST['image']);
$_POST['image'] = str_replace('DigitalShopV1/ThumbImage//', 'ThumbImage/', $_POST['image']);
$_POST['image'] = str_replace('DigitalShopV1/ThumbImage/', 'ThumbImage/', $_POST['image']);
$thumb->Image = $_POST['image'];
$thumb->Link = $_POST['link'];

$tds = new ThumbDataSource();
$tds->open();

$tds->Update($thumb);
$tds->close();
header('Location:Thumbs.php');
