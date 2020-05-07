<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';

require_once '../Template/CustomeDate/jdatetime.class.php';

$ods = new OpinionDataSource();
$ods->open();


$opinion = new Opinion();
$opinion->Customer = $_POST['customer'];
$opinion->Value = nl2br($_POST['value']);
$opinion->Rate = $_POST['rate'];
$date = new jDateTime(true, true, 'Asia/Tehran');
$opinion->Date = $date->date("l j F Y");
$opinion->ProductId = $_POST['productId'];
if ($ods->isCustomerVotedAlready($opinion->Customer, $opinion->ProductId) != 1) {
    setcookie(COOKIE_MESSAGE_2, 'OSuccess()', time() + 15, '/');
    $ods->Insert($opinion);
    $ods->close();
} else {
    setcookie(COOKIE_MESSAGE_2, 'OError()', time() + 15, '/');
}
header("Location:../Post.php?id=$opinion->ProductId");
