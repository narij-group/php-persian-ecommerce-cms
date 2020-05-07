<?php
include_once 'Template/top.php';
$_SESSION[SESSION_1_0_IS_PAYING_CANCELED] = 0;
?>
    <title>تایید سفارش</title>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/FactorProductDataSource.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductColorDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PurchaseBasketDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SettingsDataSource.inc';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/UserCouponDataSource.inc';

$message = 0;


if (isset($_GET['Authority']) && isset($_GET['Status'])) {
    $fp = new FactorProductDataSource();
    $fp->open();
    $fps = $fp->FindFactorProductsOnAuthority($_GET['Authority']);
    $fp->close();
    foreach ($fps as $f) {
        $factor_amount = $f->Amount;
        $customer = $f->Customer;
        $coupon_price = $f->Coupon;
    }
    $purchasebasket = new PurchaseBasketDataSource();
    $purchasebasket->open();
    $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($customer);
    $purchasebasket->close();

    $MerchantID = '4ae923a0-6a2d-11e7-bb3b-000c295eb8fc'; //Required
    $Amount = $factor_amount; //Amount will be based on Toman


    if ($_GET['Status'] == 'OK') {
        $Authority = $_GET['Authority'];
        $quantity_error_onrestore = 0;
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentVerification(
            [
                'MerchantID' => $MerchantID,
                'Authority' => $Authority,
                'Amount' => $Amount,
            ]
        );

        if ($result->Status == 100) {
            $quantity_restored = 0;
            if (isset($_COOKIE[COOKIE_QUANTITY_RESTORED]) && isset($_SESSION[SESSION_1_0_IS_QUANTITY_RESTORED]) && $_SESSION[SESSION_1_0_IS_QUANTITY_RESTORED] == "YES") {
                $quantity_restored = 1;
            }
            foreach ($purchasebaskets as $c1) {
                if ($quantity_restored == 1) {
                    $productcolor = new ProductColorDataSource();
                    $productcolor->open();
                    $productcolor2 = $productcolor->FindOneProductColorBasedOnId($c1->Color);
                    $productcolor3 = new ProductColor();
                    $productcolor3->ProductColorId = $productcolor2->ProductColorId;
                    $productcolor3->Quantity = $productcolor2->Quantity - $c1->Count;
                    if ($productcolor3->Quantity < 0) {
                        $quantity_error_onrestore = 1;
                    }
                    $productcolor->close();
                }
            }
            if ($quantity_error_onrestore != 1) {
                foreach ($purchasebaskets as $c1) {
                    if ($quantity_restored == 1) {
                        $productcolor = new ProductColorDataSource();
                        $productcolor->open();
                        $productcolor2 = $productcolor->FindOneProductColorBasedOnId($c1->Color);
                        $productcolor3 = new ProductColor();
                        $productcolor3->ProductColorId = $productcolor2->ProductColorId;
                        $productcolor3->Quantity = $productcolor2->Quantity - $c1->Count;
                        $productcolor->UpdateQuantity($productcolor3);
                        $productcolor->close();
                    }
                }
            }

            //TODO INSERT COUPONS AFETR PAYMENT VERIFCATION
            $cpns = $_SESSION[SESSION_ARRAY_COUPONS_TO_SAVE];
            foreach ($cpns as $cpn) {
                $s = $cpn;
                $uds = new UserCouponDataSource();
                $uds->open();
                $usercoupon = new UserCoupon();
                $usercoupon = unserialize($s);
                $uds->Insert($usercoupon);
                $uds->close();
            }


            foreach ($fps as $f) {
                $fpds = new FactorProductDataSource();
                $fpds->open();
                $fpds->UpdateRefId($f, $result->RefID);
                if ($quantity_error_onrestore != 1) {
                    $fpds->UpdatePaymentStatus($f->FactorProductId, 1);
                } else {
                    $fpds->UpdatePaymentStatus($f->FactorProductId, 6);
                }
                $tracecode = $f->TraceCode;
                $email = $f->Factor->Customer->Email;
                $mobile = $f->Factor->Customer->Mobile;


                $pcds = new ProductColorDataSource();
                $pcds->open();
                $productcolor = $pcds->FindOneProductColor2($f->Color, $f->Product);
                $pcds->close();

                if ($productcolor->Quantity == 0) {
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#wait').fadeIn(0);
                            $.ajax({
                                type: 'post',
                                url: 'AjaxSearch/ZeroQuantityEmail.php',
                                data: {product: <?php echo $f->Product; ?>},
                                success: function (res) {
                                    $('#wait').fadeOut(1000);

                                }
                            });
                        });
                    </script>
                    <?php
                }
                $fpds->close();
            }

            $purchasebasket = new PurchaseBasketDataSource();
            $purchasebasket->open();
            foreach ($purchasebaskets as $c1) {
                $purchasebasket->Delete($c1->PurchaseBasketId);
            }
            $purchasebasket->close();
            $message = 1;
        } else {
            $message = 2;
            if ($coupon_price != 0) {
                $userCoupon = new UserCouponDataSource();
                $userCoupon->open();
                $coupon = new UserCoupon();
                $coupon = $userCoupon->SomeoneCouponsSome2($customer);
                $userCoupon->Delete($coupon->UserCouponId);

//                echo "VER 1";


                $coupon->Value = $coupon_price / $settings->Coupon;
                $coupon->Customer = $customer;
                $coupon->Time = time();
                $userCoupon->Insert($coupon);

                $userCoupon->close();

            }

            foreach ($fps as $f) {
                if ($f->PaymentStatus == 0) {
                    $pcds = new ProductColorDataSource();
                    $pcds->open();
                    $productcolor = $pcds->FindOneProductColor2($f->Color, $f->Product);
                    $productcolor->Quantity = $productcolor->Quantity + $f->Count;
                    $pcds->UpdateQuantity($productcolor);

                    $f->UpdatePaymentStatus(1);

                } else {
                    ?>
                    <script>
                        window.location = "index.php";
                    </script>
                    <?php
                    die();
                }
            }
        }
    } else {
        if ($coupon_price != 0) {

            $usercoupons = $usercoupon->FindOneUserCoupons($customer);

            $userCoupon = new UserCoupon();
            $coupon = new UserCoupon();
            $coupon = $userCoupon->SomeoneCouponsSome2($customer);
            $coupon->Delete();
//        echo "VER 2";

            $coupon->Value = $coupon_price / $settings->Coupon;
            $coupon->Customer = $customer;
            $coupon->Time = time();
            $coupon->Insert();

        }

        $fpds = new FactorProductDataSource();
        $fpds->open();

        foreach ($fps as $f) {
            $productcolor = new ProductColor();
            $productcolor = $productcolor->FindOneProductColor2($f->Color, $f->Product);
            $productcolor->Quantity = $productcolor->Quantity + $f->Count;
            $productcolor->UpdateQuantity();

            $fpds->UpdatePaymentStatus($f->FactorProductId, 3);
        }
        $fpds->close();
        $message = 3;
    }
} elseif
(isset($_GET['payment']) && $_GET['code']
) {
    $fp = new FactorProductDataSource();
    $fp->open();
    $tracecode = $_GET['code'];
    $fps = $fp->FillByCode($_GET['code']);

    if ($_GET['payment'] == 0) {
        foreach ($fps as $f) {
            $fp->UpdatePaymentStatus($f->FactorProductId, 1);
            $fp->Sent($f->FactorProductId);
            $customer = $f->Factor->Customer->CustomerId;
            $email = $f->Factor->Customer->Email;
            $mobile = $f->Factor->Customer->Mobile;

            $pcds = new ProductColorDataSource();
            $pcds->open();
            $productcolor = $pcds->FindOneProductColor2($f->Color, $f->Product->ProductId);
            $pcds->close();
            if ($productcolor->Quantity == 0) {
                ?>
                <script>
                    $(document).ready(function () {
                        $('#wait').fadeIn(0);
                        $.ajax({
                            type: 'post',
                            url: 'AjaxSearch/ZeroQuantityEmail.php',
                            data: {product: <?php echo $f->Product->ProductId; ?>},
                            success: function (res) {
                                $('#wait').fadeOut(1000);
                            }
                        });
                    });
                </script>
                <?php
            }
        }

    } elseif ($_GET['payment'] == 2) {
        foreach ($fps as $f) {
            $fp->UpdatePaymentStatus($f->FactorProductId, 4);
            $customer = $f->Factor->Customer->CustomerId;
            $email = $f->Factor->Customer->Email;
            $mobile = $f->Factor->Customer->Mobile;

            $pcds = new ProductColorDataSource();
            $pcds->open();
            $productcolor = $pcds->FindOneProductColor2($f->Color, $f->Product->ProductId);
            $pcds->close();
            if ($productcolor->Quantity == 0) {
                ?>
                <script>
                    $(document).ready(function () {
                        $('#wait').fadeIn(0);
                        $.ajax({
                            type: 'post',
                            url: 'AjaxSearch/ZeroQuantityEmail.php',
                            data: {product: <?php echo $f->Product->ProductId; ?>},
                            success: function (res) {
                                $('#wait').fadeOut(1000);
                            }
                        });
                    });
                </script>
                <?php
            }
        }

    } elseif ($_GET['payment'] == 3) {
        foreach ($fps as $f) {
            $amount = $f->Amount;
            $fp->UpdatePaymentStatus($f->FactorProductId, 5);
            $customer = $f->Factor->Customer->CustomerId;
            $email = $f->Factor->Customer->Email;
            $mobile = $f->Factor->Customer->Mobile;


            $pcds = new ProductColorDataSource();
            $pcds->open();
            $productcolor = $pcds->FindOneProductColor2($f->Color, $f->Product->ProductId);
            $pcds->close();
            if ($productcolor->Quantity == 0) {
                ?>
                <script>
                    $(document).ready(function () {
                        $('#wait').fadeIn(0);
                        $.ajax({
                            type: 'post',
                            url: 'AjaxSearch/ZeroQuantityEmail.php',
                            data: {product: <?php echo $f->Product->ProductId; ?>},
                            success: function (res) {
                                $('#wait').fadeOut(1000);

                            }
                        });
                    });
                </script>
                <?php
            }

        }

    }


    $fp->close();


    $purchasebasket = new PurchaseBasketDataSource();
    $purchasebasket->open();
    $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($customer);

    if ($purchasebaskets != null) {
        foreach ($purchasebaskets as $c1) {
            $purchasebasket->Delete($c1->PurchaseBasketId);
        }
    }
    $purchasebasket->close();
}
if ($message == 1 || (isset($_GET['payment']) && $_GET['payment'] == 3) || (isset($_GET['payment']) && $_GET['payment'] == 2 ) || (isset($_GET['payment']) && $_GET['payment'] == 0 )) {
    if ($settings->SMS == 1) {
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SMSDataSource.inc';
        $value = 'سفارش شما با کد پیگیری ' . $tracecode . ' با موفقیت ثبت شد.';
        $sms = new SMSDataSource();
        $sms->recipientNumber = "'" . $mobile . "'";
        $sms->message = urlencode($value);
        $sms->enqueueSample();
    }

    if ($settings->isEmail == 1) {
        $email_message = "سفارش شما با موفقیت ثبت شد! شما میتوانید از طریق حساب کاربری خود وضعیت سفارش و ... را پیگیری کنید. کد پیگیری شما : " . $tracecode . "";
        ?>
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: 'PurchaseEmail.php',
                    type: 'POST',
                    data: {text: '<?php echo $email_message; ?>', email: "<?php echo $email; ?>"},
                    success: function () {
                    }
                });
            });
        </script>
        <?php
    }
}
include_once 'Template/menu.php';
?>
    <div class="container">
        <div class="main-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-view" id="db" style="position: relative;">
                        <div class="db-cover7" id="wait">
                            <span class="loading-title4">در حال آماده سازی...</span>
                            <img class="loading-gif7" src="Admin/Template/Images/gifs/loading.gif"/>
                        </div>
                        <div class="purchase-message">
                            <div class="main-title">نتیجه خرید شما</div>
                            <?php
                            if ($message == 1) {
                                ?>
                                <script>
                                    $(document).ready(function () {
                                        $('#wait').fadeIn(0);
                                        $.ajax({
                                            type: 'post',
                                            url: 'AjaxSearch/NewOrderEmail.php',
                                            data: {code: <?php echo $tracecode; ?>},
                                            success: function (res) {
                                                $('#wait').fadeOut(1000);

                                            }
                                        });
                                    });
                                </script>
                                <div class="message success">
                                    <?php
                                    //                        setcookie(COOKIE_QUANTITY_RESTORED, "NO", time() - 10);
                                    $_SESSION[SESSION_1_0_IS_QUANTITY_RESTORED] = "NO";
                                    //                        echo "پرداخت موفقیت آمیز بود، به زودی سفارش شما آماده و برای شما ارسال می شود.";
                                    echo "پرداخت با موفقیت انجام شد";
                                    echo "<br/>";
                                    echo "لطفا منتظر بررسی و پاسخ پشتیبانی تا لحظاتی  دیگر  باشید.";
                                    ?>
                                </div>
                                <?php
//                } elseif ($message == 1 && $quantity_error_onrestore == 1) {
////                setcookie(COOKIE_QUANTITY_RESTORED, "NO", time() - 10);
//                $_SESSION[SESSION_1_0_IS_QUANTITY_RESTORED] = "NO";
//                ?>
                                <!--                    <div class="message error">-->
                                <!--                        --><?php
//                        echo "پرداخت موفقیت آمیز بود، اما محصولات انتخابی موجود نمی باشند. وجه شما بهتان بازگردانده می شود.";
//                        echo "<br/>";
//                        echo "لطفا هر چه سریع تر با پشتیبانی تماس بگیرید.";
//                        ?>
                                <!--                    </div>-->
                                <!--                --><?php
                            } elseif ($message == 2) {
                            ?>
                                <div class="message error">
                                    <?php
                                    echo "متاسفانه پرداخت ناموفق بود!";
                                    echo '<br>';
                                    echo $result->Status;
                                    ?>
                                </div>
                            <?php
                            } elseif ($message == 3) {
                            ?>
                                <div class="message error">
                                    <?php
                                    echo "شما عملیات پرداخت را لغو کردید!";
                                    echo '<br>';
                                    echo 'اگر مشکلی وجود دارد سریعا به پشتیبانی اطلاع دهید.'
                                    ?>
                                </div>
                            <?php
                            } elseif (isset($_GET['payment']) && $_GET['payment'] == 0) {
                            ?>
                                <script>
                                    $(document).ready(function () {
                                        $('#wait').fadeIn(0);
                                        $.ajax({
                                            type: 'post',
                                            url: 'AjaxSearch/NewOrderEmail.php',
                                            data: {code: <?php echo $tracecode; ?>},
                                            success: function (res) {
                                                $('#wait').fadeOut(1000);

                                            }
                                        });
                                    });
                                </script>
                                <div class="message success">
                                    <?php
                                    echo "سفارش شما با موفقیت ثبت شد و و می توانید از بخش حساب کاربری آن را مشاهده نمایید.";
                                    ?>
                                </div>
                            <?php
                            } elseif (isset($_GET['payment']) && $_GET['payment'] == 2) {
                            ?>
                                <script>
                                    $(document).ready(function () {
                                        $('#wait').fadeIn(0);
                                        $.ajax({
                                            type: 'post',
                                            url: 'AjaxSearch/NewOrderEmail.php',
                                            data: {code: <?php echo $tracecode; ?>},
                                            success: function (res) {
                                                $('#wait').fadeOut(1000);

                                            }
                                        });
                                    });
                                </script>
                                <div class="message success">
                                    <?php
                                    echo "سفارش شما با موفقیت ثبت شد و به زودی برای شما ارسال می شود، لطفا وجه نقد را هنگام تحویل سفارش به پستچی بپردازید.";
                                    ?>
                                </div>
                            <?php
                            } elseif (isset($_GET['payment']) && $_GET['payment'] == 3) {
                            ?>
                                <script>
                                    $(document).ready(function () {
                                        $('#wait').fadeIn(0);
                                        $.ajax({
                                            type: 'post',
                                            url: 'AjaxSearch/NewOrderEmail.php',
                                            data: {code: <?php echo $tracecode; ?>},
                                            success: function (res) {
                                                $('#wait').fadeOut(1000);

                                            }
                                        });
                                    });
                                </script>
                                <div class="message success">
                                    <?php
                                    echo "سفارش شما با موفقیت ثبت شد .";
                                    ?>
                                </div>
                                <div class="message2 comment">
                                    <span>به زودی پشتیبانی با شما تماس میگیرد و اطلاعات لازم را در اختیارتان قرار میدهد.</span>
                                    <span>پرداخت آفلاین به صورت کارت به کارت یا واریز به حساب انجام میشود، بعد از اینکه پرداخت را انجام دادید باید اطلاعات فیش بانکی خود را در قسمت "حساب کاربری" خود وارد کنید. ( پرداخت سریع تر، ارسال سریع تر )</span>
                                    <br/>
                                    <span>مبلغ قابل پرداخت : <?php echo number_format($amount) . ' تومان' ?></span>
                                </div>
                            <?php
                            } elseif (isset($_GET['QuantityE']) && $_GET['QuantityE'] == 1) {
                            ?>
                                <div class="message error">
                                    <?php
                                    echo "متاسفانه کالا به این تعداد موجود نمی باشد!";
                                    ?>
                                </div>
                                <?php
                            }

                            if ($message == 1 || (isset($_GET['payment']) && $_GET['payment'] == 3) || (isset($_GET['payment']) && $_GET['payment'] == 2)) {
                                ?>
                                <div class="trace-code">
                                    <span class="title">کد پیگیری : </span><span
                                            class="code"><?php echo $tracecode; ?></span>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="profile-link">
                                <span>جهت اطلاعات بیشتر به <a href="UserProfile.php"> حساب کاربری خود </a> مراجعه کنید.</span>
                            </div>
                            <br/>
                            <div class="thank">باتشکر از خرید شما</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require_once 'Template/bottom.php';