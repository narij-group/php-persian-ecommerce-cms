<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FeedDataSource.inc';

$fds = new FeedDataSource();
$fds->open();
$feed = new Feed();
$feed->FeedId = $_POST['id'];
$feed->Email = $_POST['email'];
$fds->Update($feed);
$fds->close();

header('Location:Feeds.php');
