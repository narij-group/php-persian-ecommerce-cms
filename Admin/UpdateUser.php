<?php

require_once 'Template/top2.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserDataSource.inc';

$uds = new UserDataSource();
$uds->open();

$user = new User();
$user->UserId = $_POST['id'];
$user2 = $uds->FindOneUserBasedOnId($_POST['id']);
$user->Name = $_POST['name'];
$user->Family = $_POST['family'];
//$user->Password = md5($_POST['password']);
if ($user2->Password == $_POST['password']) {
    $user->Password = $_POST['password'];
} else {
    $user->Password = md5($_POST['password']);
}
$user->Email = $_POST['email'];
$user->Username = $_POST['username'];
$user->Activate = $_POST['activate'];
$user->ActiveCode = 0;
$user->Role = $_POST['role'];
$uds->Update($user);
$uds->close();
header('Location:Users.php');
