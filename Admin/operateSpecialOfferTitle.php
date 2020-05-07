<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SpecialOfferTitleDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {
        $stds = new SpecialOfferTitleDataSource();
        $stds->open();
        $specialoffertitle = new SpecialOfferTitle();
        $specialoffertitle->SpecialOfferTitleId = $_POST['id'];
        $specialoffertitle->Title = $_POST['title'];
        $specialoffertitle->Activated = $_POST['activated'];
        $stds->Update($specialoffertitle);
        $stds->close();
    } else {
        $stds = new SpecialOfferTitleDataSource();
        $stds->open();
        $specialoffertitle = new SpecialOfferTitle();
        $specialoffertitle->Title = $_POST['title'];
        $specialoffertitle->Activated = $_POST['activated'];
        $stds->Insert($specialoffertitle);
        $stds->close();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['offerid'])) {
        $stds = new SpecialOfferTitleDataSource();
        $stds->open();
        $specialoffertitle = $stds->FindOneSpecialOfferTitleBasedOnId($_GET["offerid"]);
        if ($specialoffertitle->Activated == 0) {
            $specialoffertitle->Activated = 1;
        } else {
            $specialoffertitle->Activated = 0;
        }
        $stds->SwitchStatus($specialoffertitle);
        $stds->close();
    } else {

//    if ($role->DeleteLinkBox != 1) {
//        header('Location:Index.php');
//        die();
//    }

        $stds = new SpecialOfferTitleDataSource();
        $stds->open();
        $stds->Delete($_GET['id']);
        $stds->DeleteSpecialOfferBaseToSpecialOfferTitle($_GET['id']);
        $stds->close();
    }

}
header('Location:SpecialOfferTitles.php');