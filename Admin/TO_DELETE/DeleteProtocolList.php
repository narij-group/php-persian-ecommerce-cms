<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolListDataSource.inc';
$protocollist = new ProtocolListDataSource();
$protocollist->open();
$protocollist->Delete($_GET['id']);
$protocollist->close();
header('Location:ProtocolLists.php');


