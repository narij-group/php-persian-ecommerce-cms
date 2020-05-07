<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LogoDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $lds = new LogoDataSource();
        $lds->open();
        $logo = new Logo();
        $logo->LogoId = $_POST['id'];
        $_POST['image'] = str_replace('/DigitalShopV1/CompanyLogos//', 'CompanyLogos/', $_POST['image']);
        $logo->Image = $_POST['image'];
        $logo->Name = $_POST['name'];
        $logo->Activated = $_POST['activated'];
        $logo->LatinName = $_POST['latinname'];
        $lds->Update($logo);
        $lds->close();


    } else {

        $lds = new LogoDataSource();
        $lds->open();
        $logo = new Logo();
        $_POST['image'] = str_replace('/DigitalShopV1/CompanyLogos//', 'CompanyLogos/', $_POST['image']);
        $logo->Image = $_POST['image'];
        $logo->Name = $_POST['name'];
        $logo->Activated = $_POST['activated'];
        $logo->LatinName = $_POST['latinname'];
        $lds->Insert($logo);
        $lds->close();

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteBrand != 1) {
        header('Location:Index.php');
        die();
    }

    $lds = new LogoDataSource();
    $lds->open();

    $logos = $lds->FindOneLogoBasedOnId($_GET['id']);
    if (file_exists("../" . $logos->Image)) {
        unlink('../' . $logos->Image);
    }

    $lds->Delete($_GET['id']);

}

header('Location:Logos.php');



