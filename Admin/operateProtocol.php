<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {
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




    } else {

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


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

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


}




