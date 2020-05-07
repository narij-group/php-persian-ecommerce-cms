<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";


//echo "<br>" . date("Y/m/d") . "<br>";
//echo "<br>" . time() . "<br>";


//ob_start();


//if (!isset($_COOKIE[COOKIE_VIEWER_LAST_IP])) {
//    setcookie(COOKIE_VIEWER_LAST_IP, $ip, time() + (10 * 365 * 24 * 60 * 60));
//}


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


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fa">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo $settings->ILogo; ?>"/>
    <?php


    //TODO ERRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
    if (!isset($_COOKIE [COOKIE_CUSTOMER_ID])) {
        setcookie(COOKIE_CUSTOMER_ID, "NO", time() + 84600);
    } elseif (isset($_COOKIE [COOKIE_CUSTOMER_LOGGED_IN]) == null) {
        setcookie(COOKIE_CUSTOMER_ID, 0, time() + 84600);
    }


    if (isset($_COOKIE[COOKIE_CUSTOMER_ID])) {
//        $_SESSION[SESSION_1_0_IS_QUANTITY_RESTORED] = "NO";
        if (isset($_SESSION[SESSION_1_0_IS_PAYING_CANCELED]) && $_SESSION[SESSION_1_0_IS_PAYING_CANCELED] == 1 && basename($_SERVER['PHP_SELF']) != "VerifyPayment.php") {
            if (isset($_SESSION[SESSION_STRING_CURRENT_AUTHORITY]) && $_SESSION[SESSION_STRING_CURRENT_AUTHORITY] != "") {
                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
                $fp = new FactorProductDataSource();
                $fp->open();
//                $fp->Authority = $_SESSION[SESSION_STRING_CURRENT_AUTHORITY];
                $fps = $fp->FindFactorProductsOnAuthority($_SESSION[SESSION_STRING_CURRENT_AUTHORITY]);
                foreach ($fps as $f) {
                    $fp->UpdatePaymentStatus($f->FactorProductId, 3);
                }
                $fp->close();
            }
            require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
            require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';

            $purchasebasket = new PurchaseBasketDataSource();
            $purchasebasket->open();
            $purchasebasket->Customer = $_COOKIE[COOKIE_CUSTOMER_ID];
            $purchasebaskets = $purchasebasket->FindSomeonePurchaseBasket($_COOKIE[COOKIE_CUSTOMER_ID]);
            $purchasebasket->close();

            foreach ($purchasebaskets as $c) {
                $pcds = new ProductColorDataSource();
                $pcds->open();

                $productcolor = new ProductColor();
                $productcolor3 = new ProductColor();
                $productcolor->ProductColorId = $c->Color;
                $productcolor2 = $pcds->FindOneProductColorBasedOnId($c->Color);
                $productcolor3->ProductColorId = $productcolor2->ProductColorId;
                $productcolor3->Quantity = $productcolor2->Quantity + $c->Count;
                $pcds->UpdateQuantity($productcolor3);

                $pcds->close();

            }

            setcookie(COOKIE_QUANTITY_RESTORED, "YES", time() + 1800);
            $_SESSION[SESSION_1_0_IS_QUANTITY_RESTORED] = "YES";

        }
        $_SESSION[SESSION_1_0_IS_PAYING_CANCELED] = 0;
        $_SESSION[SESSION_STRING_CURRENT_AUTHORITY] = "";
    }


    ?>

    <link href="Template/Styles/bootstrap.css" rel="stylesheet"/>
    <link href="Template/Styles/owl.carousel.css" rel="stylesheet"/>
    <link href="Template/Styles/owl.theme.css" rel="stylesheet"/>
    <link href="Template/Styles/drawer.css" rel="stylesheet"/>
    <link href="Template/Styles/font-awesome.css" rel="stylesheet"/>
    <!-------------------------<3 <3 <3----------------------------------------->
    <script src="Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
    <script src="Template/Scripts/bootstrap.js" type="text/javascript"></script>
    <script src="Template/Scripts/iscroll.js" type="text/javascript"></script>
    <script src="Template/Scripts/drawer.js" type="text/javascript"></script>
    <script src="Template/Scripts/jquery.unveil.js" type="text/javascript"></script>
    <script src="Template/Scripts/jquery.pageup.js"></script>
    <!------------------------------------------------------------------->
    <script src="Template/Scripts/jssor.slider-22.1.8.min.js" type="text/javascript"></script>
    <link href="Template/Styles/style_1.css" rel="stylesheet" type="text/css"/>

    <!--    TODO JAVAD-->
    <script>
        function addComma(str) {
            var objRegex = new RegExp('(-?[0-9]+)([0-9]{3})');
            while (objRegex.test(str)) {
                str = str.replace(objRegex, '$1,$2');
            }
            return str;
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("img").unveil();

            $("#Go-Up,#Go-Up2").pageup({
                offset: 100,
                fadeDelay: 500,
                scrollDuration: 400
            });

            $(".product-view-btn").click(function () {
                $("#purchase-box", $(this).parent().parent()).fadeIn(500);
            });

            $(".btn-cancle").click(function () {
                $("#purchase-box", $(this).parent().parent().parent()).fadeOut(250);
            });

            $(".buy").click(function () {
                $("#purchase-box2", $(this).parent().parent()).fadeIn(500);
            });

            $(".btn-cancle").click(function () {
                $("#purchase-box2", $(this).parent().parent().parent()).fadeOut(250);
            });

            $(".btn-ok").click(function () {

                <?php
                //                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                ?>
                var idname = $("#purchase-box", $(this).parent().parent().parent());
                var idname2 = $("#purchase-box2", $(this).parent().parent().parent());
                var productid = $(this).attr("id");
//                alert(productid );
                var val = $("#count-box #txtcount", $(this).parent().parent()).val()
                var realval = parseFloat($("#price-box #real_price", $(this).parent().parent()).val());
//                alert(realval);
                $.ajax({
                    type: 'post',
                    url: 'ShoppingCart_Ajax_Inline.php',
                    data: {
                        item_image: "",
                        item_name: "",
                        item_price: realval,
                        item_latinname: "",
                        item_id: productid,
                        item_guarantee: 0,
                        item_count: val,
                        item_color: 0
                    },
                    success: function (response) {
                        $(idname).fadeOut(250);
                        $(idname2).fadeOut(250);

                        var str = response;
                        var res = str.split("-");

                        document.getElementById("total_items").value = res[1];
//                        alert(response);
                        document.getElementById("total_items2").value = res[1];

                        if (res[0] == "s") {
                            $('#cart-success-msg').fadeIn(200);
                            setTimeout(function () {
                                $('#cart-success-msg').fadeOut(500);
                            }, 3000);
                        } else if (res[0] == "w") {
                            $('#cart-warning-cart-msg').fadeIn(200);
                            setTimeout(function () {
                                $('#cart-warning-cart-msg').fadeOut(500);
                            }, 3000);
                        }
                    },
                });


                <?php
                //                } else {
                //                echo 'loginFirst()';
                //            }
                ?>
            });


            $(".btn-up").click(function () {
                var val = $("#txtcount", $(this).parent()).val();
                var max = $("#price-box #max_count", $(this).parent().parent()).val();
                var realval = $("#price-box #real_price", $(this).parent().parent()).val();
                realval = realval.replace(/,/g, '');

                if (val < max) {
                    val++;
                }

                var totalval = addComma((parseFloat(realval) * parseInt(val)).toString());
                $("#txtcount", $(this).parent()).prop('value', val);
                $("#price-box #total_price", $(this).parent().parent()).prop('value', totalval);

            });

            $(".btn-down").click(function () {
                var val = $("#txtcount", $(this).parent()).val();
                var realval = $("#price-box #real_price", $(this).parent().parent()).val();
                realval = realval.replace(/,/g, '');
                if (val > 1) {
                    val--;
                    var totalval = addComma((parseFloat(realval) * parseInt(val)).toString());
                    $("#txtcount", $(this).parent()).prop('value', val);
                    $("#price-box #total_price", $(this).parent().parent()).prop('value', totalval);
                }
            });

        });
    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            $("a:not([href^='#'])").click(function () {
                if ($(this).attr('href') && $(this).attr("id") != "unPreload") {
                    $("#").show()
                }preloader
            });
        });

        //--------------------- Menu ------------------------------
        jQuery(document).ready(function ($) {
            $("#mainNav").accordion();
        });

        /* accordion menu plugin*/
        ;(function ($, window, document, undefined) {
            var pluginName = "accordion";
            var defaults = {
                speed: 200,
                showDelay: 0,
                hideDelay: 0,
                singleOpen: true,
                clickEffect: true,
                indicator: 'submenu-indicator-minus',
                subMenu: 'submenu',
                event: 'click' // click, touchstart
            };

            function Plugin(element, options) {
                this.element = element;
                this.settings = $.extend({}, defaults, options);
                this._defaults = defaults;
                this._name = pluginName;
                this.init();
            }

            $.extend(Plugin.prototype, {
                init: function () {
                    this.openSubmenu();
                    this.submenuIndicators();
                    if (defaults.clickEffect) {
                        this.addClickEffect();
                    }
                },
                openSubmenu: function () {
                    $(this.element).children("ul").find("li").bind(defaults.event, function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                        var $subMenus = $(this).children("." + defaults.subMenu);
                        var $allSubMenus = $(this).find("." + defaults.subMenu);
                        if ($subMenus.length > 0) {
                            if ($subMenus.css("display") == "none") {
                                $subMenus.slideDown(defaults.speed).siblings("a").addClass(defaults.indicator);
                                if (defaults.singleOpen) {
                                    $(this).siblings().find("." + defaults.subMenu).slideUp(defaults.speed)
                                        .end().find("a").removeClass(defaults.indicator);
                                }
                                return false;
                            } else {
                                $(this).find("." + defaults.subMenu).delay(defaults.hideDelay).slideUp(defaults.speed);
                            }
                            if ($allSubMenus.siblings("a").hasClass(defaults.indicator)) {
                                $allSubMenus.siblings("a").removeClass(defaults.indicator);
                            }
                        }
                        window.location.href = $(this).children("a").attr("href");
                    });
                },
                submenuIndicators: function () {
                    if ($(this.element).find("." + defaults.subMenu).length > 0) {
                        $(this.element).find("." + defaults.subMenu).siblings("a").append("<i class='fa fa-angle-right submenu-indicator'></i>");
                    }
                },
//                addClickEffect: function() {
//                    var ink, d, x, y;
//                    $(this.element).find("a").bind("click touchstart", function(e) {
//                        $(".ink").remove();
//                        if ($(this).children(".ink").length === 0) {
//                            $(this).prepend("<span class='ink'></span>");
//                        }
//                        ink = $(this).find(".ink");
//                        ink.removeClass("animate-ink");
//                        if (!ink.height() && !ink.width()) {
//                            d = Math.max($(this).outerWidth(), $(this).outerHeight());
//                            ink.css({
//                                height: d,
//                                width: d
//                            });
//                        }
//                        x = e.pageX - $(this).offset().left - ink.width() / 2;
//                        y = e.pageY - $(this).offset().top - ink.height() / 2;
//                        ink.css({
//                            top: y + 'px',
//                            left: x + 'px'
//                        }).addClass("animate-ink");
//                    });
//                }
            });
            $.fn[pluginName] = function (options) {
                this.each(function () {
                    if (!$.data(this, "plugin_" + pluginName)) {
                        $.data(this, "plugin_" + pluginName, new Plugin(this, options));
                    }
                });
                return this;
            };
        })(jQuery, window, document);
    </script>
    <!--  END TODO JaVAD-->

    <script type="text/javascript">
        jssor_1_slider_init = function () {
            var jssor_1_options = {
                $AutoPlay: true,
                $BulletNavigatorOptions: {
                    $Class: $JssorBulletNavigator$
                },
                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,
                    $Cols: 5,
                    $Align: 200
                }
            };
            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var parentWidth = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    jssor_1_slider.$ScaleWidth(parentWidth - 30);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }

            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        };
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            <?php
            if(isset($_GET['sent'])){
            ?>
            $('#contact-success-msg').fadeIn(250);
            setInterval(function () {
                $('#contact-success-msg').fadeOut(250);
            }, 7000);
            <?php
            }
            ?>
            <?php
            if(isset($_GET['key']) && trim($_GET['key']) != ""){
            ?>
            $('#fpass2').fadeIn(250);
            $("#modalback").fadeIn(1000);
            <?php
            }
            ?>
            $("#search_box").focusout(function () {
                $("#searchres").fadeOut();
            });
            $("#newpassrepeat").focusout(function () {
                if ($('#newpass').val() != $('#newpassrepeat').val()) {
                    $('#error-msg1').fadeIn(250);
                    setInterval(function () {
                        $('#error-msg1').fadeOut(250);
                    }, 7000);
                }
            });
            $("#newpassrepeat").keyup(function () {
                if ($('#newpass').val() != $('#newpassrepeat').val()) {
                    $('#pw-status').html('<img src="Template/Images/Plugins/unavailable.png" alt=""/>');
                    $('#btn-forgetpass2').attr('disabled', '');

                } else {
                    $('#pw-status').html('<img src="Template/Images/Plugins/available.png" alt=""/>');
                    $('#btn-forgetpass2').removeAttr('disabled');
                }
            });
            $("#search_box").focusin(function () {
                $("#searchres").fadeIn();
            });
            $("#search_box").keyup(function () {
                var search_string = $("#search_box").val();
                if (search_string == '') {
                    $("#searchres").html('');
                } else {
                    postdata = {'string': search_string}
                    $.post("check.php", postdata, function (data) {
                        //alert("sdsadasdas");
                        $("#searchres").html(data);
                    });
                }
            });


            $('#username2').on('input', function () {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/Availability.php',
                    data: {
                        username2: $('#username2').val()
                    },
                    success: function (data) {
                        $('#username-status').html(data);
                    }

                });
            });
            $('#email').on('input', function () {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/Availability.php',
                    data: {
                        email: $('#email').val()
                    },
                    success: function (data) {
                        $('#email-status').html(data);
                    }
                });
            });
            $('#nationalitycode').on('input', function () {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/Availability.php',
                    data: {
                        ncode: $('#nationalitycode').val()
                    },
                    success: function (data) {
                        $('#ncode-status').html(data);
                    }
                });
            });
            $("#regil").click(function () {
                $("#regi").fadeIn(500);
                $("#regi2").fadeIn(500);
                $("#modalback").fadeIn(250);
            });
            $("#regil2").click(function () {
                $("#regi").fadeIn(500);
                $("#regi2").fadeIn(500);
                $("#modalback").fadeIn(250);
                $("#accbox").fadeOut(250);
                $("#accback").fadeOut(250);
            });

            $("#regil3").click(function () {
                $("#regi").fadeIn(500);
                $("#regi2").fadeIn(500);
                $("#modalback").fadeIn(250);
            });

            $("#editcustomer").click(function () {
                $("#regi").fadeIn(500);
                $("#regi2").fadeIn(500);
                $("#modalback").fadeIn(250);
            });
            $("#logil").click(function () {
                $("#logi").fadeIn(500);
                $(".Forget-Pass").fadeIn(500);
                $("#modalback").fadeIn(250);
            });
            $("#logil2").click(function () {
                $("#logi").fadeIn(500);
                $(".Forget-Pass").fadeIn(500);
                $("#modalback").fadeIn(250);
                $("#accbox").fadeOut(250);
                $("#accback").fadeOut(250);
            });

            $("#logil3").click(function () {
                $("#logi").fadeIn(500);
                $(".Forget-Pass").fadeIn(500);
                $("#modalback").fadeIn(250);
            });

            $("#forget-pass").click(function () {
                $("#fpass").fadeIn(500);
                $(".Forget-Pass").fadeOut(250);
                $("#logi").fadeOut(250);
                $("#modalback").fadeIn(250);
            });

            $("#register-btn5").click(function () {
                $("#regi").fadeIn(500);
                $("#logi").fadeOut(250);
                $("#modalback").fadeIn(250);
                $('html,body').animate({
                        scrollTop: $("#regi").offset().top
                    },
                    'slow');
            });

            $("#modalback").click(function () {
                $("#regi").fadeOut(250);
                $("#fpass").fadeOut(250);
                $("#fpass2").fadeOut(250);
                $("#logi").fadeOut(250);
                $("#regi2").fadeOut(250);
                $("#receipt").fadeOut(250);
                $("#modalback").fadeOut(500);
            });
            $("#estate").change(function () {
                var province = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/UpdateCities.php',
                    data: {province: province},
                    success: function (data) {
                        $('#city').html(data);
                    }
                });
            });
            $("#btn-forgetpass").click(function () {
                $("#btn-forgetpass").attr('value', '');
                $("#btn-forgetpass").attr('disabled', '');
                $("#fpassloader").fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: 'Internal Inserting/Recovery.php',
                    data: {email2: $('#email2').val()},
                    success: function (res) {
                        $("#fpass").fadeOut(250);
                        $("#modalback").fadeOut(500);
                        $("#recovery-success-msg").fadeIn(250);
//                        $("#recovery-success-msg").html(data);
                        setTimeout(function () {
                            $("#recovery-success-msg").fadeOut(250);
                        }, 5000);
                        $("#btn-forgetpass").attr('value', 'ثبت');
                        $("#btn-forgetpass").removeAttr('disabled');
                        $("#fpassloader").fadeOut(100);
                    }
                });
            });

            $("#btn-forgetpass2").click(function () {
                $("#btn-forgetpass2").attr('value', '');
                $("#btn-forgetpass2").attr('disabled', '');
                $("#fpass2loader").fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: 'Internal Inserting/RecoveryPass.php',
                    data: $('#recoverypass-form').serialize(),
                    success: function (data) {
                        $("#fpass2").fadeOut(250);
                        $("#rpass").html(data);
                        $("#modalback").fadeOut(500);
                        $("#btn-forgetpass2").attr('value', 'تغییر رمزعبور');
                        $("#btn-forgetpass2").removeAttr('disabled');
                        $("#fpass2loader").fadeOut(100);
                    }
                });
            });

            $("#register-button").click(function () {
                //alert("hi");
//                $("#register-button").attr('value', '');
//                $("#registerloader").fadeIn(100);
            });


            $("#ks-register-form").submit(function (e) {
                //alert("hi2");
                e.preventDefault();
                var msg = "";
                var email = $("#email").val();
                if (email.search('@') <= 0) {
                    msg += "ایمیل معتبر نمی باشد";
                    msg += "<br>";
                }
//                var username2 = $("#username2").val();
                var password = $("#password", this).val();
                if (password.length < 8) {
                    msg += "رمز عبور باید حداقل 8 کاراکتر باشد";
                    msg += "<br>";
                }
                var repeatpass = $("#repeatpass").val();
                if (password != repeatpass) {
                    msg += "رمز عبور و تکرار آن باید یکسان باشند";
                    msg += "<br>";
                }
                var nationalitycode = $("#nationalitycode").val();
                if (nationalitycode.length < 10) {
                    msg += "کد ملی باید 10 کاراکتر باشد";
                    msg += "<br>";
                }
//                var mobile = $("#mobile").val();
//                var phone = $("#phone").val();
                if (msg != "") {
                    $("#ks-report").html(msg);
                    return;
                }
                $("#register-button").attr('value', 'لطفا صبر کنید');
                $("#registerloader").fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: 'InsertCustomer.php',
                    data: $('#ks-register-form').serialize(),
                    success: function (data) {
                        $("#registerloader").fadeOut(100);
                        $("#ks-report").html("ثبت نام با موفقیت انجام شد");
                        $("#register-button").prop("disabled", "disabled");
                        $("#register-button").attr('value', 'ثبت نام با موفقیت انجام شد.');

                        setTimeout(function () {
                            window.location.href = $("#link").val();
                        }, 1000);

                    }
                });
            });


            $("#ks-edit-form").submit(function (e) {
                //alert("hi2");
                e.preventDefault();
                var msg = "";
                var email = $("#email").val();
                if (email.search('@') <= 0) {
                    msg += "ایمیل معتبر نمی باشد";
                    msg += "<br>";
                }
                var username2 = $("#username2").val();
                var password = $("#password", this).val();
                if (password.length < 8) {
                    msg += "رمز عبور باید حداقل 8 کاراکتر باشد";
                    msg += "<br>";
                }
                var repeatpass = $("#repeatpass").val();
                if (password != repeatpass) {
                    msg += "رمز عبور و تکرار آن باید یکسان باشند";
                    msg += "<br>";
                }
                var nationalitycode = $("#nationalitycode").val();
                if (nationalitycode.length < 10) {
                    msg += "کد ملی باید 10 کاراکتر باشد";
                    msg += "<br>";
                }
                var mobile = $("#mobile").val();
                var phone = $("#phone").val();
                if (msg !== "") {
                    $("#ks-report").html(msg);
                    return;
                }
                $("#editregisterbutton").attr('value', 'لطفا صبر کنید');
                $("#editregisterloader").fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: 'Internal Inserting/UpdateCustomer.php',
                    data: $('#ks-edit-form').serialize(),
                    success: function (data) {
                        $("#editregisterloader").fadeOut(100);
                        $("#ks-report").html("ویرایش با موفقیت انجام شد");
                        $("#editregisterbutton").prop("disabled", "disabled");
                        $("#editregisterbutton").attr('value', 'ویرایش با موفقیت انجام شد.');

                        setTimeout(function () {
                            window.location.href = $("#link").val();
                        }, 1000);

                    }
                });
            });


            $("#editregisterbutton").click(function () {
//                $("#editregisterbutton").attr('value', '');
//                $("#editregisterloader").fadeIn(100);
            });

            $("#loginbutton").click(function () {
                $("#loginbutton").attr('value', '');
                $("#loginloader").fadeIn(100);
            });

            $("#receiptbutton").click(function () {
                $("#receiptbutton").attr('value', '');
                $("#receiptloader").fadeIn(100);
            });

            $("#usermobile").click(function () {
                $("#accbox").fadeIn(500);
                $("#accback").fadeIn(250);
            });

            $("#accback").click(function () {
                $("#accbox").fadeOut(250);
                $("#accback").fadeOut(250);
            });

        });

        function fillme(name) {
            $("#search_box").val(name);
            $("#searchres").html('');
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                type: 'post',
                url: 'ShoppingCart_Ajax.php',
                data: {
                    total_cart_items: "totalitems"
                },
                success: function (response) {
                    document.getElementById("total_items").value = response;
                    document.getElementById("total_items2").value = response;
                }
            });
            $.ajax({
                type: 'post',
                url: 'ShoppingCart_Ajax.php',
                data: {
                    price: "totalitems"
                },
                success: function (response) {
                    document.getElementsByClassName("price").value = response;
                }
            });
        });

        function cart(id) {
            var ele = document.getElementById(id);
            var image = document.getElementById("Image").value;
            var name = document.getElementById("Name").value;
            var price = document.getElementById("Price").value;
            var latinname = document.getElementById("LatinName").value;
            var productid = document.getElementById("ProductId").value;
            var guarantee = document.getElementById("Guarantee").value;
            var color = $(".Color:checked").val();
            $.ajax({
                type: 'post',
                url: 'ShoppingCart_Ajax_Inline.php',
                data: {
                    item_image: image,
                    item_name: name,
                    item_price: price,
                    item_latinname: latinname,
                    item_id: productid,
                    item_guarantee: guarantee,
                    item_color: color
                },
                success: function (response) {
                    document.getElementById("total_items").value = response;
                    document.getElementById("total_items2").value = response;

                    var str = response;
                    var res = str.split("-");

                    document.getElementById("total_items").value = res[1];
//                        alert(response);
                    document.getElementById("total_items2").value = res[1];

                    if (res[0] == "s") {
//                        $('#cart-success-msg').fadeIn(200);
//                        setTimeout(function () {
//                            $('#cart-success-msg').fadeOut(500);
//                        }, 3000);
                        $("#modal_back").fadeIn(250);
                        $('#purchase_success_alert').fadeIn(200);
                    } else if (res[0] == "w") {
//                        $('#cart-warning-cart-msg').fadeIn(200);
//                        setTimeout(function () {
//                            $('#cart-warning-cart-msg').fadeOut(500);
//                        }, 3000);
                        $("#modal_back").fadeIn(250);
                        $('#purchase_warning_alert').fadeIn(200);
                    }


                },
            });

        }

        function btn_continue() {
            $("#modal_back").fadeOut(250);
            $('#purchase_success_alert').fadeOut(200);
            $('#purchase_warning_alert').fadeOut(200);
        }

        function loginFirst() {
            var myElement = document.querySelector("#logi");
            var myElement2 = document.querySelector("#modalback");
            myElement.style.display = "block";
            myElement2.style.display = "block";
        }

        function show_cart() {
            $.ajax({
                type: 'post',
                url: 'ShoppingCart_Ajax.php',
                data: {
                    showcart: "cart"
                },
                success: function (response) {

                }
            });
        }

        function ErrorMessegeLP() {
            var myElement = document.querySelector("#logi");
            var myElement2 = document.querySelector("#modalback");
            var myElement3 = document.querySelector("#error-msg");
            myElement.style.display = "block";
            myElement2.style.display = "block";
            myElement3.style.display = "block";
        }

        function ErrorMessegeLU() {
            var myElement = document.querySelector("#logi");
            var myElement2 = document.querySelector("#modalback");
            var myElement3 = document.querySelector("#error-msg");
            myElement.style.display = "block";
            myElement2.style.display = "block";
            myElement3.style.display = "block";
        }

        setTimeout(function () {
            var myElement1 = document.querySelector("#error-msg");
            var myElement2 = document.querySelector("#error-msg1");
            var myElement3 = document.querySelector("#error-msg2");
            var myElement4 = document.querySelector("#error-msg3");
            var myElement = document.querySelector("#rsuccess-msg");
            var myElement5 = document.querySelector("#rsuccess-msg2");
            var myElement6 = document.querySelector("#rsuccess-msg3");
            var myElement10 = document.querySelector("#contact-success-msg");
            myElement1.style.transition = "opacity 1s";
            myElement1.style.opacity = 0;
            myElement.style.transition = "opacity 1s";
            myElement.style.opacity = 0;
            myElement4.style.transition = "opacity 1s";
            myElement10.style.opacity = 0;
            myElement10.style.transition = "opacity 1s";
            myElement4.style.opacity = 0;
            myElement5.style.transition = "opacity 1s";
            myElement5.style.opacity = 0;
            myElement6.style.transition = "opacity 1s";
            myElement6.style.opacity = 0;
            myElement2.style.transition = "opacity 1s";
            myElement2.style.opacity = 0;
            myElement3.style.transition = "opacity 1s";
            myElement3.style.opacity = 0;

        }, 15000);
        setTimeout(function () {
            var myElement1 = document.querySelector("#error-msg");
            var myElement2 = document.querySelector("#error-msg1");
            var myElement3 = document.querySelector("#error-msg2");
            var myElement6 = document.querySelector("#error-msg3");
            var myElement7 = document.querySelector("#error-msg8");
            var myElement = document.querySelector("#rsuccess-msg");
            var myElement4 = document.querySelector("#rsuccess-msg3");
            var myElement5 = document.querySelector("#rsuccess-msg2");
            myElement1.style.display = "none";
            myElement2.style.display = "none";
            myElement3.style.display = "none";
            myElement.style.display = "none";
            myElement4.style.display = "none";
            myElement5.style.display = "none";
            myElement6.style.display = "none";
            myElement7.style.display = "none";
        }, 16000);


        function PassMatchE() {
            var myElement = document.querySelector("#regi");
            var myElement2 = document.querySelector("#modalback");
            var myElement3 = document.querySelector("#error-msg1");
            myElement.style.display = "block";
            myElement2.style.display = "block";
            myElement3.style.display = "block";
        }

        function EmailE() {
            var myElement = document.querySelector("#regi");
            var myElement2 = document.querySelector("#modalback");
            var myElement3 = document.querySelector("#error-msg2");
            myElement.style.display = "block";
            myElement2.style.display = "block";
            myElement3.style.display = "block";
        }

        function UsernameE() {
            var myElement = document.querySelector("#regi");
            var myElement2 = document.querySelector("#modalback");
            var myElement3 = document.querySelector("#error-msg8");
            myElement.style.display = "block";
            myElement2.style.display = "block";
            myElement3.style.display = "block";
        }

        function RSuccess() {
            var myElement = document.querySelector("#rsuccess-msg");
            myElement.style.display = "block";
        }

    </script>

    <?php
    require_once "Template/MobileDetect/Mobile_Detect.php";
    $detect = new Mobile_Detect();
    if ($detect->isMobile() && !$detect->isTablet()) {
        //-------------MOBILES STYLE----------------------

        ?>
        <!--        <link href="Template/Styles/MobileStyle.css" rel="stylesheet"/>-->
        <?php
    } else {
        //-------------PC STYLE----------------------
        ?>
        <!--        <link href="Template/Styles/Style.css" rel="stylesheet"/>-->
        <!--        <link href="Template/Styles/MobileStyle.css" rel="stylesheet"/>-->
        <?php
    }
    ?>
    <link href="Template/Styles/Style.css" rel="stylesheet"/>
    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorDataSource.inc';
    $color = new ColorDataSource();
    $color->open();
    $colors = $color->Fill();
    $color->close();
    ?>
    <style>
        .specification .header {
            color: <?php echo $colors->LightBlue; ?>;
        }

        .tab-header-wrapper .tab-items ul li a {
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        .compare:active, header.header-wrapper div.main-header a div.shopping-cart:active {
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        .jssort16 .title:hover, .jssort16 .title_back:hover {
            background-color: <?php echo $colors->LightBlue; ?>;
        }

        .checkboxFour input[type=checkbox]:checked + label {
            background-color: <?php echo $colors->LightBlue; ?>;
        }

        .checkboxFour {
            background-color: <?php echo $colors->LightBlue; ?>;
        }

        div.main-container aside div.Options header > h3, div.main-container div.Products header > h3 {
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        .jssort16 .pav .title {
            background-color: <?php echo $colors->DarkBlue; ?>;
        }

        .full-list:link, .full-list:visited {
            color: <?php echo $colors->LightBlue; ?>;
        }

        .owl-item a div.item div.bottom span.goods-price {
            color: <?php echo $colors->Green; ?>;
        }

        .product-price2 {
            color: <?php echo $colors->Green; ?>;
        }

        .product-view .product-info .product-price .price {
            color: <?php echo $colors->Green; ?>;
        }

        .btn-td a:link, .btn-td a:visited {
            color: <?php echo $colors->LightBlue; ?>;
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        .communications input[type='submit'] {
            background-color: <?php echo $colors->LightBlue; ?>;
        }

        .product-view .product-info .product-price .unit {
            color: <?php echo $colors->Green; ?>;
        }

        .product-view-btn a:link, .product-view-btn a:visited, .button-container input.btn {
            background-color: <?php echo $colors->Green; ?>;
        }

        .Products td:hover {
            border-color: <?php echo $colors->Green; ?>;
        }

        div.main-container aside div.leates-video header > h3, div.main-container article.goods-list-container header h3, div.main-container aside div.leates-news header > h3 {
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        .owl-item a div.item:hover {
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        div.main-container aside div.leates-video div.item > div.info > a:hover h3, div.main-container aside div.leates-news a:hover h3 {
            color: <?php echo $colors->DarkBlue; ?> !important;
        }

        .login-btn a:link, .login-btn a:visited {
            background-color: <?php echo $colors->LightBlue; ?>;
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        .register-btn a:link, .register-btn a:visited {
            color: <?php echo $colors->LightBlue; ?>;
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        .Pager a:link, .Pager a:visited {

            background-color: <?php echo $colors->DarkBlue; ?>;
        }

        .Search input[type=text]:focus, .Search input[type=submit]:active {
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        .order select:focus {
            border-color: <?php echo $colors->LightBlue; ?>;
        }

        div.main-container aside div.leates-news > a.more-news, div.main-container aside div.leates-video > a.more-video {
            color: <?php echo $colors->LightBlue; ?>;
        }
    </style>

