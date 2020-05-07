<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/ShippingMethodDataSource.inc";

$shippingmethod = new ShippingMethodDataSource();
$shippingmethod->open();
$shmethods = $shippingmethod->CFill();
$shippingmethod->close();
$i = 1;
foreach ($shmethods as $sh) {
    if ($i == 1) {
        $extrashippingprice = $sh->Price;
        $i++;
    }
}


//
//$userCoupon = new UserCoupon();
//$coupons = $userCoupon->SomeoneCouponsSome($_COOKIE[COOKIE_CUSTOMER_ID]);


?>
    <title>سبد خرید</title>
    <meta name="description" content="Shopping Cart"/>
<?php
include_once 'Template/menu.php';
?>
    <div class="container">
        <div class="main-container">
            <div class="product-view" id="db">
                <div id="reloader"></div>
                <?php

                //        if (!isset($_COOKIE [COOKIE_CUSTOMER_ID]) || $_COOKIE [COOKIE_CUSTOMER_ID] == 0) {
                //            echo "<span style='font-size: 11pt;'>جهت خرید باید وارد حساب خود شوید یا حساب جدیدی بسازید.</span>";
                //        }

                //        if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {


                if (true) {
                    ?>
                    <div class="cart" id="cart">
                        <?php
                        $_SESSION[SESSION_INT_SERVICE_COST] = 0;
                        $_SESSION[SESSION_INT_SHIPPING_COST] = 0;
                        $_SESSION[SESSION_INT_COUPON_DISCOUNT] = 0;
                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PurchaseBasketDataSource.inc';
                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/DiscountDataSource.inc';
                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GuaranteeDataSource.inc';
                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductColorDataSource.inc';
                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PriceDataSource.inc';
                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CustomerDataSource.inc';
                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ShippingDataSource.inc';


                        if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {

                            $cust = new CustomerDataSource();
                            $cust->open();
                            $customer = $cust->FindOneCustomerBasedOnId($_COOKIE [COOKIE_CUSTOMER_ID]);
                            $cust->close();
                        }

                        $shipping = new ShippingDataSource();
                        $shipping->open();
                        $shippings = $shipping->Fill();
                        $shipping->close();

                        $shippingCost = 0;
                        if (isset($customer) == TRUE && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                            foreach ($shippings as $shi) {
                                if ($shi->City == $customer->Estate) {
                                    $shippingCost = $shi->Price;
                                    $_SESSION[SESSION_INT_SHIPPING_COST] += $shi->Price;
                                }
                            }
                        }


                        $purchasebasket = new PurchaseBasketDataSource();
                        $purchasebasket->open();
                        if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                            $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE [COOKIE_CUSTOMER_ID]);
                        } else {
                            $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasketBaesOnSession(session_id());
                        }
                        $purchasebasket->close();

                        if ($purchasebaskets != NULL) {
                            ?>
                            <div class="FillOut" style="margin-top: 0;">
                                <div class="title">
                                    <span>سبد خرید</span>
                                </div>
                            </div>


                            <!--                            <div class="table-responsive">-->
                            <!--                                <table border="0" class="table">-->
                            <!--                                    --><?php
//                                    if ($purchasebaskets != NULL) {
//                                        ?>
                            <!--                                        <tr>-->
                            <!--                                            <th style="min-width: 350px;">شرح محصول</th>-->
                            <!--                                            <th>رنگ محصول</th>-->
                            <!--                                            <th>گارانتی محصول</th>-->
                            <!--                                            <th>تعداد</th>-->
                            <!--                                            <th>قیمت واحد</th>-->
                            <!--                                            <th>قیمت کل</th>-->
                            <!--                                            <th class="delete"></th>-->
                            <!---->
                            <!--                                        </tr>-->
                            <ul id="accordion2" class="accordion2">
                                <?php
                                //                                    }

                                $priceCounter = 0;

                                $discount = new DiscountDataSource();
                                $discount->open();

                                $price = new PriceDataSource();
                                $price->open();


                                foreach ($purchasebaskets as $p) {
                                    if ($p->Product->Activated == 1) {


                                        $last_price = $price->GetLastPriceForOneProduct($p->Product->ProductId);
                                        $last_discount = $discount->GetLastDiscountForOneProduct($p->Product->ProductId);

                                        echo "<li  id='item$p->PurchaseBasketId'>";
                                        echo "<div class='link'><i class='fa fa-chevron-down'></i><img src='" . $p->Product->Image . "' />";
                                        echo $p->Product->Name;
                                        echo '</div>';

                                        $productcolor = new ProductColorDataSource();
                                        $productcolor->open();
//                                    $productcolor->ProductColorId = $p->Color;
                                        $productcolor1 = $productcolor->FindOneProductColorBasedOnId($p->Color);
                                        $productcolor2 = $productcolor->FindOneProductColorBasedOnId($p->Color);
                                        $productcolor->close();


                                        if ($productcolor2 == null || $productcolor1 == null) {
                                            $ColorQuantityCheck = 0;
                                        } else {

                                            $productcolor = new ProductColorDataSource();
                                            $productcolor->open();

                                            $productcolor2->Color = $productcolor1->Color->ColorListId;
                                            $SelectedColor = $productcolor1->ProductColorId;
                                            $ColorQuantity = $productcolor->FindOneColorQuantity($productcolor2);
                                            $productcolor->close();
                                            $ColorQuantityCheck = 1;
                                            if ($ColorQuantity <= 0 && $ColorQuantityCheck != 0) {
                                                $ColorQuantityCheck = 0;
                                            }
                                        }

                                        $guarantee = new GuaranteeDataSource();
                                        $guarantee->open();
//                                    $guarantee->GuaranteeId = $p->Guarantee;
                                        if ($p->Guarantee == 0) {
                                            $SelectedGuarantee = 0;
                                            $guarantee1 = new Guarantee();
                                            $guarantee1->Guarantee->Price = 0;
                                        } else {
                                            $guarantee1 = $guarantee->FindOneGuaranteeBasedOnId($p->Guarantee);
                                            $SelectedGuarantee = $guarantee1->GuaranteeId;
                                        }
                                        $guarantee->close();
                                        echo '<ul class="submenu2">';

                                        echo "<li><span class='desc'>شرح محصول : </span><a style='margin: 0; padding: 0; text-decoration: none;' target='_blank' href='Post.php?id=" . $p->Product->ProductId . "'><div class='DatabaseField' ><div class='cart-image-container'><img src='" . $p->Product->Image . "' /></div></div></a>";
                                        echo "<div class='Names''><span title='" . $p->Product->Name . "' >" . $p->Product->Name . "</span><span style='direction:ltr;' title='" . $p->Product->LatinName . "'>" . $p->Product->LatinName . "</span></div></li>";
                                        echo '<div class="clear-fix"></div>';
                                        if ($productcolor1 == null) {
                                            echo "<li><span class='desc'>رنگ محصول : </span><div class='DatabaseField' >رنگ ناموجود</div></li>";
                                        } else {
                                            echo "<li><span class='desc'>رنگ محصول : </span><div class='DatabaseField' >" . $productcolor1->Color->Name . "</div></li>";
                                        }
                                        if ($p->Guarantee != 0) {
                                            echo "<li><span class='desc'>گارانتی محصول : </span><div class='DatabaseField' >" . $guarantee1->Guarantee->Name . '  ' . $guarantee1->Guarantee->Duration . "</div></li>";
                                        } else {
                                            echo "<li><span class='desc'>گارانتی محصول : </span><div class='DatabaseField' >فاقد گارانتی</div></li>";
                                        }
                                        echo "<li><span class='desc'>تعداد : </span><select id='QuantityComboBox$p->PurchaseBasketId' class='DatabaseField' >";
                                        for ($i = 1; $i <= $ColorQuantity; $i++) {
                                            echo "<option ";
                                            if ($i == $p->Count) {
                                                echo "selected";
                                            }
                                            echo ">$i</option>";
                                        }
                                        echo "</select></li>";
                                    if (isset($guarantee1) == TRUE) {
                                        echo "<li ><span class='desc'>قیمت واحد : </span><div class='DatabaseField' >" . number_format(($last_price - ($last_price * $last_discount / 100) + $guarantee1->Guarantee->Price) * $tax) . " تومان </div></li>";
                                        echo "<li style='position: relative;' id='total-price$p->PurchaseBasketId'><span class='desc'>قیمت کل : </span><div class='DatabaseField' >" . number_format(((($last_price - ($last_price * $last_discount) / 100) + $guarantee1->Guarantee->Price) * $tax) * $p->Count) . " تومان </div>";
                                        ?>
                                        <div class="db-cover2" id="wait<?php echo $p->PurchaseBasketId; ?>">
                                            <span class="loading-title2">در حال محاسبه...</span>
                                            <img class="loading-gif2" src="Admin/Template/Images/gifs/loading.gif"/>
                                        </div>
                                        <?php
                                        echo "</li>";
                                    } else {
                                        echo "<li><span class='desc'>قیمت واحد : </span><div class='DatabaseField' >" . number_format(($last_price - ($last_price * $last_discount / 100)) * $tax) . " تومان </div></li>";
                                        echo "<li style='position: relative;' id='total-price$p->PurchaseBasketId'><span class='desc'>قیمت کل : </span><div class='DatabaseField' >" . number_format((($last_price - ($last_price * $last_discount) / 100) * $tax) * $p->Count) . " تومان </div>";
                                        ?>
                                        <div class="db-cover2" id="wait<?php echo $p->PurchaseBasketId; ?>">
                                            <span class="loading-title2">در حال محاسبه...</span>
                                            <img class="loading-gif2" src="Admin/Template/Images/gifs/loading.gif"/>
                                        </div>
                                    <?php
                                    echo "</li>";
                                    }
                                    ?>
                                        <li class='Delete1'>
                                            <div class='Delete'><input
                                                        id='Delete<?php echo $p->PurchaseBasketId; ?>'
                                                        onmouseover=''
                                                        type='button' id="delete"/></div>
                                        </li>
                                    <?php
                                    echo "</ul>";
                                    echo "</li>";
                                    if (isset($guarantee1) == TRUE) {
                                        $priceCounter += (((($last_price - ($last_price * $last_discount) / 100) + $guarantee1->Guarantee->Price) * $tax) * $p->Count);
                                    } else {
                                        $priceCounter += ((($last_price - ($last_price * $last_discount) / 100) * $tax) * $p->Count);
                                    }
                                    ?>
                                        <script>
                                            $(document).ready(function () {
                                                $('#QuantityComboBox<?php echo $p->PurchaseBasketId; ?>').change(
                                                    function () {
                                                        $('#usecoupon').prop('checked', false);
                                                        $('#prices').html('');
                                                        $('#wait<?php echo $p->PurchaseBasketId; ?>').fadeIn(0);
                                                        $('#pricewait').fadeIn(0);
                                                        <?php
                                                        if($settings->FreeShipping != 0){
                                                        ?>
                                                        $('#shippingwait').fadeIn(0);
                                                        <?php
                                                        }
                                                        ?>
                                                        $.ajax({
                                                            url: 'AjaxSearch/UpdateCartPrice.php',
                                                            type: 'POST',
                                                            data: {
                                                                quantity: $('#QuantityComboBox<?php echo $p->PurchaseBasketId; ?>').val(),
                                                                basket: <?php echo $p->PurchaseBasketId; ?> <?php if (isset($guarantee1) == TRUE) {
                                                                echo ', guarantee : ' . $guarantee1->Guarantee->Price;
                                                            }  ?> },
                                                            success: function (data) {
                                                                $('#total-price<?php echo $p->PurchaseBasketId; ?>').html(data);

                                                                $.ajax({
                                                                    type: 'POST',
                                                                    url: 'AjaxSearch/UpdateCartPrice.php',
                                                                    data: {rereshitemsnum: 1},
                                                                    success: function (data) {
                                                                        $('#total_items').val(data);
                                                                    }
                                                                });


                                                            }
                                                        });
                                                        <?php
                                                        if($settings->FreeShipping != 0){
                                                        ?>
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'AjaxSearch/UpdateCartPrice.php',
                                                            data: {refresh_shippings: 1},
                                                            success: function (data) {
                                                                $('#shippingmethods').html(data);
                                                            }
                                                        });
                                                        <?php
                                                        }
                                                        ?>
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'AjaxSearch/UpdateCartPrice.php',
                                                            data: {update_mainprice: 1},
                                                            success: function (data) {
                                                                $('#main_price').html(data);

                                                            }
                                                        });
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'AjaxSearch/UpdateCartPrice.php',
                                                            data: {update_basketprice: 1},
                                                            success: function (data) {
                                                                $('#basket_price').html(data);
                                                            }
                                                        });
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'AjaxSearch/UpdateCartPrice.php',
                                                            data: {rereshitemsnum: 1},
                                                            success: function (data) {
                                                                $('#total_items').val(data);
                                                                $('#pricewait').fadeOut(0);
                                                            }
                                                        });
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: 'AjaxSearch/UpdateCartPrice.php',
                                                            data: {
                                                                shipping2: 1,
                                                                extraprice: <?php echo $extrashippingprice; ?>},
                                                            success: function (data) {
                                                                $('#shipping-cost').html(data);
                                                            }
                                                        });
                                                    }
                                                );

                                                $('#Delete<?php echo $p->PurchaseBasketId; ?>').click(
                                                    function () {
                                                        if (confirm('آیا می خواهید این محصول را حذف کنید ؟')) {
                                                            $('#pricewait').fadeIn(0);

                                                            <?php
                                                            if($settings->FreeShipping != 0){
                                                            ?>
                                                            $('#shippingwait').fadeIn(0);
                                                            <?php
                                                            }
                                                            ?>
                                                            $.ajax({
                                                                url: 'AjaxSearch/UpdateCartPrice.php',
                                                                type: 'POST',
                                                                data: {
                                                                    basket: <?php echo $p->PurchaseBasketId; ?> },
                                                                success: function (data) {
                                                                    $('#item<?php echo $p->PurchaseBasketId; ?>').fadeOut(200);
                                                                }
                                                            });
                                                            $.ajax({
                                                                url: 'AjaxSearch/UpdateCartPrice.php',
                                                                type: 'POST',
                                                                data: {reload: 1},
                                                                success: function (data) {
                                                                    $('#reloader').html(data);
                                                                    window.location.reload();
                                                                }
                                                            });
                                                        }
                                                    }
                                                );
                                            });
                                        </script>
                                        <?php
                                    } else {
                                        $pbds1 = new PurchaseBasketDataSource();
                                        $pbds1->open();
                                        $pbds1->Delete($p->PurchaseBasketId);
                                        $pbds1->close();
                                    }
                                }


                                $discount->close();
                                $price->close();


                                ?>
                            </ul>

                            <div class="FillOut" id="ur-info">
                                <div class="title">
                                    <span>اطلاعات شما</span>
                                </div>


                                <?php
                                //                                if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                                //                                if (true) {
                                ?>
                                <div class="body" style="position: relative;">
                                    <div class="note">پر کردن تمام اطلاعات این قسمت ضروری است</div>
                                    <select class="double-input2 " required id="cestate" name="cestate">
                                        <option value="0">انتخاب استان...</option>
                                        <?php
                                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProvinceDataSource.inc';
                                        $province = new ProvinceDataSource();
                                        $province->open();
                                        $provinces = $province->Fill();
                                        $province->close();
                                        foreach ($provinces as $pr) {
                                            echo "<option value='$pr->ProvinceId' ";

                                            if (isset($_SESSION[SESSION_EARLY_CUSTOMER__STATE_DATA]) == true && $_SESSION[SESSION_EARLY_CUSTOMER__STATE_DATA] == $pr->ProvinceId) {
                                                echo ' selected ';
                                            } else if (isset($_SESSION[SESSION_EARLY_CUSTOMER__STATE_DATA]) == false && isset($customer) == true && $customer->Estate == $pr->ProvinceId) {
                                                echo ' selected ';
                                            }

                                            echo ">";
                                            echo $pr->Name;
                                            echo '</option>';
                                        }
                                        ?>
                                    </select>
                                    <select class="double-input2" required id="ccity" name="ccity">
                                        <option value="0">انتخاب شهر...</option>
                                        <?php
                                        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CityDataSource.inc';

                                        $city = new CityDataSource();
                                        $city->open();
                                        if (isset($_SESSION[SESSION_EARLY_CUSTOMER__STATE_DATA]) == true && $_SESSION[SESSION_EARLY_CUSTOMER__STATE_DATA] != "") {
                                            $cities = $city->GetOneProvinceCities($_SESSION[SESSION_EARLY_CUSTOMER__STATE_DATA]);
                                        } else if (isset($customer->Estate) && trim($customer->Estate) != "") {
                                            $cities = $city->GetOneProvinceCities($customer->Estate);
                                        } else {
                                            $cities = $city->GetOneProvinceCities(1);
                                        }
                                        if (isset($customer) == true || $customer->Estate != 0) {
                                            foreach ($cities as $ct) {
                                                echo "<option value='$ct->CityId'";

                                                if (isset($_SESSION[SESSION_EARLY_CUSTOMER__CITY_DATA]) == true && $_SESSION[SESSION_EARLY_CUSTOMER__CITY_DATA] == $ct->CityId) {
                                                    echo ' selected ';
                                                } else if (isset($customer) == true && $customer->City == $ct->CityId) {
                                                    echo ' selected ';
                                                }
                                                echo ">";
                                                echo $ct->Name;
                                                echo '</option>';
                                            }
                                        }
                                        $city->close();
                                        ?>
                                    </select>
                                    <div class="row">
                                        <form id="information-from" method="post" action="PaymentGate.php">
                                            <?php
                                            $address = "";
                                            if (isset($_SESSION[SESSION_EARLY_CUSTOMER__ADDRESS_DATA]) == true && $_SESSION[SESSION_EARLY_CUSTOMER__ADDRESS_DATA] != "") {
                                                $address = $_SESSION[SESSION_EARLY_CUSTOMER__ADDRESS_DATA];
                                            } else {
                                                $address = $customer->Address;
                                            }
                                            ?>
                                            <textarea id="caddress" name="caddress" class="address filled-block2"
                                                      required
                                                      placeholder="آدرس محل زندگی شما..."><?php echo $address; ?></textarea>
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right">
                                                <div class="block profile_block filled-block">
                                                    <div class="image"><img src="Template/Images/profile2.png"/>
                                                    </div>
                                                    <span><?php echo $customer->Name . ' ' . $customer->Family; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right">
                                                <div class="block post_block" id="post_block">
                                                    <div class="image"><img src="Template/Images/post.png"/></div>
                                                    <?php
                                                    $post_code = "";
                                                    if (isset($_SESSION[SESSION_EARLY_CUSTOMER__PostCode_DATA]) == true && $_SESSION[SESSION_EARLY_CUSTOMER__PostCode_DATA] != "") {
                                                        $post_code = $_SESSION[SESSION_EARLY_CUSTOMER__PostCode_DATA];
                                                    } else {
                                                        $post_code = $customer->PostCode;
                                                    }
                                                    ?>
                                                    <input type="text" required placeholder="کد پستی 10 رقمی..."
                                                           value="<?php echo $post_code; ?>" id="cpostcode"
                                                           maxlength="11"
                                                           name="cpostcode"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right">
                                                <div class="block email_block" id="email_block">
                                                    <div class="image"><img src="Template/Images/email2.png"/></div>
                                                    <input type="text" placeholder="آدرس ایمیل..." required

                                                           value="<?php echo $customer->Email; ?>" id="cemail"
                                                           name="cemail"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-right">
                                                <div class="block tell_block" id="tell_block">
                                                    <div class="image"><img src="Template/Images/tell2.png"/></div>
                                                    <?php
                                                    $phone = "";
                                                    if (isset($_SESSION[SESSION_EARLY_CUSTOMER__Phone_DATA]) == true && $_SESSION[SESSION_EARLY_CUSTOMER__Phone_DATA] != "") {
                                                        $phone = $_SESSION[SESSION_EARLY_CUSTOMER__Phone_DATA];
                                                    } else {
                                                        $phone = $customer->Phone;
                                                    }
                                                    ?>
                                                    <input type="text" placeholder="تلفن ثابت..." required
                                                           value="<?php echo $phone; ?>" id="cphone"
                                                           name="cphone"/>
                                                    <?php
                                                    $mobile = "";
                                                    if (isset($_SESSION[SESSION_EARLY_CUSTOMER__Mobile_DATA]) == true && $_SESSION[SESSION_EARLY_CUSTOMER__Mobile_DATA] != "") {
                                                        $mobile = $_SESSION[SESSION_EARLY_CUSTOMER__Mobile_DATA];
                                                    } else {
                                                        $mobile = $customer->Mobile;
                                                    }
                                                    ?>
                                                    <input type="text" placeholder="موبایل..." required
                                                           value="<?php echo $mobile; ?>"
                                                           id="cmobile" name="cmobile"/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php
                                //                                }

                                //                                else {
                                //                                    ?>
                                <!--                                    <input type="button" onclick="loginFirst()" href='#' class="btn-add-to-cart"-->
                                <!--                                           value="ابتدا وارد شوید"/>-->
                                <!--                                    --><?php
                                //                                }
                                ?>


                            </div>

                            <div class="FillOut">
                                <div class="title">
                                    <span>روش ارسال</span>
                                </div>

                                <?php
                                //                                if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                                //                                if (true) {
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
                                                var priceid = $(this).attr("id");
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
                                                    data: {update_mainprice: 1,
                                                    price_id: priceid
                                                    },
                                                    success: function (data) {
//                                                        alert(data);
                                                        $('#main_price').html(data);
                                                    }
                                                });
                                                $(".shippingmethod_tr").removeAttr('class', 'tr_back');
                                                $(this).attr('class', 'shippingmethod_tr tr_back');
                                                $('#pricewait').fadeOut(0);
                                                $('#shipping_method_id').attr('value', $('.shippingmethod_tr input:checked').val());
                                            }
                                        );
                                        $('.paymentmethod_tr').click(
                                            function () {
                                                $(".paymentmethod_tr").removeAttr('class', 'tr_back');
                                                $(this).attr('class', 'paymentmethod_tr tr_back');
                                                $('#payment_method_id').attr('value', $('.paymentmethod_tr input:checked').val());
                                            }
                                        );
                                        $('#service-form').change(function () {
                                            $('#pricewait').fadeIn(0);

                                            var ser = $('#service-form').serialize();
                                            if (!($('#usecoupon').prop('checked'))) {
                                                ser += "&usecoupon=0"
                                            }
//                                        alert($('#service-form').serialize());
                                            $.ajax({
                                                url: 'AjaxSearch/UpdateCartPrice.php',
                                                type: 'POST',
                                                data: ser,
//                                            data: $('#service-form').serialize(),
                                                success: function (data) {
                                                    $('#services-cost').html(data);
//                                                alert("haha");
// usecoupon=1&memo=&pay_price=80000&shipping_method_id=4&payment_method_id=1
                                                    //memo=&pay_price=79230&shipping_method_id=4&payment_method_id=1
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'AjaxSearch/UpdateCartPrice.php',
                                                        data: {update_mainprice: 1},
                                                        success: function (data) {
                                                            $('#main_price').html(data);
                                                            $('#pricewait').fadeOut(0);
                                                        }
                                                    });
                                                }
                                            });
//                                        $.ajax({
//                                            type: 'POST',
//                                            url: 'AjaxSearch/UpdateCartPrice.php',
//                                            data: {update_mainprice: 1},
//                                            success: function (data) {
//                                                $('#main_price').html(data);
//                                                $('#pricewait').fadeOut(0);
//                                            }
//                                        });
                                        });
                                    });
                                </script>
                                <form id="shippingmethod-form">
                                    <div class="body" id="shippingmethods" style="position:relative;">
                                        <div class="db-cover3" id="shippingwait">
                                            <img class="loading-gif3" src="Admin/Template/Images/gifs/loading.gif"/>
                                            <!--                                <span class="loading-title3">در حال پردازش...</span>-->
                                        </div>
                                        <?php
                                        if ($priceCounter > $settings->FreeShipping && $settings->FreeShipping != 0) {
                                            $extrashippingprice = 0;
                                            $shippingCost = 0;
                                            $shippingid = 0;
                                            ?>
                                            <table border="0">
                                                <tr class="tr_back">
                                                    <td>
                                                        <input checked id="" value="0" class="radio-custom"
                                                               name="shippingmethod"
                                                               type="radio">
                                                        <label for="" class="radio-custom-label"></label>
                                                    </td>
                                                    <td>
                                                        <img src="Template/Images/freedelivery.jpg"/>
                                                        <div class="shippingtype">ارسال رایگان</div>
                                                        <br/><br/>
                                                        <div class="shippingtype_comment">هزینه ارسال برای خرید های
                                                            بالای <?php echo number_format($settings->FreeShipping); ?>
                                                            تومان
                                                            رایگان
                                                            می
                                                            باشد! از خرید خود لذت ببرید.
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                        } else {
                                            require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/ShippingMethodDataSource.inc";
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
                                                        if (in_array($customer->City, $cities) != false) {
                                                            ?>
                                                            <tr class="shippingmethod_tr <?php
                                                            if ($i == 1) {
                                                                echo ' tr_back ';
                                                            }
                                                            ?>" id="<?php echo $sh->Price; ?>">
                                                                <td>
                                                                    <input <?php
                                                                    if ($i == 1) {
                                                                        echo ' checked  id = "first_sh_method" ';
                                                                        $extrashippingprice = $sh->Price;
                                                                        $_SESSION[SESSION_INT_SHIPPING_COST] += $sh->Price;
                                                                        $shippingid = $sh->ShippingMethodId;
                                                                    }
                                                                    ?> class="radio-custom" name="shippingmethod"
                                                                       type="radio"
                                                                       value="<?php echo $sh->ShippingMethodId; ?>">
                                                                    <label for=""
                                                                           class="radio-custom-label"></label>
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
                                                        ?>" id="<?php echo $sh->Price; ?>">
                                                            <td>
                                                                <input <?php
                                                                if ($i == 1) {
                                                                    echo ' checked  id = "first_sh_method" ';
                                                                    $extrashippingprice = $sh->Price;
                                                                    $_SESSION[SESSION_INT_SHIPPING_COST] += $sh->Price;
                                                                    $shippingid = $sh->ShippingMethodId;
                                                                }
                                                                ?> class="radio-custom" name="shippingmethod"
                                                                   type="radio"
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
                                                ?>
                                            </table>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </form>
                                <?php
                                //                                } else {
                                //                                ?>
                                <!--                                <input type="button" onclick="loginFirst()" href='#' class="btn-add-to-cart"-->
                                <!--                                       value="ابتدا وارد شوید"/>-->
                                <!--                                    --><?php
                                //                                }
                                ?>


                            </div>
                            <div class="FillOut">
                                <div class="title">
                                    <span>روش پرداخت</span>
                                </div>

                                <?php
                                //                                if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                                ?>
                                <div class="body">
                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/PaymentMethodDataSource.inc";
                                    $paymentmethod = new PaymentMethodDataSource();
                                    $paymentmethod->open();
                                    $pmethods = $paymentmethod->CFill();
                                    $paymentmethod->close();
                                    $i = 1;
                                    ?>
                                    <table border="0" id="paymentmethods-table">
                                        <?php
                                        foreach ($pmethods as $sh) {
                                            ?>
                                            <tr class="paymentmethod_tr <?php
                                            if ($i == 1) {
                                                echo ' tr_back ';
                                                $paymentid = $sh->PaymentMethodId;
                                            }
                                            ?>">
                                                <td>
                                                    <input <?php
                                                    if ($i == 1) {
                                                        echo ' checked ';
                                                    }
                                                    ?> id="" class="radio-custom"
                                                       value="<?php echo $sh->PaymentMethodId; ?>"
                                                       name="paymentmethod" type="radio"/>
                                                    <label for="" class="radio-custom-label"></label>
                                                </td>
                                                <td>
                                                    <div class="shippingtype"><?php echo $sh->Name;
                                                        if ($sh->PaymentMethodId == 3) {
                                                            echo " <span style='color:#ff5353; font-weight: bold;'>( پیشنهاد نمیشود )</span> ";
                                                        }
                                                        ?></div>

                                                    <br/><br/>
                                                    <div class="shippingtype_comment">
                                                        <?php
                                                        if ($sh->PaymentMethodId == 1) {
                                                            echo "پرداخت آنلاین از طریق درگاه بانکی، تنها کارت های عضو شتاب قادر به استفاده از درگاه بانکی می باشند.";
                                                        } elseif ($sh->PaymentMethodId == 2) {
                                                            echo "زمان تحویل کالا وجه را به پستچی پرداخت کنید.";
                                                        } elseif ($sh->PaymentMethodId == 3) {
                                                            echo "این نوع پرداخت از طریق واریز به حساب یا انتقال وجه کارت به کارت انجام میشود و شما باید تا 24 ساعت بعد از ثبت سفارش در پنل کاربری خود اطلاعات مربوط به رسید بانک را در قسمت 'ارسال فیش بانکی' وارد نمایید تا سفارش شما پیگیری شود، پس از ثبت سفارش با شما تماس گرفته می شود و اطلاعات لازم در اختیارتان قرار داده میشود.";
                                                        }

                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $i = 0;
                                        }
                                        ?>
                                    </table>
                                </div>
                                <?php
                                //                                } else {
                                //                                    ?>
                                <!--                                    <input type="button" onclick="loginFirst()" href='#' class="btn-add-to-cart"-->
                                <!--                                           value="ابتدا وارد شوید"/>-->
                                <!--                                    --><?php
                                //                                }
                                ?>


                            </div>
                            <form id="service-form" method="post" action="PaymentGate.php">
                            <div class="FillOut2">
                                <div class="title2">
                                    <span>خدمات اضافی</span>
                                </div>

                                <?php
                                //                                if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                                ?>

                                <div class="body">
                                    <?php

                                    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ServiceDataSource.inc';
                                    $service = new ServiceDataSource();
                                    $service->open();
                                    $services = $service->CFill();
                                    $service->close();

                                    foreach ($services as $s) {
                                        ?>
                                        <input type="hidden" name="service" value=" "/>
                                        <div>
                                            <input id="Service<?php echo $s->ServiceId; ?>" class="checkbox-custom"
                                                   name="checkbox[]" value="<?php echo $s->ServiceId; ?>"
                                                   type="checkbox">
                                            <label for="Service<?php echo $s->ServiceId; ?>"
                                                   class="checkbox-custom-label"><?php echo $s->Name; ?></label>
                                        </div>
                                        <?php
                                    }

                                    if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                                        $ucds = new UserCouponDataSource();
                                        $ucds->open();
                                        if ($ucds->SomeoneCouponsSome($customer->CustomerId) != 0) {
                                            ?>
                                            <div>
                                                <input id="usecoupon" value="1" class="checkbox-custom"
                                                       name="usecoupon"
                                                       type="checkbox">
                                                <label for="usecoupon" class="checkbox-custom-label">استفاده از
                                                    کپن</label>
                                            </div>
                                            <?php
                                        }
                                        $ucds->close();
                                    }


                                    //                                echo "hahah";

                                    ?>
                                </div>
                                <?php
                                //                                } else {
                                //                                    ?>
                                <!--                                    <input type="button" onclick="loginFirst()" href='#' class="btn-add-to-cart"-->
                                <!--                                           value="ابتدا وارد شوید"/>-->
                                <!--                                    --><?php
                                //                                }
                                ?>

                            </div>
                            <div class="FillOut3">
                                <div class="title3">
                                    <span>یادداشت</span>
                                </div>

                                <?php
                                //                                if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                                ?>
                                <div class="body">
                                    <?php
                                    $note = "";
                                    if (isset($_SESSION[SESSION_EARLY_CUSTOMER__NOTE_DATA]) == true && $_SESSION[SESSION_EARLY_CUSTOMER__NOTE_DATA] != "") {
                                        $note = $_SESSION[SESSION_EARLY_CUSTOMER__NOTE_DATA];
                                    }
                                    ?>
                                    <textarea id="memo" name="memo" class="memo"
                                              placeholder="اگر توضیحی درباره سفارش دارید اینجا بنویسید..."><?php echo $note; ?></textarea>
                                </div>
                                <?php
                                //                                } else {
                                //                                    ?>
                                <!--                                    <input type="button" onclick="loginFirst()" href='#' class="btn-add-to-cart"-->
                                <!--                                           value="ابتدا وارد شوید"/>-->
                                <!--                                    --><?php
                                //                                }
                                ?>


                            </div>
                            <?php
                            if ($purchasebaskets != NULL) {
                                ?>


                                <?php
//                                if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                                ?>

                                <div class="row">
                                    <table style="border: 0; max-width: 400px; width: 90%; float: left; position: relative; left: 15px;">
                                        <tr>
                                            <td>جمع کل خرید شما :</td>
                                            <td id="basket_price">
                                                <div class="db-cover4" id="pricewait">
                                                    <span class="loading-title4">در حال محاسبه...</span>
                                                    <img class="loading-gif4"
                                                         src="Admin/Template/Images/gifs/loading.gif"/>
                                                </div><?php
                                                //                                                    if ($customer->Estate == "" || $customer->Estate == 0 || $customer->City == "" || $customer->City == 0) {
                                                //                                                        ?>
                                                <!--                                                        <div class="db-cover4" style="display: block;">-->
                                                <!--                                                            <span class="loading-title4">لطفا اطلاعات حساب خود را تکمیل کنید</span>-->
                                                <!--                                                            <img class="loading-gif4"-->
                                                <!--                                                                 src="Admin/Template/Images/gifs/loading.gif"/>-->
                                                <!--                                                        </div>-->
                                                <!--                                                        --><?php
                                                //                                                    }
                                                ?><?php echo number_format($priceCounter) . " تومان "; ?></td>
                                        </tr>
                                        <tr>
                                            <td>هزینه حمل و نقل :</td>
                                            <td id="shipping-cost">
                                                <?php
                                                if ($priceCounter > $settings->FreeShipping && $settings->FreeShipping != 0) {
                                                    echo "رایگان!";
                                                } else {
                                                    echo number_format($shippingCost + $extrashippingprice) . " تومان ";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr id="services-cost"></tr>
                                        <tr id="prices" name="prices"></tr>
                                        <tr class="last-price">
                                            <td class="st1">مبلغ قابل پرداخت :</td>
                                            <td class="st1"
                                                <?php $_SESSION[SESSION_INT_PAY_PRICE] = $priceCounter + $shippingCost + $extrashippingprice; ?>
                                                id="main_price"><?php echo number_format($priceCounter + $shippingCost + $extrashippingprice) . " تومان "; ?>
                                                <input type="hidden" id="pay_price" name="pay_price"
                                                       value="<?php echo $priceCounter + $shippingCost + $extrashippingprice; ?>"/>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                    ?>
                                </div>
                                <?php
//                                } else {
//                                    ?>
                                <!--                                    <input type="button" onclick="loginFirst()" href='#' class="btn-add-to-cart"-->
                                <!--                                           value="ابتدا وارد شوید"/>-->
                                <!--                                    --><?php
//                                }
                                ?>


                                <div class="continue-sh-btn">
                                    <a href="index.php">
                                        بازگشت به صفحه اصلی
                                    </a>
                                </div>


                                <?php
                                if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                                    ?>


                                    <div class="pay-btn" id="pay-btn">
                                        <input type="hidden" id="shipping_method_id" name="shipping_method_id"
                                               value="<?php echo $shippingid; ?>"/>
                                        <input type="hidden" id="payment_method_id" name="payment_method_id"
                                               value="<?php echo $paymentid; ?>"/>
                                        <input type="button" value="ثبت سفارش" <?php
                                        //                                        if ($customer->Estate == "" || $customer->Estate == 0 || $ColorQuantityCheck == 0) {
                                        if ($ColorQuantityCheck == 0) {
                                            echo ' disabled ';
                                        }
                                        ?> id="btn-done"/>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="pay-btn" id="pay-btn">
                                        <input type="button" onclick="loginFirst()" href='#' class="btn-add-to-cart"
                                               value="ابتدا وارد شوید"/>
                                    </div>
                                    <?php
                                }
                                ?>


                                </form>
                                <?php
                            }
                        } else {
                            echo "<span style='font-size: 11pt;'>سبد خرید شما خالی است !</span>";
                        }
                        ?>
                    </div>
                    <?php
                }
                //        else {
                //            echo "<span style='font-size: 11pt;'>جهت خرید باید وارد حساب خود شوید یا حساب جدیدی بسازید.</span>";
                //        }
                ?>
            </div>
            <script>
                $(document).ready(function () {
                    $("#btn-done").click(function () {
                        if (!$("#cpostcode").val()) {
                            $("#post_block").addClass("fill-alert");
                        }
                        if (!$("#caddress").val()) {
                            $("#caddress").addClass("fill-alert2");
                        }
                        if (!$("#cphone").val() || !$("#cmobile").val()) {
                            $("#tell_block").addClass("fill-alert");
                        }
                        if (!$("#cemail").val()) {
                            $("#email_block").addClass("fill-alert");
                        }
                        if (!$("#caddress").val() || !$("#cmobile").val() || !$("#cpostcode").val() || !$("#cphone").val() || !$("#cemail").val() || $("#ccity").val()==0) {
                            $(".body .note").fadeIn(0);
                            $('html,body').animate({
                                    scrollTop: $("#ur-info").offset().top
                                },
                                'slow');
                        } else {
                            window.location.href = "PaymentGate.php?" + $('#information-from').serialize() + '&' + $('#service-form').serialize();
                        }
                    });


                    $("#caddress").focusout(function () {
                        var address = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: 'Internal Inserting/UpdateAddress.php',
                            data: {address: address},
                            success: function (data) {
                            }
                        });
                    });

                    $("#cmobile").focusout(function () {
                        var mobile = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: 'Internal Inserting/UpdateMobile.php',
                            data: {mobile: mobile},
                            success: function (data) {
                            }
                        });
                    });

                    $("#cphone").focusout(function () {
                        var phone = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: 'Internal Inserting/UpdatePhone.php',
                            data: {phone: phone},
                            success: function (data) {
                            }
                        });
                    });

                    $("#cpostcode").focusout(function () {
                        var cpostcode = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: 'Internal Inserting/UpdatePostCode.php',
                            data: {post_code: cpostcode},
                            success: function (data) {
                            }
                        });
                    });

                    $("#memo").focusout(function () {
                        var note = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: 'Internal Inserting/UpdateNote.php',
                            data: {note: note},
                            success: function (data) {
                            }
                        });
                    });


                    $("#cestate").change(function () {
                        $("#first_sh_method").prop("checked", true)
                        $('#ccity').attr('disabled', '');
                        var province = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: 'AjaxSearch/CUpdateCities.php',
                            data: {province: province},
                            success: function (data) {
                                $('#ccity').html(data);
                                $('#ccity').removeAttr('disabled', '');
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: 'Internal Inserting/UpdateCLocation.php',
                            data: {
                                id: <?php echo $customer->CustomerId; ?>,
                                estate: $('#cestate').val(),
                                city: 0
                            },
                            success: function () {

                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: 'AjaxSearch/UpdateCartPrice.php',
                            data: {update_basketprice: 1},
                            success: function (data) {
                                $('#basket_price').html(data);
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: 'AjaxSearch/UpdateCartPrice.php',
                            data: {shipping2: 1, extraprice: <?php echo $extrashippingprice; ?>},
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
                    });

                    $('#ccity').change(function () {
                        $('#shippingwait').fadeIn(0);
                        if ($('#ccity').val() != 0) {
                            $('#btn-done').removeAttr("disabled");
                        } else {
                            $('#btn-done').attr("disabled", "");
                        }
                        $("#first_sh_method").prop("checked", true);
                        $.ajax({
                            type: 'POST',
                            url: 'Internal Inserting/UpdateCLocation.php',
                            data: {
                                id: <?php echo $customer->CustomerId; ?>,
                                estate: $('#cestate').val(),
                                city: $('#ccity').val()
                            },
                            success: function (data) {

                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: 'AjaxSearch/UpdateCartPrice.php',
                            data: {update_basketprice: 1},
                            success: function (data) {
                                $('#basket_price').html(data);
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: 'AjaxSearch/UpdateCartPrice.php',
                            data: {shipping2: 1, extraprice: <?php echo $extrashippingprice; ?>},
                            success: function (data) {
                                $('#shipping-cost').html(data);
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: 'AjaxSearch/UpdateCartPrice.php',
                            data: {refresh_shippings: 1},
                            success: function (data) {
                                $('#shippingmethods').html(data);
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
                    });

                });
            </script>
            <script>
                $(document).ready(function () {
                    $(function () {
                        var Accordion = function (el, multiple) {
                            this.el = el || {};
                            this.multiple = multiple || false;

                            // Variables privadas
                            var links = this.el.find('.link');
                            // Evento
                            links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
                        }

                        Accordion.prototype.dropdown = function (e) {
                            var $el = e.data.el;
                            $this = $(this),
                                $next = $this.next();

                            $next.stop().slideToggle();
                            $this.parent().toggleClass('open');

                            if (!e.data.multiple) {
                                $el.find('.submenu').not($next).stop().slideUp().parent().removeClass('open');
                            }
                            ;
                        }

                        var accordion = new Accordion($('#accordion'), false);
                        var accordion = new Accordion($('#accordion2'), true);

//                $('.SideBar').css({'min-height': ($(document).innerHeight()) + 'px'});
                    });
                });
            </script>
        </div>
    </div>
<?php
include_once 'Template/bottom.php';
