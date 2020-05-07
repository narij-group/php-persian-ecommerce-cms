<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolListDataSource.inc';

        $protocollist = new ProtocolList();
        $protocollist->ProtocolListId = $_POST['id'];
        $_POST['image'] = str_replace('/DigitalShopV1/ProtocolImages//', 'ProtocolImages/', $_POST['image']);
        $protocollist->Image = $_POST['image'];
        $protocollist->Name = $_POST['name'];

        $pds = new ProtocolListDataSource();
        $pds->open();
        $pds->Update($protocollist);
        $pds->close();
        header('Location:ProtocolLists.php');


    } else {
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


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
    require_once 'Template/top2.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolListDataSource.inc';
    $protocollist = new ProtocolListDataSource();
    $protocollist->open();
    $protocollist->Delete($_GET['id']);
    $protocollist->close();
    header('Location:ProtocolLists.php');



}




