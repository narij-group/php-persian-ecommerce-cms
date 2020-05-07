<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ThumbDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $thumb = new Thumb();
        $thumb->ThumbId = $_POST['id'];
        $thumb->Name = $_POST['name'];
        $_POST['image'] = str_replace('/DigitalShopV1/ThumbImage//', 'ThumbImage/', $_POST['image']);
        $_POST['image'] = str_replace('DigitalShopV1/ThumbImage//', 'ThumbImage/', $_POST['image']);
        $_POST['image'] = str_replace('DigitalShopV1/ThumbImage/', 'ThumbImage/', $_POST['image']);
        $thumb->Image = $_POST['image'];
        $thumb->Link = $_POST['link'];

        $tds = new ThumbDataSource();
        $tds->open();

        $tds->Update($thumb);
        $tds->close();


    } else {

        $thumb = new Thumb();
        $_POST['image'] = str_replace('/DigitalShopV1/ThumbImage//', 'ThumbImage/', $_POST['image']);
        $_POST['image'] = str_replace('DigitalShopV1/ThumbImage//', 'ThumbImage/', $_POST['image']);
        $_POST['image'] = str_replace('DigitalShopV1/ThumbImage/', 'ThumbImage/', $_POST['image']);
        $thumb->Image = $_POST['image'];
        $thumb->Link = $_POST['link'];
        $thumb->Name = $_POST['name'];
        $tds = new ThumbDataSource();
        $tds->open();
        $tds->Insert($thumb);
        $tds->close();

    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once 'Template/top2.php';
    if ($role->DeleteThumb != 1) {
        header('Location:Index.php');
        die();
    }

    $tds = new ThumbDataSource();
    $tds->open();
    $thumb->ThumbId = $_GET['id'];
    $thumbs = $tds->FindOneThumbBasedOnId($_GET['id']);
    if (file_exists("../" . $thumbs->Image)) {
        unlink('../' . $thumbs->Image);
    }
    $tds->Delete($_GET['id']);

}

header('Location:Thumbs.php');



