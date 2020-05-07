<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Globals/Sessions.php';

if (!isset($_SESSION))
    session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PurchaseBasketDataSource.inc';
$c = new PurchaseBasket();
$pbds = new PurchaseBasketDataSource();
$pbds->open();

//--------------------------------Update Cart Counter------------------------------------//
if (isset($_POST['total_cart_items'])) {
    if (isset($_COOKIE[COOKIE_CUSTOMER_LOGGED_IN]) && isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
        $c->Customer = $_COOKIE ['CustomerId'];
        echo $pbds->PurchaseBasketCounter($_COOKIE ['CustomerId']);
        $pbds->close();
    } else {
        $c->Customer = $_COOKIE ['CustomerId'];
        echo $pbds->PurchaseBasketCounter($_COOKIE ['CustomerId'], session_id());
        $pbds->close();
//        echo "0";
    }
//    $c->Customer = $_COOKIE ['CustomerId'];
//    echo $pbds->PurchaseBasketCounter($_COOKIE ['CustomerId'], session_id());
//    $pbds->close();

    exit();
}

//--------------------------------Insert Cart Item------------------------------------//
if (isset($_POST['item_id']) == TRUE && isset($_POST['item_price']) == TRUE) {
    $purchasebasket = new PurchaseBasket();
    $purchasebasket->Product = $_POST['item_id'];
//    echo "cus : " . $_COOKIE[COOKIE_CUSTOMER_ID] . " e";
    $purchasebasket->Customer = $_COOKIE[COOKIE_CUSTOMER_ID];
    if ($pbds->isIteamExistWithoutColorCheck($_POST['item_id'], $_COOKIE[COOKIE_CUSTOMER_ID], session_id()) == FALSE) {
        $purchasebasket->Date = date("Y/m/d");
        $purchasebasket->Price = $_POST['item_price'];


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GuaranteeDataSource.inc';
        $gds = new GuaranteeDataSource();
        $gds->open();
        $grs = array();
        $grs = $gds->GetGuaranteesForOneProduct($_POST['item_id']);
        $gds->close();

        foreach ($grs as $gr) {
            $purchasebasket->Guarantee = $gr->GuaranteeId;
            break;
        }


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductColorDataSource.inc';
        $pcds = new ProductColorDataSource();
        $pcds->open();
        $pcs = array();
        $pcs = $pcds->GetProductColorsForOneProduct($_POST['item_id']);
        $pcds->close();

        foreach ($pcs as $pc) {
            $purchasebasket->Color = $pc->ProductColorId;
            break;
        }


//        $purchasebasket->Guarantee = $_POST['item_guarantee'];
//        $purchasebasket->Color = $_POST['item_color'];

        if (isset($_POST['item_count']) == true) {
            $purchasebasket->Count = $_POST['item_count'];
//            echo "cnt : " . $_POST['item_count'];
        } else {
            $purchasebasket->Count = 1;
        }


//        if (!isset($_COOKIE[COOKIE_CUSTOMER_ID]) || $_COOKIE[COOKIE_CUSTOMER_ID] == 0 || $_COOKIE[COOKIE_CUSTOMER_ID] == "NO") {
//            $_SESSION[SESSION_STRING_CART_ERROR] = "برای خرید ابتدا وارد حساب خود شوید .";
//            exit();
//        }

        $purchasebasket->Customer = $_COOKIE[COOKIE_CUSTOMER_ID];
        $purchasebasket->Session = session_id();
        $pbds->Insert($purchasebasket);

        echo "s-" . $pbds->PurchaseBasketCounter($_COOKIE [COOKIE_CUSTOMER_ID], session_id());
        $pbds->close();
        exit();


    } else {


        $_SESSION[SESSION_STRING_CART_ERROR] = $_POST['item_color'];
        echo "w-" . $pbds->PurchaseBasketCounter($_COOKIE[COOKIE_CUSTOMER_ID], session_id());
        exit();
    }


    if (isset($_COOKIE[COOKIE_CUSTOMER_LOGGED_IN]) && isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
//        $c->Customer = $_COOKIE [COOKIE_CUSTOMER_ID];
//        echo $pbds->PurchaseBasketCounter($_COOKIE [COOKIE_CUSTOMER_ID], session_id());
    } else {
//        echo "0";
    }

}
