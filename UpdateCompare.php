<?php

session_start();
require_once  __DIR__ . DIRECTORY_SEPARATOR . 'Globals/Sessions.php';
if (isset($_GET['id']) == TRUE) {
    if ($_GET['id'] == $_SESSION[SESSION_INT_PRODUCT_1]) {
        if (isset($_SESSION[SESSION_INT_PRODUCT_2]) && isset($_SESSION[SESSION_INT_PRODUCT_3])) {
            $_SESSION[SESSION_INT_PRODUCT_1] = $_SESSION[SESSION_INT_PRODUCT_2];
            $_SESSION[SESSION_INT_PRODUCT_2] = $_SESSION[SESSION_INT_PRODUCT_3];
            $_SESSION[SESSION_INT_PRODUCT_3] = 0;
        } elseif (isset($_SESSION[SESSION_INT_PRODUCT_2])) {
            $_SESSION[SESSION_INT_PRODUCT_1] = $_SESSION[SESSION_INT_PRODUCT_2];
            $_SESSION[SESSION_INT_PRODUCT_2] = 0;
        }
//        elseif (isset($_SESSION[SESSION_INT_PRODUCT_3])) {
//            $_SESSION[SESSION_INT_PRODUCT_1] = $_SESSION[SESSION_INT_PRODUCT_3];
//            $_SESSION[SESSION_INT_PRODUCT_3] = 0;
//        }

    } elseif ($_GET['id'] == $_SESSION[SESSION_INT_PRODUCT_2]) {
        if (isset($_SESSION[SESSION_INT_PRODUCT_3])) {
            $_SESSION[SESSION_INT_PRODUCT_2] = $_SESSION[SESSION_INT_PRODUCT_3];
            $_SESSION[SESSION_INT_PRODUCT_3] = 0;
        }

    } elseif ($_GET['id'] == $_SESSION[SESSION_INT_PRODUCT_3]) {
        $_SESSION[SESSION_INT_PRODUCT_3] = 0;
    }
} else {
    $_SESSION[SESSION_INT_PRODUCT_1] = 0;
    $_SESSION[SESSION_INT_PRODUCT_2] = 0;
    $_SESSION[SESSION_INT_PRODUCT_3] = 0;
}
header('location:Compare.php');