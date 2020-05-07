<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ThumbDataSource.inc';
$thumb = new Thumb();
$_POST['image'] = str_replace('/DigitalShopV1/ThumbImage//', 'ThumbImage/', $_POST['image']);
$_POST['image'] = str_replace('DigitalShopV1/ThumbImage//', 'ThumbImage/', $_POST['image']);
$_POST['image'] = str_replace('DigitalShopV1/ThumbImage/', 'ThumbImage/', $_POST['image']);
$thumb->Image = $_POST['image'];
$thumb->Link = $_POST['link'];
$thumb->Name = $_POST['name'];
$tds = new ThumbDataSource();
$tds->open();
$tds->Insert($thumb);
$tds->close();
header('Location:Thumbs.php');
