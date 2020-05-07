<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolDataSource.inc';
$protocol = new Protocol();
$protocol->ProtocolId = $_POST['id'];
$protocol->ProtocolList = $_POST['protocollist'];

$pds = new ProtocolDataSource();
$pds->open();
$pds->Update($protocol);
$pds->close();

if (!isset($_POST['pid'])) {
    header('Location:Protocols.php');
} else {
    header('Location:Protocols.php?id=' . $_POST['pid']);
}

