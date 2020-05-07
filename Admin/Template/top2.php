<?php
require_once  __DIR__ . DIRECTORY_SEPARATOR . '../../Globals/Sessions.php';
session_start();
if (isset($_SESSION[SESSION_YES_NO_USER_LOGGED_IN]) == FALSE) {
    $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "NO";
}
if ($_SESSION[SESSION_YES_NO_USER_LOGGED_IN] == "NO") {
    header('location:../index.php');
    die();
}

//$u1 = new User();
//$u1->UserId = $_COOKIE[COOKIE_MY_USER_ID];
//$user1 = $u1->FindOneUser();

include_once __DIR__ . DIRECTORY_SEPARATOR .  '../../ClassesEx/datasource/UserDataSource.inc';
$uds = new UserDataSource();
$uds->open();
$user1 = $uds->FindOneUserBasedOnId($_COOKIE[COOKIE_MY_USER_ID]);
$uds->close();





require_once __DIR__ . DIRECTORY_SEPARATOR . '../../ClassesEx/datasource/RoleDataSource.inc';
$r = new RoleDataSource();
$r->open();
//$r->RoleId = $user1->Role;
$role = $r->FindOneRoleBasedOnId($user1->Role);
$r->close();

