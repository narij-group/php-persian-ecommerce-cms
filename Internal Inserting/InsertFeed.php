<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FeedDataSource.inc';
$feed = new Feed();
$feed->Email = $_POST['email'];

$fds = new FeedDataSource();
$fds->open();
$fds->Insert($feed);
$fds->close();
