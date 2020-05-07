<?php
require_once  __DIR__ . DIRECTORY_SEPARATOR . 'Globals/Sessions.php';
session_start();
if (isset($_GET['id']) == TRUE) {
    if ((!isset($_SESSION[SESSION_INT_PRODUCT_1]) || $_SESSION[SESSION_INT_PRODUCT_1] == 0)) {
        $_SESSION[SESSION_INT_PRODUCT_1] = $_GET['id'];
        ?>
        <script>
            $(document).ready(function () {
                $("#success-compare").fadeIn(250);
                setTimeout(function () {
                    $("#success-compare").fadeOut(250);
                }, 5000);
            });
        </script>
        <?php
    } elseif ((!isset($_SESSION[SESSION_INT_PRODUCT_2]) || $_SESSION[SESSION_INT_PRODUCT_2] == 0) && isset($_SESSION[SESSION_INT_PRODUCT_1]) == TRUE && $_SESSION[SESSION_INT_PRODUCT_1] != $_GET['id']) {
        $_SESSION[SESSION_INT_PRODUCT_2] = $_GET['id'];
        ?>
        <script>
            $(document).ready(function () {
                $("#compare-box").addClass("compare-animation");
                $("#success-compare").fadeIn(250);
                setTimeout(function () {
                    $("#success-compare").fadeOut(250);
                }, 5000);
            });
        </script>
        <?php
    } elseif ((!isset($_SESSION[SESSION_INT_PRODUCT_3]) || $_SESSION[SESSION_INT_PRODUCT_3] == 0) && isset($_SESSION[SESSION_INT_PRODUCT_2]) && isset($_SESSION[SESSION_INT_PRODUCT_1]) && $_SESSION[SESSION_INT_PRODUCT_2] != $_GET['id'] && $_SESSION[SESSION_INT_PRODUCT_1] != $_GET['id']) {
        $_SESSION[SESSION_INT_PRODUCT_3] = $_GET['id'];
        ?>
        <script>
            $(document).ready(function () {
                $("#compare-box").addClass("compare-animation");
                $("#success-compare").fadeIn(250);
                setTimeout(function () {
                    $("#success-compare").fadeOut(250);
                }, 5000);
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            $(document).ready(function () {
                $("#error-compare").fadeIn(250);
                setTimeout(function () {
                    $("#error-compare").fadeOut(250);
                }, 5000);
            });
        </script>
        <?php
    }
}

