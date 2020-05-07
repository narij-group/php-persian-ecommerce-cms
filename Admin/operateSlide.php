<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SlideDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $slide = new Slide();
        $slide->SlideId = $_POST['id'];
        $_POST['image'] = str_replace( '/DigitalShopV1/SlideImage//' , 'SlideImage/' , $_POST['image'] );
        $_POST['image'] = str_replace( 'DigitalShopV1/SlideImage//' , 'SlideImage/' , $_POST['image'] );
        $_POST['image'] = str_replace( 'DigitalShopV1/SlideImage/' , 'SlideImage/' , $_POST['image'] );
        $slide->Image = $_POST['image'];
        $slide->Name = $_POST['name'];
        $slide->Link = $_POST['link'];
        $sds = new SlideDataSource();
        $sds->open();
        $sds->Update($slide);
        $sds->close();



    } else {
        $slide = new Slide();
        $_POST['image'] = str_replace('/DigitalShopV1/SlideImage//', 'SlideImage/', $_POST['image']);
        $slide->Image = $_POST['image'];
        $slide->Name = $_POST['name'];
        $slide->Link = $_POST['link'];

        $sds = new SlideDataSource();
        $sds->open();
        $sds->Insert($slide);
        $sds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteSlide != 1) {
        header('Location:Index.php');
        die();
    }
    $sds = new SlideDataSource();
    $sds->open();

    $slide->SlideId = $_GET['id'];
    $slides = $sds->FindOneSlideBasedOnId($_GET['id']);
    if (file_exists("../" . $slides->Image)) {
        unlink('../' . $slides->Image);
    }
    $sds->Delete($_GET['id']);
    $sds->close();

}


header('Location:Slides.php');



