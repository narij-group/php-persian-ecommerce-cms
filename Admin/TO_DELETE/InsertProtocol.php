<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolDataSource.inc';
$protocol = new Protocol();
$protocol->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$protocol->ProtocolList = $_POST['protocollist'];

$pds = new ProtocolDataSource();
$pds->open();
$pds->Insert($protocol);
$pds->close();
header('Location:Protocols.php?id=' . $_SESSION[SESSION_INT_PRODUCT_ID]);
