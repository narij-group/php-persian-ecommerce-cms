<?php
require_once  __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';
session_start();
$_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "NO";
setcookie(COOKIE_USER_LOGGED_IN, " ", time()-20);
setcookie(COOKIE_CUSTOMER_ID, " ", time()-20);
setcookie(COOKIE_CUSTOMER_LOGGED_IN, " ", time()-20);
header("location:../logoff.php");