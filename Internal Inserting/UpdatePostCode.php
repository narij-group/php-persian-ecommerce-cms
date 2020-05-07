<?php
if (!isset($_SESSION))
    session_start();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';

if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
//    $_SESSION[SESSION_EARLY_CUSTOMER__ADDRESS_DATA] = $_POST['address'];
} else {
    $_SESSION[SESSION_EARLY_CUSTOMER__PostCode_DATA] = $_POST['post_code'];
}
