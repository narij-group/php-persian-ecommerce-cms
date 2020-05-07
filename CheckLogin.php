<?php
//TODO ERROR
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Globals/Sessions.php';


session_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/UserDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CustomerDataSource.inc';


$uds = new UserDataSource();
$uds->open();
$users = $uds->Fill();
//$user->close();
$CheckPass = md5($_POST['password']);

$CheckUser = $_POST['username'];


//echo $CheckUser . "    " . $CheckPass;

$c2 = new Customer();

$i = 0;
foreach ($users as $user) {
    if ($user->Username == $CheckUser && $user->Password == $CheckPass) {
        $user1 = new User();
        $user1->UserId = $user->UserId;
        $_COOKIE [COOKIE_MY_USER_ID];
        setcookie(COOKIE_MY_USER_ID, $user1->UserId, time() + 86400);
    }
    if ($user->Username != $CheckUser || $user->Password != $CheckPass) {
        if ($user->Username != $CheckUser && $user->Password == $CheckPass) {
            $_SESSION[SESSION_STRING_MESSAGE] = "ErrorMessegeLU()";
            header('location:' . $_POST['link']);
//            die();
        } elseif ($user->Username == $CheckUser && $user->Password != $CheckPass) {
            $_SESSION[SESSION_STRING_MESSAGE] = "ErrorMessegeLP()";
            header('location:' . $_POST['link']);
//            die();
        } elseif ($user->Username != $CheckUser && $user->Password != $CheckPass) {
            $_SESSION[SESSION_STRING_MESSAGE] = "ErrorMessegeLP()";
            header('location:' . $_POST['link']);
//            die();
        }
    }
    $i++;
    $user->UserId = $i;
//    $user->FindOneUser();
}
$u = new User();
$c = new Customer();
$username = $_POST['username'];
$password = md5($_POST['password']);
$c->Email = $username;
$c->Username = $username;
$c->Password = $password;
$u->Username = $username;
$u->Password = $password;

$cds = new CustomerDataSource();
$cds->open();


if ($uds->IsUserAllowed($u) == TRUE) {
    $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "YES";
    setcookie(COOKIE_USER_LOGGED_IN, "YES", time() + 86400);
    setcookie(COOKIE_CUSTOMER_LOGGED_IN, "NO", time() - 20);
    setcookie(COOKIE_CUSTOMER_ID, 0, time() - 20);
    //echo "<br>1";
    header('location:Admin/Index.php');
} elseif ($cds->IsCustomerAllowed($c) == TRUE) {
    $c2 = $cds->FindOneCustomerWithEmail($c);
    setcookie(COOKIE_CUSTOMER_ID, $c2->CustomerId, time() + 86400);
    $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "YES";
    setcookie(COOKIE_CUSTOMER_LOGGED_IN, "YES", time() + 86400);
    $_SESSION[SESSION_STRING_CART_ERROR] = "";


    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PurchaseBasketDataSource.inc';
    $pbds = new PurchaseBasketDataSource();
    $pbds->open();
    $pbds->updatePurchaseBasketsCustomer($c2->CustomerId, session_id());
    $pbds->updatePurchaseBasketsCustomerFroExistingBaskets($c2->CustomerId, session_id());
    $pbds->close();

    //echo "<br>2";
    header('location:' . $_POST['link']);
} else {
    $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "NO";
    setcookie(COOKIE_CUSTOMER_ID, 0, time() - 20);
    setcookie(COOKIE_CUSTOMER_LOGGED_IN, "NO", time() - 20);
    //echo "<br>3";
    header('location:' . $_POST['link']);
}