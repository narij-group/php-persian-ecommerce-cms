<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Globals/Sessions.php';
session_start();
$_SESSION[SESSION_1_0_IS_PAYING_CANCELED] = 1;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/FactorDataSource.inc';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ShippingMethodDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ServiceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PurchaseBasketDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/UserCouponDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GuaranteeDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductColorDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductCouponDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/DiscountDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SettingsDataSource.inc';

$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();

if ($settings->Tax != 0) {
    $tax = (100 + $settings->Tax) / 100;
} else {
    $tax = 1;
}

$price = new PriceDataSource();
$price->open();


$discount = new DiscountDataSource();
$discount->open();


$service = new ServiceDataSource();
$service->open();


$purchasebasket = new PurchaseBasketDataSource();
$purchasebasket->open();
$purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE[COOKIE_CUSTOMER_ID]);
$purchasebasket->close();


$MaxCouponDiscount = 0;
foreach ($purchasebaskets as $p) {
    $pricee = ((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100)) * $tax) * $p->Count;
    $MaxCouponDiscount += ($settings->MaxCouponPercentage / 100) * $pricee;
}

$servicesprice = 0;
if (isset($_GET['checkbox'])) {
    foreach ($_GET['checkbox'] as $ch) {
        $s = $service->FindOneServiceBasedOnId($ch);
        $servicesprice += $s->Price;
    }
}

$customer = new CustomerDataSource();
$customer->open();
$customer2 = $customer->FindOneCustomerBasedOnId($_COOKIE[COOKIE_CUSTOMER_ID]);
$customer2->Phone = $_GET['cphone'];
$customer2->Mobile = $_GET['cmobile'];
$customer2->Address = $_GET['caddress'];
$customer2->PostCode = $_GET['cpostcode'];
$customer2->Email = $_GET['cemail'];
$customer->Update($customer2);
$customer->close();


if (isset($_GET['usecoupon'])) {
    $usercoupon = new UserCouponDataSource();
    $usercoupon->open();
    $usercoupons = $usercoupon->FindOneUserCoupons($_COOKIE[COOKIE_CUSTOMER_ID]);
    $coupons = $usercoupon->SomeoneCouponsSome($_COOKIE[COOKIE_CUSTOMER_ID]);


    if ($coupons > $settings->MaxCoupon || $coupons > ceil($MaxCouponDiscount / $settings->Coupon)) {
        if ($settings->MaxCoupon > $MaxCouponDiscount / $settings->Coupon) {
            $mycoupons = ceil($MaxCouponDiscount / $settings->Coupon);
        } else {
            $mycoupons = $settings->MaxCoupon;
        }
        $coupondiscout = ($MaxCouponDiscount);
    } else {
        $mycoupons = $coupons;
        $coupondiscout = ($coupons * $settings->Coupon);
    }


    if ($coupondiscout > $MaxCouponDiscount) {
        $coupondiscout = $MaxCouponDiscount;
    }

    foreach ($usercoupons as $ucc) {
        if ($ucc->Value > $mycoupons) {
            $ucc->Value = $ucc->Value - $mycoupons;
            $usercoupon->UpdateValue($ucc);
            $mycoupons = 0;
        } else {
            $mycoupons = $mycoupons - $ucc->Value;
            $usercoupon->Delete($ucc->UserCouponId);
        }
    }

    $usercoupon->close();

} else {
    $coupondiscout = 0;
}


$cpns = array();
$_SESSION[SESSION_ARRAY_COUPONS_TO_SAVE] = $cpns;
if ($_GET['payment_method_id'] == 1) {
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
            $usercoupon->Value = $coupon->Value * $c2->Count;
//            $usercoupon->Insert();
            $cpns[] = serialize($usercoupon);

        } else {
            $usercoupon->Value = 0;
        }
    }

    $_SESSION[SESSION_ARRAY_COUPONS_TO_SAVE] = $cpns;

}


$fds = new FactorDataSource();
$fds->open();
$factor = new Factor();
$factor->Customer = $_COOKIE[COOKIE_CUSTOMER_ID];
$factor->Date = date("Y/m/d");
$fds->Insert($factor);
$selectedfactor = $fds->FindSomeoneFactorId($factor);
$fds->close();

if ($_GET['payment_method_id'] == 1 && $_GET['pay_price'] != 0) {
    $MerchantID = '4ae923a0-6a2d-11e7-bb3b-000c295eb8fc'; //Required
    $Amount = $_GET['pay_price']; //Amount will be based on Toman - Required
    $Amount = $_SESSION[SESSION_INT_PAY_PRICE]; //Amount will be based on Toman - Required
    $Description = 'پرداخت صورتحساب از درگاه زرین پال'; // Required
    $Email = $customer2->Email; // Optional
    $Mobile = $customer2->Mobile; // Optional
    $domain = $_SERVER['SERVER_NAME'];
    $CallbackURL = 'http://' . $domain . '/VerifyPayment.php'; // Required

    $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

    $result = $client->PaymentRequest(
        [
            'MerchantID' => $MerchantID,
            'Amount' => $Amount,
            'Description' => $Description,
            'Email' => $Email,
            'Mobile' => $Mobile,
            'CallbackURL' => $CallbackURL,
        ]
    );
}
foreach ($purchasebaskets as $pb) {
    $productcolor5 = new ProductColorDataSource();
    $productcolor5->open();
    $quantity5 = $productcolor5->FindQuantity($pb->Product->ProductId, $pb->Color);
    $productcolor5->close();

    if ($quantity5 - $pb->Count < 0) {

        $pbds = new  PurchaseBasketDataSource();
        $pbds->open();
        foreach ($purchasebaskets as $pb2) {
            $pbds->Delete($pb2->PurchaseBasketId);
        }
        $pbds->close();

        header('location:VerifyPayment.php?QuantityE=1');
        die();
    }
}


foreach ($purchasebaskets as $c) {
    if ($_GET['shipping_method_id'] == 0) {
        $shippingmethod = new ShippingMethod();
        $shippingmethod->Price = 0;
        $shippingmethod->Name = 'رایگان';
    } else {

        $shmethod = new ShippingMethodDataSource();
        $shmethod->open();
        $shippingmethod = $shmethod->FindOneShippingMethodBasedOnId($_GET['shipping_method_id']);
        $shmethod->close();
    }


    $guarantee = new GuaranteeDataSource();
    $guarantee->open();
    $guarantee1 = $guarantee->FindOneGuaranteeBasedOnId($c->Guarantee);
    $guarantee->close();


    $productcolor = new ProductColorDataSource();
    $productcolor->open();

    $productcolor2 = $productcolor->FindOneProductColorBasedOnId($c->Color);


    $productcolor3 = new ProductColor();
    $productcolor3->ProductColorId = $productcolor2->ProductColorId;


    $factorproduct = new FactorProduct();
    $factorproduct->Product = $c->Product->ProductId;
    $factorproduct->Date = date("Y/m/d");
    if ($c->Guarantee != 0) {
        $factorproduct->Price = ($price->GetLastPriceForOneProduct($c->Product->ProductId) - ($price->GetLastPriceForOneProduct($c->Product->ProductId) * $discount->GetLastDiscountForOneProduct($c->Product->ProductId) / 100) + $guarantee1->Guarantee->Price);
    } else {
        $factorproduct->Price = $price->GetLastPriceForOneProduct($c->Product->ProductId) - ($price->GetLastPriceForOneProduct($c->Product->ProductId) * $discount->GetLastDiscountForOneProduct($c->Product->ProductId) / 100);
    }
    $factorproduct->Factor = $selectedfactor;
    $factorproduct->Count = $c->Count;
    $productcolor3->Quantity = $productcolor2->Quantity - $c->Count;
    $productcolor->UpdateQuantity($productcolor3);

    $factorproduct->Coupon = $coupondiscout;
    $factorproduct->Color = $productcolor2->Color->Name;
    if ($c->Guarantee != 0) {
        $factorproduct->Guarantee = $guarantee1->Guarantee->Name . '  ' . $guarantee1->Guarantee->Duration;
    } else {
        $factorproduct->Guarantee = 'بدون گارانتی';
    }
    $factorproduct->PaymentMethod = $_GET['payment_method_id'];
    $factorproduct->ShippingMethod = $shippingmethod->Name . '-' . $shippingmethod->Price;
    $factorproduct->Status = 0;
    if ($factorproduct->PaymentMethod == 1) {
        $factorproduct->PaymentStatus = 0;
    } elseif ($factorproduct->PaymentMethod == 2) {
        $factorproduct->PaymentStatus = 4;
    } elseif ($factorproduct->PaymentMethod == 3) {
        $factorproduct->PaymentStatus = 5;
    }

    $factorproduct->Comment = $_GET['memo'];
    $factorproduct->Services = "";
    if (isset($_GET['checkbox'])) {
        foreach ($_GET['checkbox'] as $ch) {
            if ($factorproduct->Services != "") {
                $factorproduct->Services .= ',';
            }
//            $service->ServiceId = $ch;
            $s = $service->FindOneServiceBasedOnId($ch);
            $factorproduct->Services .= $s->Name . '-' . $s->Price;
        }
    }

    if (!isset($trace_code)) {
        while (1) {
            $trace_code = mt_rand(100000000, 999999999);

            $pods = new FactorProductDataSource();
            $pods->open();

            if ($pods->isCodeAvailable($trace_code) == true) {
                $factorproduct->TraceCode = $trace_code;
                break;
            }
            $pods->close();

        }
    } else {
        $factorproduct->TraceCode = $trace_code;
    }
    $factorproduct->Amount = $_GET['pay_price'];
    $factorproduct->Amount = $_SESSION[SESSION_INT_PAY_PRICE];

    if ($_GET['payment_method_id'] == 1 && $_GET['pay_price'] != 0) {
        $factorproduct->Authority = $result->Authority;
        $_SESSION[SESSION_STRING_CURRENT_AUTHORITY] = $result->Authority;
    } else {
        $factorproduct->Authority = "";
    }
    $pods = new FactorProductDataSource();
    $pods->open();
    $pods->Insert($factorproduct);
    $pods->close();
    $productcolor->close();
}
?>
<?php
if ($_GET['payment_method_id'] == 1) {
    if ($_GET['pay_price'] != 0) {
//Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {
            header('Location: https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
//برای استفاده از زرین گیت باید ادرس به صورت زیر تغییر کند:
//Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority.'/ZarinGate');
        } else {
            echo 'خطا: ' . $result->Status;
            echo "<br/>" . " لطفا دوباره امتحان کنید. ";
        }
    } else {
        header('Location:VerifyPayment.php?payment=0&code=' . $trace_code);
    }
} elseif ($_GET['payment_method_id'] == 2) {
    header('Location:VerifyPayment.php?payment=2&code=' . $trace_code);
} elseif ($_GET['payment_method_id'] == 3) {
    header('Location:VerifyPayment.php?payment=3&code=' . $trace_code);
}


$price->close();
$discount->close();
$service->close();
?>

