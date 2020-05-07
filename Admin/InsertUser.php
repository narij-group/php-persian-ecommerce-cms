<?php
require_once 'Template/top2.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserDataSource.inc';
$user = new User();
$user->Name = $_POST['name'];
$user->Family = $_POST['family'];
$user->Password = md5($_POST['password']);
$user->Email = $_POST['email'];
$user->Username = $_POST['username'];
$user->Activate = $_POST['activate'];
$user->ActiveCode = 0;
$user->Role = $_POST['role'];

$uds = new UserDataSource();
$uds->open();
$uds->Insert($user);
$uds->close();

header('Location:Users.php');
