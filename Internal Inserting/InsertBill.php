<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/BillDataSource.php';
$bill = new Bill();
$b = new BillDataSource();
$b->open();
if ($b->FindByCode($_POST['tracecode']) != null) {
    $bill = $b->FindByCode($_POST['tracecode']);
}
$bill->TraceCode = $_POST['tracecode'];
$bill->Bank = $_POST['bank'];
$bill->Code = $_POST['code'];
$bill->Comment = $_POST['comment'];
$bill->Date = $_POST['date'];
$bill->Status = 1;
if ($b->FindByCode($_POST['tracecode']) != null) {
    $b->Update($bill);
} else {
    $b->Insert($bill);
}
$b->close();
header('location:../UserProfile.php');