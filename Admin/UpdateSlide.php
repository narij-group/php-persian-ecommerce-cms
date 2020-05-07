<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SlideDataSource.inc';
$slide = new Slide();
$slide->SlideId = $_POST['id'];
$_POST['image'] = str_replace( '/DigitalShopV1/SlideImage//' , 'SlideImage/' , $_POST['image'] );
$_POST['image'] = str_replace( 'DigitalShopV1/SlideImage//' , 'SlideImage/' , $_POST['image'] );
$_POST['image'] = str_replace( 'DigitalShopV1/SlideImage/' , 'SlideImage/' , $_POST['image'] );
$slide->Image = $_POST['image'];
$slide->Name = $_POST['name'];
$slide->Link = $_POST['link'];
$sds = new SlideDataSource();
$sds->open();
$sds->Update($slide);
$sds->close();
header('Location:Slides.php');
