<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolListDataSource.inc';

$protocollist = new ProtocolList();
$_POST['image'] = str_replace('/DigitalShopV1/ProtocolImages//', 'ProtocolImages/', $_POST['image']);
$protocollist->Image = $_POST['image'];
$protocollist->Name = $_POST['name'];

$pds = new ProtocolListDataSource();
$pds->open();
$pds->Insert($protocollist);
$pds->close();
header('Location:ProtocolLists.php');
