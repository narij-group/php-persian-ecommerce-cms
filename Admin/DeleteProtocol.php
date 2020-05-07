<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/ProtocolDataSource.inc';
$protocol = new ProtocolDataSource();
$protocol ->open();
$protocol->Delete($_GET['id']);
$protocol ->close();
if (!isset($_POST['pid']))
{
    header('Location:Protocols.php');
}
 else {
    header('Location:Protocols.php?id='.$_POST['pid']);
}

