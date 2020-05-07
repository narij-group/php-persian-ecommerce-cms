<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ServiceDataSource.inc';
        $sds = new ServiceDataSource();
        $sds->open();
        $service = new Service();
        $service->ServiceId = $_POST["id"];
        $service->Name = $_POST["name"];
        $service->Activated = $_POST["activated"];
        $_POST['price'] = str_replace(',', '', $_POST['price']);
        $service->Price = $_POST["price"];
//$service->Update();

        $sds->Update($service);
        $sds->close();

        header('Location:Services.php');


    } else {
        require_once 'Template/top2.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ServiceDataSource.inc';

        $sds = new ServiceDataSource();
        $sds->open();
        $service = new Service();
        $service->Name = $_POST["name"];
        $service->Activated = $_POST["activated"];
        $_POST['price'] = str_replace(',', '', $_POST['price']);
        $service->Price = $_POST["price"];
//$service->Insert();
        $sds->Insert($service);
        $sds->close();

        header('Location:Services.php');


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";


    require_once 'Template/top2.php';
    if ($role->DeleteService != 1) {
        header('Location:Index.php');
        die();
    }
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ServiceDataSource.inc';

    $sds = new ServiceDataSource();
    $sds->open();
    $sds->Delete($_GET["id"]);
    $sds->close();
    header('Location:Services.php');

}




