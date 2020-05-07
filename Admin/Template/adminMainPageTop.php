<?php
session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . "../../Globals/Sessions.php";


if (isset($_SESSION[SESSION_YES_NO_USER_LOGGED_IN]) == FALSE) {
    $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "NO";
}
if ($_SESSION[SESSION_YES_NO_USER_LOGGED_IN] == "NO" || !isset($_COOKIE[COOKIE_MY_USER_ID])) {
    header('location:../Index.php');
}
include_once __DIR__ . DIRECTORY_SEPARATOR . '../../ClassesEx/datasource/UserDataSource.inc';
$u1 = new UserDataSource();
$u1->open();
$user1 = $u1->FindOneUserBasedOnId($_COOKIE[COOKIE_MY_USER_ID]);
$u1->close();

include_once __DIR__ . DIRECTORY_SEPARATOR . '../../ClassesEx/datasource/RoleDataSource.inc';
$r = new RoleDataSource();
$r->open();
//$r->RoleId = $user1->Role;
$role = $r->FindOneRoleBasedOnId($user1->Role);
$r->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../ClassesEx/datasource/SettingsDataSource.inc';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();

if (isset($_COOKIE[COOKIE_GROUP_ID])) {
    setcookie(COOKIE_GROUP_ID, "", time() - 10);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>پنل کاربری</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo '../' . $settings->ILogo; ?>"/>

    <meta charset="UTF-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="Template/Styles/bootstrap.min.css" rel="stylesheet">
    <link href="Template/Styles/bootstrap-rtl.min.css" rel="stylesheet">
    <script src="Template/Scripts/bootstrap.js" type="text/javascript"></script>
    <link href="Template/Styles/font-awesome.css" rel="stylesheet">
    <script src="Template/Scripts/jquery-2.1.1.js"></script>

    <link href="Template/Styles/animate.css" rel="stylesheet">
    <link href="Template/Styles/style.css" rel="stylesheet">

