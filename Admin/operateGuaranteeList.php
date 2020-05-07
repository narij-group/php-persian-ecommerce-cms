<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeListDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {


        $glds = new GuaranteeListDataSource();
        $glds->open();
        $guaranteelist = new GuaranteeList();
        $guaranteelist->GuaranteeListId = $_POST['id'];
        $guaranteelist->Name = $_POST['name'];
        $guaranteelist->Duration = $_POST['duration'];
        $_POST['price'] = str_replace(',', '', $_POST['price']);
        $guaranteelist->Price = $_POST['price'];
        $glds->Update($guaranteelist);
        $glds->close();

    } else {

        $glds = new GuaranteeListDataSource();
        $glds->open();
        $guaranteelist = new GuaranteeList();
        $guaranteelist->Name = $_POST['name'];
        $guaranteelist->Duration = $_POST['duration'];
        $_POST['price'] = str_replace(',', '', $_POST['price']);
        $guaranteelist->Price = $_POST['price'];
        $glds->Insert($guaranteelist);
        $glds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteGuarantee != 1) {
        header('Location:Index.php');
        die();
    }
    $guaranteelist = new GuaranteeListDataSource();
    $guaranteelist->open();
    $guaranteelist->K_Delete($_GET['id']);
    $guaranteelist->close();
}

header('Location:GuaranteeLists.php');



