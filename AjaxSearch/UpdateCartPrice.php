<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';

if (!isset($_SESSION))
    session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();
if ($settings->Tax != 0) {
    $tax = (100 + $settings->Tax) / 100;
} else {
    $tax = 1;
}

//$_SESSION[SESSION_INT_COUPON_DISCOUNT] = 0;

if (isset($_POST['shipping'])) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingMethodDataSource.inc';


    $smds = new ShippingMethodDataSource();
    $smds->open();
    $shippingmethod = $smds->FindOneShippingMethodBasedOnId($_POST['shippingmethod']);
    $smds->close();

    $shipping = new ShippingDataSource();
    $shipping->open();
    $shippings = $shipping->Fill();
    $shipping->close();
    $price = new Price();
    $cust = new CustomerDataSource();
    $cust->open();
    $customer = $cust->FindOneCustomerBasedOnId($_COOKIE ['CustomerId']);
    $cust->close();
    $shippingCost = 0;
    if (isset($customer) == TRUE && $_COOKIE ['CustomerId'] != 0) {
        foreach ($shippings as $shi) {
            if ($shi->City == $customer->Estate) {
                $shippingCost = $shi->Price;
            }
        }
    }
    echo number_format($shippingCost + $shippingmethod->Price) . ' تومان';
    $_SESSION[SESSION_INT_SHIPPING_COST] = $shippingCost + $shippingmethod->Price;

} elseif (isset($_POST['shipping2'])) {

    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PurchaseBasketDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PriceDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/DiscountDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/GuaranteeDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductColorDataSource.inc";

    $price = new PriceDataSource();
    $price->open();
    $discount = new DiscountDataSource();
    $discount->open();
    $purchasebasket = new PurchaseBasketDataSource();
    $purchasebasket->open();
    if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE ['CustomerId']);
    } else {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasketBaesOnSession(session_id());
    }


    $purchasebasket->close();


    $priceCounter = 0;

    foreach ($purchasebaskets as $p) {
        $productcolor = new ProductColorDataSource();
        $productcolor->open();
        $productcolor1 = $productcolor->FindOneProductColorBasedOnId($p->Color);
        $productcolor2 = $productcolor->FindOneProductColorBasedOnId($p->Color);
        $productcolor2->Color = $productcolor1->Color->ColorListId;
        $SelectedColor = $productcolor1->ProductColorId;
        $ColorQuantity = $productcolor->FindOneColorQuantity($productcolor2);
        $productcolor->close();
        if ($p->Guarantee == 0) {
            $SelectedGuarantee = 0;
        } else {
            $guarantee = new GuaranteeDataSource();
            $guarantee->open();
            $guarantee1 = $guarantee->FindOneGuaranteeBasedOnId($p->Guarantee);
            $guarantee->close();
            $SelectedGuarantee = $guarantee1->GuaranteeId;
        }
        if (isset($guarantee1) == TRUE) {
            $priceCounter += (((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100) + $guarantee1->Guarantee->Price) * $tax) * $p->Count);
        } else {
            $priceCounter += ((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100) * $tax) * $p->Count);
        }
    }

    $price->close();
    $discount->close();


    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';

    $shipping = new ShippingDataSource();
    $shipping->open();
    $shippings = $shipping->Fill();
    $shipping->close();


    $price = new Price();
    $cust = new CustomerDataSource();
    $cust->open();
    $customer = $cust->FindOneCustomerBasedOnId($_COOKIE ['CustomerId']);
    $cust->close();

    $shippingCost = 0;
    if (isset($customer) == TRUE && $_COOKIE ['CustomerId'] != 0) {
        foreach ($shippings as $shi) {
            if ($shi->City == $customer->Estate) {
                $shippingCost = $shi->Price;

            }
        }
    }

    if ($priceCounter > $settings->FreeShipping && $settings->FreeShipping != 0) {
        echo "رایگان!";
    } else {
        echo number_format($shippingCost + $_POST['extraprice']) . ' تومان';
        $_SESSION[SESSION_INT_SHIPPING_COST] = $shippingCost + $_POST['extraprice'];
    }


} elseif (isset($_POST['service'])) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ServiceDataSource.inc';
    $service = new ServiceDataSource();
    $service->open();
    $total = 0;
    if (isset($_POST['checkbox'])) {
        foreach ($_POST['checkbox'] as $c) {
            $service->ServiceId = $c;
            $s = $service->FindOneServiceBasedOnId($c);
            $total += $s->Price;
        }
        echo "<td>هزینه خدمات :</td>";
        echo '<td>' . number_format($total) . ' تومان</td>';
    }
    $_SESSION[SESSION_INT_SERVICE_COST] = $total;
    $service->close();

} elseif (isset($_POST['usecoupon'])) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

    $userCoupon = new UserCouponDataSource();
    $userCoupon->open();
    $coupons = $userCoupon->SomeoneCouponsSome($_COOKIE[COOKIE_CUSTOMER_ID]);
    $userCoupon->close();


    $purchasebasket = new PurchaseBasketDataSource();
    $purchasebasket->open();
    if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE ['CustomerId']);
    } else {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasketBaesOnSession(session_id());
    }

    $purchasebasket->close();

    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PriceDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/DiscountDataSource.inc";

    $price = new PriceDataSource();
    $price->open();

    $discount = new DiscountDataSource();
    $discount->open();

    $MaxCouponDiscount = 0;
    foreach ($purchasebaskets as $p) {
        $pricee = ((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId)
                        * $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100)) * $tax) * $p->Count;
        $MaxCouponDiscount += ($settings->MaxCouponPercentage / 100) * $pricee;
    }

    $price->close();
    $discount->close();


    if ($_POST['usecoupon'] == 1) {
        if ($coupons > $settings->MaxCoupon) {
            ?>
            <td>تخفیف برای شما :</td>
            <td><?php
                if ($MaxCouponDiscount > $settings->MaxCoupon * $settings->Coupon) {
                    echo number_format($settings->MaxCoupon * $settings->Coupon) . " تومان ";
                    $_SESSION[SESSION_INT_COUPON_DISCOUNT] = $settings->MaxCoupon * $settings->Coupon;
                } else {
                    echo number_format($MaxCouponDiscount) . " تومان ";
                    $_SESSION[SESSION_INT_COUPON_DISCOUNT] = $MaxCouponDiscount;


                }
                ?></td>

            <!--            echo " -- ";-->
            <!--            echo-->

            <?php
        } else {
            ?>
            <td>تخفیف برای شما :</td>
            <td><?php
                if ($MaxCouponDiscount > $coupons * $settings->Coupon) {
                    echo number_format($coupons * $settings->Coupon) . " تومان ";
                    $_SESSION[SESSION_INT_COUPON_DISCOUNT] = $coupons * $settings->Coupon;
                } else {
                    echo number_format($MaxCouponDiscount) . " تومان ";
                    $_SESSION[SESSION_INT_COUPON_DISCOUNT] = $MaxCouponDiscount;
                }
                ?></td>
            <?php
        }

//        echo "<td>11111111111111111111111</td>";
    } else {

//        echo "<td>00000000000000000000000</td>";
        $_SESSION[SESSION_INT_COUPON_DISCOUNT] = 0;
    }
} elseif (isset($_POST['rereshitemsnum'])) {

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
    $c = new PurchaseBasketDataSource();
    $c->open();
    echo $c->purchasebasketCounter($_COOKIE ['CustomerId'], session_id());
    $c->close();

} elseif (isset($_POST['basket']) && !isset($_POST['quantity'])) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PurchaseBasketDataSource.inc";
    $purchasebasket = new PurchaseBasketDataSource();
    $purchasebasket->open();
    $purchasebasket->Delete($_POST['basket']);
    $purchasebasket->close();
} elseif (isset($_POST['basket']) && isset($_POST['quantity'])) {


    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PurchaseBasketDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PriceDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/DiscountDataSource.inc";
    $_SESSION[SESSION_INT_COUPON_DISCOUNT] = 0;
    $price = new PriceDataSource();
    $price->open();
    $discount = new DiscountDataSource();
    $discount->open();


    $pbds = new PurchaseBasketDataSource();
    $pbds->open();
    $purchasebasket = new PurchaseBasket();
    $purchasebasket->PurchaseBasketId = $_POST['basket'];
    $purchasebasket->Count = $_POST['quantity'];
    $pbds->UpdateQuantity($purchasebasket);

    if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
        $pp = $pbds->FindOnePurchaseBasket($_POST['basket']);
    } else {
        $pp = $pbds->FindOnePurchaseBasketBasedOnSession($_POST['basket']);
    }


    $pbds->close();

    if (isset($_POST['guarantee'])) {
        $guarantee = $_POST['guarantee'];
    } else {
        $guarantee = 0;
    }
    echo "<div class='DatabaseField' >" . number_format(((($price->GetLastPriceForOneProduct($pp->Product->ProductId) - ($price->GetLastPriceForOneProduct($pp->Product->ProductId) * $discount->GetLastDiscountForOneProduct($pp->Product->ProductId)) / 100) + $guarantee) * $tax) * $pp->Count) . " تومان </div>";
    ?>
    <div class="db-cover2" id="wait<?php echo $_POST['basket']; ?>">
        <span class="loading-title2">در حال محاسبه...</span>
        <img class="loading-gif2" src="Admin/Template/Images/gifs/loading.gif"/>
    </div>
    <?php


} elseif (isset($_POST['update_mainprice'])) {


    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PurchaseBasketDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PriceDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/DiscountDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/GuaranteeDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductColorDataSource.inc";

    $price = new PriceDataSource();
    $price->open();

    $discount = new DiscountDataSource();
    $discount->open();

    $purchasebasket = new PurchaseBasketDataSource();
    $purchasebasket->open();
    if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE ['CustomerId']);
    } else {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasketBaesOnSession(session_id());
    }

    $purchasebasket->close();


    $priceCounter = 0;

    foreach ($purchasebaskets as $p) {
        $productcolor = new ProductColorDataSource();
        $productcolor->open();
        $productcolor1 = $productcolor->FindOneProductColorBasedOnId($p->Color);
        $productcolor2 = $productcolor->FindOneProductColorBasedOnId($p->Color);
        $productcolor2->Color = $productcolor1->Color->ColorListId;
        $SelectedColor = $productcolor1->ProductColorId;
        $ColorQuantity = $productcolor->FindOneColorQuantity($productcolor2);
        $productcolor->close();

        if ($p->Guarantee == 0) {
            $SelectedGuarantee = 0;
        } else {
            $guarantee = new GuaranteeDataSource();
            $guarantee->open();
            $guarantee1 = $guarantee->FindOneGuaranteeBasedOnId($p->Guarantee);
            $guarantee->close();
            $SelectedGuarantee = $guarantee1->GuaranteeId;
        }
        if (isset($guarantee1) == TRUE) {
            $priceCounter += (((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) *
                                $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100) + $guarantee1->Guarantee->Price) * $tax) * $p->Count);
        } else {
            $priceCounter += ((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) *
                            $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100) * $tax) * $p->Count);
        }
    }
    if (isset($_POST['price_id'])) {
        $_SESSION[SESSION_INT_SHIPPING_COST] = $_POST['price_id'];
    }
    echo number_format($priceCounter + $_SESSION[SESSION_INT_SHIPPING_COST] + $_SESSION[SESSION_INT_SERVICE_COST] - $_SESSION[SESSION_INT_COUPON_DISCOUNT]) . " تومان  ";
    $_SESSION[SESSION_INT_PAY_PRICE] = $priceCounter + $_SESSION[SESSION_INT_SHIPPING_COST] + $_SESSION[SESSION_INT_SERVICE_COST] - $_SESSION[SESSION_INT_COUPON_DISCOUNT];
    ?>
    <input type="hidden" id="pay_price" name="pay_price"
           value="<?php echo $priceCounter + $_SESSION[SESSION_INT_SHIPPING_COST] + $_SESSION[SESSION_INT_SERVICE_COST] - $_SESSION[SESSION_INT_COUPON_DISCOUNT]; ?>"/>
    <?php
} elseif (isset($_POST['update_basketprice'])) {


    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PurchaseBasketDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PriceDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/DiscountDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/GuaranteeDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductColorDataSource.inc";

    $price = new PriceDataSource();
    $price->open();
    $discount = new DiscountDataSource();
    $discount->open();
    $purchasebasket = new PurchaseBasketDataSource();
    $purchasebasket->open();

    if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE ['CustomerId']);
    } else {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasketBaesOnSession(session_id());
    }

    $purchasebasket->close();


    $priceCounter = 0;

    foreach ($purchasebaskets as $p) {
        $productcolor = new ProductColorDataSource();
        $productcolor->open();
        $productcolor1 = $productcolor->FindOneProductColorBasedOnId($p->Color);
        $productcolor2 = $productcolor->FindOneProductColorBasedOnId($p->Color);
        $productcolor2->Color = $productcolor1->Color->ColorListId;
        $SelectedColor = $productcolor1->ProductColorId;
        $ColorQuantity = $productcolor->FindOneColorQuantity($productcolor2);
        $productcolor->close();
        if ($p->Guarantee == 0) {
            $SelectedGuarantee = 0;
        } else {
            $guarantee = new GuaranteeDataSource();
            $guarantee->open();
            $guarantee1 = $guarantee->FindOneGuaranteeBasedOnId($p->Guarantee);
            $guarantee->close();

            $SelectedGuarantee = $guarantee1->GuaranteeId;
        }
        if (isset($guarantee1) == TRUE) {
            $priceCounter += (((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100) + $guarantee1->Guarantee->Price) * $tax) * $p->Count);
        } else {
            $priceCounter += ((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100) * $tax) * $p->Count);
        }
    }
    ?>

    <div class="db-cover4" id="pricewait">
        <span class="loading-title4">در حال محاسبه...</span>
        <img class="loading-gif4" src="Admin/Template/Images/gifs/loading.gif"/>
    </div><?php
    if (isset($purchasebaskets[0]) && ($purchasebaskets[0]->Customer->Estate == "" || $purchasebaskets[0]->Customer->Estate == 0) || ($purchasebaskets[0]->Customer->City == "" || $purchasebaskets[0]->Customer->City == 0)) {
//        ?>
        <!--        <div class="db-cover4" style="display: block;">-->
        <!--            <span class="loading-title5">لطفا اطلاعات حساب خود را تکمیل کنید</span>-->
        <!--            <img class="loading-gif4" src="Admin/Template/Images/gifs/loading.gif"/>-->
        <!--        </div>-->
        <!--        --><?php
    }
    echo number_format($priceCounter) . " تومان  ";


} elseif (isset($_POST['reload'])) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
    $c = new PurchaseBasketDataSource();
    $c->open();
    if ($c->PurchaseBasketCounter($_COOKIE ['CustomerId']) == 0) {
        ?>
        <script>
            $(document).ready(function () {
                location.reload();
            });
        </script>
        <?php
    }
    $c->close();
} elseif (isset($_POST['refresh_shippings'])) {
    ?>
    <script>
        $(document).ready(function () {
            $('tr').click(
                function () {
                    $(this).find('td input:radio').prop('checked', true);
                }
            );
            $('.shippingmethod_tr').click(
                function () {
                    $('#pricewait').fadeIn(0);
                    $.ajax({
                        url: 'AjaxSearch/UpdateCartPrice.php',
                        type: 'POST',
                        data: $('#shippingmethod-form').serialize(),
                        success: function (data) {
                            $('#shipping-cost').html(data);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/UpdateCartPrice.php',
                        data: {update_mainprice: 1},
                        success: function (data) {
                            $('#main_price').html(data);
                        }
                    });
                    $(".shippingmethod_tr").removeAttr('class', 'tr_back');
                    $(this).attr('class', 'shippingmethod_tr tr_back');
                    $('#pricewait').fadeOut(0);
                    $('#shipping_method_id').attr('value', $('.shippingmethod_tr input:checked').val());
                }
            );
        });
    </script>
    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PurchaseBasketDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/PriceDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/DiscountDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/GuaranteeDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductColorDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ShippingDataSource.inc";

    $shipping = new ShippingDataSource();
    $shipping->open();
    $shippings = $shipping->Fill();
    $shipping->close();

    $price = new PriceDataSource();
    $price->open();
    $discount = new DiscountDataSource();
    $discount->open();

    $purchasebasket = new PurchaseBasketDataSource();
    $purchasebasket->open();

    if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE ['CustomerId']);
    } else {
        $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasketBaesOnSession(session_id());
    }

    $purchasebasket->close();


    $priceCounter = 0;

    foreach ($purchasebaskets as $p) {
        $estate = $p->Customer->Estate;
        $city = $p->Customer->City;

        $productcolor = new ProductColorDataSource();
        $productcolor->open();
        $productcolor1 = $productcolor->FindOneProductColorBasedOnId($p->Color);
        $productcolor2 = $productcolor->FindOneProductColorBasedOnId($p->Color);
        $productcolor2->Color = $productcolor1->Color->ColorListId;
        $SelectedColor = $productcolor1->ProductColorId;
        $ColorQuantity = $productcolor->FindOneColorQuantity($productcolor2);
        $productcolor->close();
        if ($p->Guarantee == 0) {
            $SelectedGuarantee = 0;
        } else {
            $guarantee = new GuaranteeDataSource();
            $guarantee->open();
            $guarantee1 = $guarantee->FindOneGuaranteeBasedOnId($p->Guarantee);
            $SelectedGuarantee = $guarantee1->GuaranteeId;
        }
        if (isset($guarantee1) == TRUE) {
            $priceCounter += (((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100) + $guarantee1->Guarantee->Price) * $tax) * $p->Count);
        } else {
            $priceCounter += ((($price->GetLastPriceForOneProduct($p->Product->ProductId) - ($price->GetLastPriceForOneProduct($p->Product->ProductId) * $discount->GetLastDiscountForOneProduct($p->Product->ProductId)) / 100) * $tax) * $p->Count);
        }
    }
    ?>
    <div class="db-cover3" id="shippingwait">
        <!--        <span class="loading-title3">در حال پردازش...</span>-->
        <img class="loading-gif3" src="Admin/Template/Images/gifs/loading.gif"/>
    </div>
    <?php
    if ($priceCounter > $settings->FreeShipping && $settings->FreeShipping != 0) {
        $_SESSION[SESSION_INT_SHIPPING_COST] = 0;
        ?>
        <script>
            $(document).ready(function () {
                $('#shipping-cost').html('رایگان!');
            });
        </script>
        <table border="0">
            <tr class="tr_back">
                <td>
                    <input checked id="" value="0" class="radio-custom" name="shippingmethod"
                           type="radio">
                    <label for="" class="radio-custom-label"></label>
                </td>
                <td>
                    <img src="Template/Images/freedelivery.jpg"/>
                    <div class="shippingtype">ارسال رایگان</div>
                    <br/><br/>
                    <div class="shippingtype_comment">هزینه ارسال برای خرید های
                        بالای <?php echo number_format($settings->FreeShipping); ?> تومان رایگان
                        می
                        باشد! از خرید خود لذت ببرید.
                    </div>
                </td>
            </tr>
        </table>
        <?php
    } else {
        require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ShippingMethodDataSource.inc";
        $shippingmethod = new ShippingMethodDataSource();
        $shippingmethod->open();
        $shmethods = $shippingmethod->CFill();
        $shippingmethod->close();
        $i = 1;
        ?>
        <table border="0">
            <input type="hidden" id="shipping" name="shipping"/>
            <?php
            foreach ($shmethods as $sh) {
                if (trim($sh->AllowedCities) != "") {
                    $cities = explode(' ', trim(str_replace(",", " ", $sh->AllowedCities)));
                    if (in_array($city, $cities) != false) {
                        ?>
                        <tr class="shippingmethod_tr <?php
                        if ($i == 1) {
                            echo ' tr_back ';
                        }
                        ?>">
                            <td>
                                <input <?php
                                if ($i == 1) {
                                    echo ' checked  id = "first_sh_method" ';
                                    $shippingCost = $sh->Price;
                                    $_SESSION[SESSION_INT_SHIPPING_COST] = $sh->Price;
                                }
                                ?> class="radio-custom" name="shippingmethod" type="radio"
                                   value="<?php echo $sh->ShippingMethodId; ?>">
                                <label for="" class="radio-custom-label"></label>
                            </td>
                            <td>
                                <img src="<?php echo $sh->Image; ?>"/>
                                <div class="shippingtype"><?php echo $sh->Name; ?></div>
                                <br/><br/>
                                <div class="shippingtype_comment"><?php echo $sh->Comment; ?></div>
                            </td>
                        </tr>
                        <?php
                        $i = 0;
                    }
                } else {
                    ?>
                    <tr class="shippingmethod_tr <?php
                    if ($i == 1) {
                        echo ' tr_back ';
                    }
                    ?>">
                        <td>
                            <input <?php
                            if ($i == 1) {
                                echo ' checked ';
                                $shippingCost = $sh->Price;
                                $_SESSION[SESSION_INT_SHIPPING_COST] = $sh->Price;
                            }
                            ?> id="" class="radio-custom" name="shippingmethod" type="radio"
                               value="<?php echo $sh->ShippingMethodId; ?>">
                            <label for="" class="radio-custom-label"></label>
                        </td>
                        <td>
                            <img src="<?php echo $sh->Image; ?>"/>
                            <div class="shippingtype"><?php echo $sh->Name; ?></div>
                            <br/><br/>
                            <div class="shippingtype_comment"><?php echo $sh->Comment; ?></div>
                        </td>
                    </tr>
                    <?php
                    $i = 0;
                }
            }
            foreach ($shippings as $shi) {
                if ($shi->City == $estate) {
                    $shippingCost += $shi->Price;
                    $_SESSION[SESSION_INT_SHIPPING_COST] += $shi->Price;
                }
            }
            ?>
        </table>
        <script>
            $(document).ready(function () {
                $('#shipping-cost').html('<?php echo number_format($shippingCost) . ' تومان '; ?>');
            });
        </script>
        <?php
    }
    ?>
    <?php
}