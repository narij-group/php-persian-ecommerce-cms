<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FeedDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {


        $fds = new FeedDataSource();
        $fds->open();
        $feed = new Feed();
        $feed->FeedId = $_POST['id'];
        $feed->Email = $_POST['email'];
        $fds->Update($feed);
        $fds->close();

    } else {

        $fds = new FeedDataSource();
        $fds->open();

        $feed = new Feed();
        $feed->Email = $_POST['email'];
        $fds->Insert($feed);
        $fds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteFeed != 1) {
        header('Location:Index.php');
        die();
    }
    $fds = new FeedDataSource();
    $fds->open();
    $fds->Delete($_GET['id']);
    $fds->close();

}

header('Location:Feeds.php');



