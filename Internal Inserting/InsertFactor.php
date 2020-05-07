<meta charset="UTF-8"/>
<?php
session_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';


$discount = new Discount();


$purchasebasket = new PurchaseBasketDataSource();
$purchasebasket->open();
$purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE[COOKIE_CUSTOMER_ID]);
//$purchasebasket->close();


if ($_GET['usedcoupon'] == 1) {

    $ucds = new UserCouponDataSource();
    $ucds->open();
    $usercoupons = $ucds->FindOneUserCoupons($_COOKIE[COOKIE_CUSTOMER_ID]);
    $ucds->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';
    $userCoupon = new UserCouponDataSource();
    $userCoupon->open();
    $setting = new SettingsDataSource();
    $setting->open();
    $settings = $setting->Fill();
    $setting->close();
    $coupons = $userCoupon->SomeoneCouponsSome($_COOKIE[COOKIE_CUSTOMER_ID]);

    if ($coupons > $settings->MaxCoupon) {
        $mycoupons = $settings->MaxCoupon;
        $coupondiscout = ($settings->MaxCoupon * $settings->Coupon);
    } else {
        $mycoupons = $coupons;
        $coupondiscout = ($coupons * $settings->Coupon);
    }
    foreach ($usercoupons as $ucc) {
        if ($mycoupons >= 0) {
            if ($ucc->Value > $mycoupons) {
                $ucc2 = new UserCoupon();
                $ucc2->Value = $ucc->Value - $mycoupons;
                $ucc2->UserCouponId = $ucc->UserCouponId;
                $mycoupons = 0;
                $userCoupon->UpdateValue($ucc2);
            } else {
                $mycoupons = $mycoupons - $ucc->Value;
                $userCoupon->Delete($ucc->UserCouponId);
            }
        }
    }
    $userCoupon->close();
} else {
    $coupondiscout = 0;
}


foreach ($purchasebaskets as $c2) {
    $productcoupon = new ProductCouponDataSource();
    $productcoupon->open();
    $coupon = $productcoupon->FindOneProductCoupons($c2->Product->ProductId);
    $productcoupon->close();
    $usercoupon = new UserCoupon();
    $usercoupon->Customer = $_COOKIE[COOKIE_CUSTOMER_ID];
    $usercoupon->Date = date("Y/m/d");
    $usercoupon->Time = time();
    if (isset($coupon->Value)) {
        $usercoupon->Value = $coupon->Value;
        $ucds = new UserCouponDataSource();
        $ucds->open();
        $usercoupon->Insert();
        $ucds->close();
    } else {
        $usercoupon->Value = 0;
    }
}


$fds = new FactorDataSource();
$fds->open();
$factor = new Factor();
$factor->Customer = $_COOKIE[COOKIE_CUSTOMER_ID];
$factor->Date = date("Y/m/d");
$fds->Insert($factor);
$selectedfactor = $fds->FindSomeoneFactorId($factor);
$fds->close();


$price = new PriceDataSource();
$price->open();
$factorproduct = new FactorProduct();

$fcds = new FactorProductDataSource();
$fcds->open();
foreach ($purchasebaskets as $c) {
    $guarantee = new GuaranteeDataSource();
    $guarantee->open();
    $guarantee1 = $guarantee->FindOneGuaranteeBasedOnId($c->Guarantee);
    $guarantee->close();

    $productcolor = new ProductColorDataSource();
    $productcolor->open();
    $productcolor2 = $productcolor->FindOneProductColorBasedOnId($c->Color);
//    $productcolor->close();

    $productcolor3 = new ProductColor();
    $productcolor3->ProductColorId = $productcolor2->ProductColorId;
    $productcolor3->Quantity = $productcolor2->Quantity - $c->Count;
    $productcolor->UpdateQuantity($productcolor3);

    $factorproduct->Product = $c->Product->ProductId;
    $factorproduct->Date = date("Y/m/d");
    $factorproduct->Price = $price->GetLastPriceForOneProduct($c->Product->ProductId) - ($price->GetLastPriceForOneProduct($c->Product->ProductId) * $discount->GetLastDiscountForOneProduct($c->Product->ProductId) / 100) + $guarantee1->Price;
    $factorproduct->Factor = $selectedfactor;
    $factorproduct->Count = $c->Count;
    $factorproduct->Coupon = $coupondiscout;
    $factorproduct->Color = $productcolor2->Name;
    $factorproduct->Guarantee = $guarantee1->Name . '  ' . $guarantee1->ExpireTime;
    $fcds->Insert($factorproduct);
}
foreach ($purchasebaskets as $c1) {
    $purchasebasket->Delete($c1->PurchaseBasketId);
}
$price->close();
$fcds->close();

header("Location:../index.php");
