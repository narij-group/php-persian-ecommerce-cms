<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CommentDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/OpinionDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/DiscountDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GuaranteeDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductColorDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductCouponDataSource.inc';

//$productcoupon = new ProductCoupon();
//$discount = new Discount();

$price = new PriceDataSource();
$price->open();
$prices2 = $price->GetPricesForOneProduct($_GET['id']);
$minPrice = $price->GetMinPrice($_GET['id']);
$price->close();


$pds = new ProductDataSource();
$pds->open();
$product = $pds->FindOneProductBasedOnId($_GET['id']);
$pds->close();


$p = new Product();
$p->ProductId = $_GET['id'];


$cmds = new CommentDataSource();
$cmds->open();
$comment = new Comment();
$comment->ProductId = $_GET['id'];
$comments = $cmds->CFill($comment);
$cmds->close();


$opinion = new OpinionDataSource();
$opinion->open();
//$opinion->ProductId = $_GET['id'];
$opinions = $opinion->CFill($_GET['id']);
$oCounter = 0;
foreach ($opinions as $opinion) {
    $oCounter++;
}


require_once 'Template/top.php';
$_SESSION[SESSION_INT_CURRENT_PAGE] = 1;
$_SESSION[SESSION_INT_CURRENT_PAGE_2] = 1;
if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
    $_SESSION[SESSION_STRING_MESSAGE] = "";
}
?>
    <title><?php echo $product->Name; ?></title>
    <meta name="description" content="<?php echo $product->MetaDescription; ?>">
    <meta name="keywords" content="<?php echo $product->Keywords; ?>">
    <meta name="author" content="<?php echo $product->User->Name . " " . $product->User->Family; ?>">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <link href="Template/Rating/dist/themes/fontawesome-stars.css" rel="stylesheet" type="text/css"/>
    <script language="javascript">
        $(document).ready(
            function () {
                $("#pikame").PikaChoose({carousel: true, carouselOptions: {wrap: 'circular'}});
            });
    </script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("#gallery").unitegallery({
                thumb_width: 80,
                thumb_height: 70,
                thumb_fixed_size: false,
                thumb_round_corners_radius: 5,
                thumb_show_loader: true,
                thumb_loader_type: "dark",
                slider_scale_mode: "fit",
                strippanel_background_color: "#f9f9f9",
                gallery_autoplay: true,
                gallery_play_interval: 10000,
                gallery_pause_on_mouseover: true,
                strippanel_enable_handle: false,
                gallery_skin: "alexis",
                slider_loader_color: "black",
                slider_play_button_offset_vert: 9,
                slider_play_button_offset_hor: 50,
                slider_progress_indicator_offset_hor: 90,
                slider_progress_indicator_offset_vert: 12,
            });
        });
    </script>
<?php
if (isset($_SESSION[SESSION_STRING_MESSAGE])) {
    if ($_SESSION[SESSION_STRING_MESSAGE] == "ErrorMessegeLP()" || $_SESSION[SESSION_STRING_MESSAGE] == "ErrorMessegeLU()") {
        ?>
        <script>
            $(document).ready(function () {
                $("#logi").fadeIn();
                $("#modalback").fadeIn();
                $("#error-msg").fadeIn();
            });
        </script>
        <?php
    } elseif ($_SESSION[SESSION_STRING_MESSAGE] == "PassMatchE()") {
        ?>
        <script>
            $(document).ready(function () {
                $("#regi").fadeIn();
                $("#modalback").fadeIn();
                $("#error-msg1").fadeIn();
            });
        </script>
        <?php
    } elseif ($_SESSION[SESSION_STRING_MESSAGE] == "RSuccess()") {
        ?>
        <script>
            $(document).ready(function () {
                $("#regi").fadeIn();
                $("#modalback").fadeIn();
                $("#rsuccess-msg").fadeIn();
            });
        </script>
        <?php
    } elseif ($_SESSION[SESSION_STRING_MESSAGE] == "UsernameE()") {
        ?>
        <script>
            $(document).ready(function () {
                $("#regi").fadeIn();
                $("#modalback").fadeIn();
                $("#error-msg8").fadeIn();
            });
        </script>
        <?php
    } elseif ($_SESSION[SESSION_STRING_MESSAGE] == "EmailE()") {
        ?>
        <script>
            $(document).ready(function () {
                $("#regi").fadeIn();
                $("#modalback").fadeIn();
                $("#error-msg2").fadeIn();
            });
        </script>
        <?php
    }

}
?>


    <script>
        //        function ErrorMessegeLP()
        //        {
        //            var myElement = document.querySelector("#logi");
        //            var myElement2 = document.querySelector("#modalback");
        //            var myElement3 = document.querySelector("#error-msg");
        //            myElement.style.display = "block";
        //            myElement2.style.display = "block";
        //            myElement3.style.display = "block";
        //        }
        $(document).ready(function () {
            $("#Guarantee").change(function () {
                var guarantee = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'UpdatePrice.php',
                    data: {guaranteeId: guarantee, product: <?php echo $_GET['id'] ?>},
                    success: function (data) {
                        $('#product-price').html(data);
                    }
                });
            });
            $("#btn-options").click(function () {
                if (confirm('آیا میخواهید هنگام موجودی محصول ایمیل دریافت کنید؟')) {
                    $.ajax({
                        type: 'POST',
                        url: 'Internal Inserting/NoticeMe.php',
                        data: {
                            product:<?php echo $_GET['id']; ?> ,
                            customer: <?php echo $_COOKIE[COOKIE_CUSTOMER_ID]; ?>,
                            action: 'existance'
                        },
                        success: function () {
                            $("#o-success-msg").fadeIn(250);
                            setTimeout(function () {
                                $("#o-success-msg").fadeOut(250);
                            }, 5000);
                        }
                    });
                }
            });
            $("#specialoffer-btn").click(function () {
                if (confirm('آیا میخواهید برای پیشنهاد ویژه این محصول ایمیل دریافت کنید؟')) {
                    $.ajax({
                        type: 'POST',
                        url: 'Internal Inserting/NoticeMe.php',
                        data: {
                            product:<?php echo $_GET['id']; ?> ,
                            customer: <?php echo $_COOKIE[COOKIE_CUSTOMER_ID]; ?>,
                            action: 'specialoffer'
                        },
                        success: function () {
                            $("#s-success-msg").fadeIn(250);
                            setTimeout(function () {
                                $("#s-success-msg").fadeOut(250);
                            }, 5000);
                        }
                    });
                }
            });
            $("#btn-compare").click(function () {
                $("#success-compare").fadeOut(250);
                $("#error-compare").fadeOut(250);
                $.ajax({
                    type: 'GET',
                    url: 'AddToCompare.php',
                    data: {id: <?php echo $_GET['id']; ?>},
                    success: function (data) {
                        $('#div').html(data);
                        <?php
                        if (isset($_SESSION[SESSION_INT_PRODUCT_1]) && $_SESSION[SESSION_INT_PRODUCT_1] != 0) {
                            echo '$("#compare-box").addClass("compare-animation")';
                        }
                        ?>
                    }
                });
            });
        });

    </script>
    <script type="text/javascript" src="Template/Scripts/canvasjs.min.js"></script>

    <script type='text/javascript' src='Template/unitegallery/js/unitegallery.min.js'></script>
    <link href="Template/unitegallery/skins/alexis/alexis.css" rel="stylesheet" type="text/css"/>
    <link rel='stylesheet' href='Template/unitegallery/css/unite-gallery.css' type='text/css'/>

    <script type='text/javascript' src='Template/unitegallery/themes/compact/ug-theme-compact.js'></script>

    <style>
        select {
            font-family: b-yekan;
            padding: 5px 8px;
            width: 100%;
            border: none;
            box-shadow: none;
            background: transparent;
            background-image: none;
        }

        select:focus {
            outline: none;
        }
    </style>

    <!--  ------------------------------- instead of Menu.PHP ----------------------------------- -->
<?php include_once 'Template/menu.php'; ?>
    <script type="text/javascript">
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: ""
                },
                animationEnabled: true,
                axisY: {
                    includeZero: false,
                    labelFontColor: "#000",
                    lineColor: "#999",


                    lineThickness: 3,
                    minimum: <?php
                    if ($minPrice > 10000) {
                        echo $minPrice - 10000;
                    } else {
                        echo $minPrice;
                    };?>,
                },
                toolTip: {},
                axisY2: {},
                <?php
                $firstdate = "";
                foreach ($prices2 as $p2) {
                    if ($firstdate == "") {
                        $firstdate = str_replace('/', ',', $p2->Date);
                        $firsprice = $p2->Value;
                    }

                }
                ?>
                axisX: {
                    valueFormatString: "MMM YYYY",
                    interval: 1,
                    intervalType: "month",
                    labelAngle: -50,
                    labelFontColor: "rgb(0,20,20)",
                    minimum: new Date(<?php echo $firstdate; ?>)
                },
                data: [
                    {
                        type: "spline",
                        color: "rgba(0,75,241,0.7)",
                        dataPoints: [
                            <?php
                            $pricegraph = 0;
                            foreach ($prices2 as $p2) {
                                $pricegraph++;
                                echo "{x: new Date(";
                                echo str_replace("/", ",", $p2->Date);
                                echo "), y: $p2->Value },";
                                echo ' ';
                            }
                            ?>
                        ]
                    },
                ]
            });
            chart.render();
        }
    </script>
    <div class="success-message" id="success-compare">محصول با موفقیت به لیست مقایسه افزوده شد!</div>
    <div class="error-message" id="error-compare">شما قبلا این محصول را به لیست مقایسه اضافه کردید!</div>
    <div class="success-message" id="o-success-msg">به محض موجود شدن محصول به شما ایمیل داده میشود!</div>
    <div class="success-message" id="s-success-msg">به محض قرار گرفتن محصول در پیشنهاد های ویژه به شما ایمیل داده
        میشود!
    </div>
    <div class="success-message" id="cart-success-msg">محصول با موفقیت به سبد خرید افزوده شد</div>
    <div class="error-message" id="error-msg">نام کاربری یا رمزعبور اشتباه است!</div>
    <div class="error-message" id="error-msg1">رمز عبور با تکرار رمز عبور برابر نیست !</div>
    <div class="error-message" id="error-msg2">پست الکترونیک شما قبلا ثبت شده است!</div>
    <div class="error-message" id="error-msg8">این نام کاربری قبلا ثبت شده است!</div>
    <div class="success-message" id="rsuccess-msg">ثبت نام با موفقیت انجام شد!</div>

    <div class="modalback" id="modal_back"></div>
    <div class="container">
        <div class="Purchase-Success-Alert" id="purchase_success_alert">
            <div class="msg">
                محصول با موفقیت به سبد خرید افزوده شد
                <i class="fa fa-check"></i>
            </div>
            <div class="btn-box">
                <div class="col-md-6">
                    <a class="btn-finish" href="Purchase.php">اتمام خرید<i class="fa fa-share-square"></i></a>
                </div>
                <div class="col-md-6">
                    <button class="btn-continue" onclick="btn_continue()">ادامه خرید<i class="fa fa-check-square"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="Purchase-Warning-Alert" id="purchase_warning_alert">
            <div class="msg">
                محصول قبلا به سبد خرید اضافه شده است
                <i class="fa fa-warning"></i>
            </div>
            <div class="btn-box">
                <div class="col-xs-6">
                    <button class="btn-finish"><a href="Purchase.php">اتمام خرید<i class="fa fa-share-square"></i></a>
                    </button>
                </div>
                <div class="col-xs-6">
                    <button class="btn-continue" onclick="btn_continue()">ادامه خرید<i class="fa fa-check-square"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
if (isset($_COOKIE[COOKIE_MESSAGE_2])) {
    if ($_COOKIE[COOKIE_MESSAGE_2] == "OError()") {
        ?>
        <div class="error-message" style="display: block;" id="error-msg3">شما قبلا برای این محصول نظر داده اید.</div>
        <?php
    } elseif ($_COOKIE[COOKIE_MESSAGE_2] == "OSuccess()") {
        ?>
        <div class="success-message" style="display: block;" id="rsuccess-msg2">نظر شما با موفقیت افزوده شد، منتظر تایید
            سایت باشید.
        </div>
        <?php
    } elseif ($_COOKIE[COOKIE_MESSAGE_2] == "CSuccess()") {
        ?>
        <div class="success-message" style="display: block;" id="rsuccess-msg3">پرسش یا پاسخ شما با موفقیت افزوده شد،
            منتظر تایید سایت باشید.
        </div>
        <?php
    }
}
?>
<?php
$product->ProductId = $_GET['id'];
?>
    <div class="container">
        <div class="main-container">
            <div class="row">
                <div class="product-categoty-view">
                    <a href="index.php"> فروشگاه</a><img src="Template/Images/arrow-left.png"/><a
                            href="#"><?php echo $product->Group->Name; ?></a><img src="Template/Images/arrow-left.png"/><a
                            href="Products.php?sbgroup=<?php echo $product->SubGroup->SubGroupId; ?>"><?php echo $product->SubGroup->Name; ?></a>
                    <img
                            src="Template/Images/arrow-left.png"/><a
                            href="Products.php?spgroup=<?php echo $product->SupperGroup->SupperGroupId; ?>"><?php echo $product->SupperGroup->Name; ?></a>
                    <img
                            src="Template/Images/arrow-left.png"/><a href="#"><?php echo $product->Name; ?></a>
                </div>
            </div>
            <div class="row">
                <div class="product-view">
                    <!--  ------------------------------- instead of Menu.PHP ----------------------------------- -->
                    <div id="div"></div>
                    <div class="col-md-8">
                        <div class="product-info">
                            <header>
                                <h1><?php echo $product->Name; ?></h1>
                                <h3><?php echo $product->LatinName; ?></h3>
                            </header>
                            <?php
                            if ($product->Stock == 1) {
                                echo '<span class="stock">دست دوم</span>';
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="product-rate" style="position: relative;">
                                        <select id="rate2">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>

                                        <span class="rate-score2"><?php
                                            $opds = new OpinionDataSource();
                                            $opds->open();
                                            echo $opds->GetRateForProduct($_GET['id']);
                                            $opds->close();


                                            ?>
                                            از <?php echo $oCounter; ?> رای</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="product-color">
                                        <h4>
                                            انتخاب رنگ
                                        </h4>
                                        <ul>
                                            <li>
                                                <?php
                                                $i = 1;
                                                $productcolor = new ProductColorDataSource();
                                                $productcolor->open();
                                                $productcolors = $productcolor->GetProductColorsForOneProduct($_GET['id']);
                                                $productcolor->close();
                                                foreach ($productcolors as $co) {
                                                    if ($co->Quantity > 0) {
                                                        echo "<div class='radio-btn'><input type='radio' value='$co->ProductColorId' id='$co->ProductColorId' ";
                                                        if ($i == 1) {
                                                            $i++;
                                                            echo ' checked ';
                                                        }
                                                        echo "Class='Color' name='Color' /><label for=$co->ProductColorId >" . $co->Color->Name . "</label><div class='color-sample2' style='margin-top:2px ; background-color: " . $co->Color->Sample . ";' ></div></div>";
                                                    }
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="astronat">

                                    <?php
                                    $available = true;
                                    if ($product->User->Username > 0) {
                                        ?>
                                        <div class="status2">
                                            <img src="Template/Images/Plugins/available.png" alt=""/>
                                            <span class="green-color">موجود</span>
                                        </div>
                                        <?php
                                    } else {
                                        $available = false;
                                        ?>
                                        <div class="status2">
                                            <img src="Template/Images/Plugins/unavailable.png" alt=""/>
                                            <span class="red-color">ناموجود</span>
                                        </div>
                                        <?php
                                    }
                                    ?>


                                    <?php
                                    $discount = new DiscountDataSource();
                                    $discount->open();
                                    $dd = $discount->GetLastDiscountForTheProduct($p->ProductId);
                                    $discount->close();
                                    if ($dd == null || $dd->SpecialOffer == 0) {
                                        ?>
                                        <div class="specialoffer" <?php
                                        if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                            echo 'id="specialoffer-btn"';
                                        } else {
                                            echo 'onclick="loginFirst()"';
                                        }
                                        ?> title="اطلاع رسانی از پیشنهاد ویژه">
                                            <img src="Template/Images/bell.png"/>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="specialoffer2">
                                            <img src="Template/Images/star.png" alt=""/>
                                            <span>پیشنهاد ویژه</span>
                                        </div>
                                        <?php
                                    }
                                    ?>


                                    <?php

                                    $productcoupon = new ProductCouponDataSource();
                                    $productcoupon->open();
                                    if ($productcoupon->FindOneProductCoupons2($product->ProductId) != 0) {
                                        ?>
                                        <div class="coupon">
                                            <span> +<?php echo $productcoupon->FindOneProductCoupons2($product->ProductId); ?> </span>
                                            کپن
                                        </div>
                                        <br/>
                                        <?php
                                    }
                                    $productcoupon->close();
                                    ?>


                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="product-warranty">
                                        <h4>
                                            انتخاب گارانتی
                                        </h4>
                                        <div class="waranty-items">
                                            <select class="guarante" required name="Guarantee" id="Guarantee">
                                                <?php
                                                $guarantee = new GuaranteeDataSource();
                                                $guarantee->open();
                                                $first = true;
                                                $guarantees = $guarantee->GetGuaranteesForOneProduct($_GET['id']);
                                                if ($guarantees == null) {
                                                    echo "<option value='0' >";
                                                    echo 'بدون گارانتی';
                                                    echo '</option>';
                                                    $guaranteePrice = 0;
                                                }
                                                foreach ($guarantees as $g) {
                                                    if ($first == true) {
                                                        $guaranteePrice = $g->Guarantee->Price;
                                                    }
                                                    $first = false;
                                                    echo "<option value='$g->GuaranteeId'>";
                                                    echo $g->Guarantee->Name . ' ' . $g->Guarantee->Duration;
                                                    echo "</option>";
                                                }

                                                $guarantee->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="product-price">
                                    <a class="bg" href="#tabcontrol"></a>
                                    <label>
                                        قیمت :
                                    </label>
                                    <?php
                                    $discount = new DiscountDataSource();
                                    $discount->open();
                                    $last_discount = $discount->GetLastDiscountForOneProduct($p->ProductId);
                                    $discount->close();
                                    $price = new PriceDataSource();
                                    $price->open();
                                    $last_prie = $price->GetLastPriceForOneProduct($p->ProductId);
                                    $price->close();
                                    ?>
                                    <span id="product-price"
                                          class="price">
                                        <?php
                                        if ($last_prie != 0) {
                                            echo number_format(($last_prie - ($last_prie * $last_discount / 100) + $guaranteePrice) * $tax);
                                            echo '</span>';
//                                    <!--<span class="price" id="guarantee-price" name="guarantee-price"></span>-->
                                            echo '<span class="unit">تومان</span>';
                                        } else {
                                            echo 'رایگان</span>';
                                        }
                                        ?>
                                </div>

                                <?php
                                if ($last_prie - ($last_prie - ($last_prie * $last_discount / 100)) != 0) {
                                    ?>
                                    <div class="product-discount">
                <span class="price">
                <?php
                echo number_format(($last_prie - ($last_prie - ($last_prie * $last_discount / 100))) * $tax);
                ?>
                    </span>
                                        <span class="unit">تومان تخفیف</span>
                                    </div>
                                    <?php
                                }
                                //                                $discount->close();
                                //                                $price->close();
                                ?>

                                <input type="hidden" id="Name" value="<?php echo $product->Name; ?>"/>
                                <input type="hidden" id="ProductId" value="<?php echo $product->ProductId; ?>"/>
                                <input type="hidden" id="LatinName" value="<?php echo $product->LatinName; ?>"/>
                                <input type="hidden" id="Image" value="<?php echo "Images/$product->ProductId"; ?>"/>
                                <?php
                                //                            $discount = new DiscountDataSource();
                                //                            $discount->open();
                                //
                                //                            $price = new PriceDataSource();
                                //                            $price->open();

                                ?>
                                <input type="hidden" id="Price"
                                       value="<?php echo ($last_prie - ($last_prie * $last_discount / 100)) * $tax; ?>"/>
                                <?php
                                //                            $discount->close();
                                //                            $price->close();
                                ?>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="product-cart-state">
                                        <div class="col-md-4 pull-right">
                                            <a href="#" id="btn-compare" class="btn-compare">مقایسه کن</a>
                                        </div>
                                        <div class="col-md-4 pull-right">
                                            <?php

                                            if ($available == true) {
                                            ?>
                                            <input type="button" onclick="<?php
                                            if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                                echo "cart($p->ProductId)";
                                            } else {
                                                echo "cart($p->ProductId)";
                                            }
                                            ?>" href='#'
                                                <?php
                                                if ($product->User->Username <= 0) {
                                                    echo ' disabled="true" ';
                                                }
                                                ?>
                                                   class="btn-add-to-cart" value="افزودن به سبد خرید"/>
                                        </div>
                                        <div class="col-md-4 pull-right">
                                            <?php
                                            } else {
                                                ?>
                                                <a <?php
                                                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                                    echo 'id="btn-options"';
                                                } else {
                                                    echo 'onclick="loginFirst()"';
                                                }
                                                ?> class="btn-options">اطلاع هنگام موجودی</a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <?php
                                if (isset($_SESSION[SESSION_STRING_CART_ERROR])) {

                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="product-gallery">
                            <div id="gallery" style="display:none; ">
                                <?php
                                $dir = "Images/$product->ProductId";
                                $files = array_values(array_filter(scandir($dir), function ($file) {
                                    return !is_dir($file);
                                }));

                                foreach ($files as $file) {
                                    if (strpos($file, 'png') !== false || strpos($file, 'jpg') !== false) {
                                        echo "<img alt='Preview Image' src='$dir/$file' data-image='$dir/$file' data-description='Preview Image Description'/>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <!--Product Description-->
                <div class="product-description">
                    <header>
                        معرفی محصول
                    </header>

                    <div class="inner-content">
                        <p>
                            <?php
                            echo $product->Description;
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Tab Container -->
                <div class="tabs">
                    <!--Tab Items-->
                    <div class="tab-header-wrapper">
                        <div class="tab-items">
                            <ul>
                                <?php
                                if ($pricegraph != 1 && $pricegraph != 0) {
                                    ?>
                                    <li class="active"><a href="#pricegraph">نمودار قیمت</a></li>
                                    <?php
                                }
                                ?>

                                <li <?php
                                if ($pricegraph == 0 || $pricegraph == 1) {
                                    echo 'class="active"';
                                }
                                ?>><a href="#review">نقد و بررسی</a></li>
                                <li><a href="#specifications">مشخصات فنی</a></li>
                                <li><a href="#comments">نظرات کاربران</a></li>
                                <li><a href="#faq">پرسش و پاسخ</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--Tab Content-->
                    <div class="tab-content" id="tabcontrol">
                        <!-- Price Tab -->
                        <?php
                        if ($pricegraph != 1 && $pricegraph != 0) {
                            ?>
                            <div id="pricegraph" class="tab active price">
                                <h3 class="title">
                                    <span class="caret-left"></span>
                                    نمودار قیمت محصول
                                </h3>
                                <div id="chartContainer" class="chart"></div>
                                <span class="price_comment">دامنه تغییرات قیمت ( تومان ) </span>
                            </div>
                            <?php
                        }
                        ?>

                        <!--ReView Tab-->
                        <div id="review" class="tab <?php
                        if ($pricegraph == 0 || $pricegraph == 1) {
                            echo 'active';
                        }
                        ?> review">
                            <p>
                                <?php
                                echo $product->Review;
                                ?>
                            </p>
                        </div>
                        <div class="clear-fix"></div>
                        <!--Specification Tab-->
                        <div id="specifications" class="tab specification">
                            <h3 class="header">مشخصات فنی</h3>
                            <h4 class="title">
                                <span class="caret-left"></span>
                                مشخصات کلی
                            </h4>
                            <ul class="spec-items">
                                <?php
                                require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductAndPropertyDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductDataSource.inc';


                                $product = new Product();
                                $productAndProperty = new ProductAndProperty();
                                if (isset($_GET['id'])) {
                                    $product->ProductId = $_GET['id'];
                                    $pds = new ProductDataSource();
                                    $pds->open();
                                    $productAndProperties = $pds->GetProperties($_GET['id']);
                                    $pds->close();
                                    $_SESSION[SESSION_INT_PRODUCT_ID] = $_GET['id'];
                                }
                                $t2 = 0;
                                ?>
                                <li class="clearfix">
                                    <?php
                                    foreach ($productAndProperties as $pa) {
                                        $t2++;
                                    }
                                    if ($t2 != 0) {
                                    ?>

                                    <div class="PropertiesTable">
                                        <?php } ?>

                                        <?php
                                        foreach ($productAndProperties as $pa) {
                                            echo '<span class="technicalspecs-title">';
                                            echo $pa->ProductProperty->Name;
                                            echo '</span>';


                                            if (trim($pa->Value) == "دارد") {
                                                echo '<span class="technicalspecs-value green-back">';
                                                echo '<img src="Template/Images/Exist.png" width= "15" height = "15" />';
                                            } elseif (trim($pa->Value) == "ندارد") {
                                                echo '<span class="technicalspecs-value red-back">';
                                                echo '<img src="Template/Images/NotExist.png" width= "15" height = "15" />';
                                            } else {
                                                echo '<span class="technicalspecs-value ';
                                                if (strlen($pa->Value) > 50) {
//                                        echo ' full-width ';
                                                }
                                                echo '">';
                                                echo $pa->Value;
                                            }


                                            echo '</span>';
                                            echo '<div class="clear-fix"></div>';

                                            $t2++;
                                        }
                                        ?>

                                        <?php if ($t2 != 0) { ?>
                                    </div>
                                <?php } ?>
                                </li>
                            </ul>
                        </div>
                        <div class="clear-fix"></div>

                        <!--Comment Tab-->
                        <div id="comments" class="tab comment">
                            <h3 class="title">
                                <span class="caret-left"></span>
                                نظر خود را مطرح کنید
                            </h3>
                            <?php
                            if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                echo '<form action="Internal Inserting/InsertOpinion.php" method="post">';
                            }
                            ?>
                            <textarea id="productId" name="value"
                                      placeholder="متن نظر خود را اینجا بنویسید ..."></textarea>
                            <input type="hidden" id="productId" name="productId"
                                   value="<?php echo $product->ProductId; ?>"/>
                            <input type="hidden" id="customer" name="customer"
                                   value="<?php echo $_COOKIE[COOKIE_CUSTOMER_ID]; ?>"/>
                            <div class="rating">
                                <select id="rate" name="rate">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <span class="rating-span">امتیاز کلی محصول</span>
                            <br/>
                            <br/>
                            <br/>
                            <div class="button-container">
                                <input type="submit" onclick="<?php
                                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {

                                } else {
                                    echo 'loginFirst()';
                                }
                                ?>" class="btn" value="ثبت نظر"/>
                            </div>
                            <?php
                            if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                echo "</form>";
                            }
                            ?>
                            <?php
                            $_SESSION[SESSION_INT_OPINIONS_COUNTER] = 0;
                            foreach ($opinions as $c) {
                                if ($c->ProductId == $product->ProductId && $c->Activated == 1) {
                                    $_SESSION[SESSION_INT_OPINIONS_COUNTER]++;
                                }
                            }
                            ?>
                            <h3 class="title">
                                <span class="caret-left"></span>
                                نظرات
                                <span>(<?php echo $_SESSION[SESSION_INT_OPINIONS_COUNTER]; ?> نظر)</span>
                            </h3>
                            <div class="horizontal-line"></div>
                            <?php
                            $i = 0;
                            $t = 0;
                            foreach ($opinions as $c) {
                                $i++;
                            }
                            $j = 30;
                            $pages2 = ceil($i / $j);
                            $pp22 = 1;
                            ?>
                            <div class="comment-list-container" id="opinions5">
                                <?php
                                foreach ($opinions as $c) {
                                    $_SESSION[SESSION_INT_OPINIONS_COUNTER]++;
                                    if (isset($_SESSION[SESSION_INT_CURRENT_PAGE_2]) == TRUE && ($_SESSION[SESSION_INT_CURRENT_PAGE_2] * 30) - (30 - 1) <= $pp22 && $pp22 <= $_SESSION[SESSION_INT_CURRENT_PAGE_2] * 30) {
                                        ?>
                                        <div class="comment-box">
                                            <div class="db-cover6" id="wait2">
                                                <span class="loading-title8">لطفا چند لحظه صبر کنید...</span>
                                                <img class="loading-gif8" src="Admin/Template/Images/gifs/loading.gif"
                                                     alt=""/>
                                            </div>
                                            <div class="heading">
                                                <span class="comment-box-ico"></span>
                                                <div class="auther">
                                                    <h5><?php echo $c->Customer->Name . " " . $c->Customer->Family; ?></h5>
                                                    <time>
                                                        <?php
                                                        echo $c->Date;
                                                        ?>
                                                    </time>
                                                </div>
                                                <div class="like-container">
                                                    <select id="rate<?php echo $c->OpinionId; ?>">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                <script type="text/javascript">
                                                    $(function () {
                                                        $('#rate<?php echo $c->OpinionId; ?>').barrating({
                                                            theme: 'fontawesome-stars',
                                                            readonly: true
                                                        });
                                                        $('#rate<?php echo $c->OpinionId; ?>').barrating('set', <?php echo $c->Rate; ?>);
                                                    });
                                                </script>
                                            </div>
                                            <div class="horizontal-line"></div>
                                            <div class="comment-content">
                                                <p>
                                                    <?php echo $c->Value; ?>
                                                </p>
                                            </div>

                                        </div>
                                        <?php
                                        $t++;
                                    }
                                    $pp22++;
                                }
                                if ($t == 0) {
                                    echo '<div class="CommentText">';
                                    echo "نظری ثبت نشده است .";
                                    echo '</div>';
                                }
                                ?>

                                <?php
                                if ($pages2 != 1 && $opinions != null) { ?>
                                    <div class="Pager2">
                                        <a class="page-link2" id="1" href="#comments">صفحه اول</a>
                                        <?php
                                        $s = 1;
                                        for ($j = 1; $j <= $pages2; $j++) {
                                            if ($j <= 5) {
                                                echo ' <a class="page-link2 ';
                                                if ($j == 1) {
                                                    echo ' Selected ';
                                                }
                                                echo '" id="' . $j . '" ';
                                                echo ' href="#comments">' . $j . '</a>';
                                            }
                                            if ($j == 5) {
                                                echo ' <span >...</span>';
                                            }
                                        }
                                        ?>
                                        <a id="<?php echo $pages2; ?>" class="page-link2" href="#comments">آخرین
                                            صفحه</a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Faq Tab-->
                        <div id="faq" class="tab faq">
                            <h3 class="title">
                                <span class="caret-left"></span>
                                پرسش خود را مطرح نمایید
                            </h3>
                            <?php
                            if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                echo '<form action="Internal Inserting/InsertComment.php" method="post">';
                            }
                            ?>
                            <textarea id="value" name="value"
                                      placeholder="متن پرسش خود را اینجا بنویسید ..."></textarea>
                            <input type="hidden" id="productId" name="productId"
                                   value="<?php echo $product->ProductId; ?>"/>
                            <input type="hidden" id="customer" name="customer"
                                   value="<?php echo $_COOKIE[COOKIE_CUSTOMER_ID]; ?>"/>
                            <div class="button-container">
                                <input type="submit" onclick="<?php
                                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {

                                } else {
                                    echo 'loginFirst()';
                                }
                                ?>" class="btn" value="ثبت پرسش"/>
                                <div class="role">
                                    <input type="checkbox"/>
                                    <span>
                        اولین پاسخی که به پرسش من داده شد، از طریق ایمیل به من اطلاع دهید.
                    </span>
                                    <br/>
                                    <span>با انتخاب دکمه “ثبت پرسش”، موافقت خود را با قوانین انتشار محتوا در فروشگاه اعلام می کنم.</span>
                                </div>
                            </div>
                            <?php
                            if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                echo '</form>';
                            }
                            $_SESSION[SESSION_INT_COMMENTS_COUNTER] = 0;
                            foreach ($comments as $c) {
                                $_SESSION[SESSION_INT_COMMENTS_COUNTER]++;
                            }
                            $i = 0;
                            $j = 30;
                            $pages = ceil($_SESSION[SESSION_INT_COMMENTS_COUNTER] / $j);
                            $pp2 = 1;
                            ?>
                            <h3 class="title">
                                <span class="caret-left"></span>
                                پرسش ها و پاسخ ها
                                <span>(<?php echo $_SESSION[SESSION_INT_COMMENTS_COUNTER]; ?> پرسش)</span>
                            </h3>
                            <div class="horizontal-line"></div>
                            <div class="faq-list-container" id="comments5" style="position: relative;">
                                <div class="db-cover6" id="wait">
                                    <span class="loading-title8">لطفا چند لحظه صبر کنید...</span>
                                    <img class="loading-gif8" src="Admin/Template/Images/gifs/loading.gif" alt=""/>
                                </div>
                                <?php
                                $t = 0;
                                foreach ($comments as $c) {
                                    if (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == TRUE && ($_SESSION[SESSION_INT_CURRENT_PAGE] * 30) - (30 - 1) <= $pp2 && $pp2 <= $_SESSION[SESSION_INT_CURRENT_PAGE] * 30) {
                                        if ($c->ReplyId == 0) {
                                            $_SESSION[SESSION_INT_COMMENTS_COUNTER]++;
                                            ?>
                                            <div class="faq-panel">
                                                <div class="heading">
                                <span class="header-title">
                                    <span class="question-ico"></span>
                                    پرسش
                                </span>
                                                    <time class="time">
                                                        <?php echo $c->Date; ?>
                                                    </time>
                                                    <span class="auther">
                                    <?php echo $c->Customer->Name . ' ' . $c->Customer->Family; ?>
                                </span>
                                                </div>
                                                <div class="question-body rounr-corner">
                                                    <?php echo $c->Value; ?>
                                                </div>
                                                <?php
                                                $commentR = new Comment();
                                                $commentRs = $commentR->FindOneCommentReplies($c->CommentId);
                                                if ($commentRs != null) {
                                                    foreach ($commentRs as $cr) {
                                                        ?>
                                                        <div class="answer-body rounr-corner">
                                                            <i class="user-comment-ico"></i>
                                                            <div class="user-replay-header">
                                                                <div class="auther">
                                                                    <h5>
                                                                        <?php echo $cr->Customer->Name . ' ' . $cr->Customer->Family; ?>
                                                                    </h5>
                                                                    <time>
                                                                        <?php echo $cr->Date; ?>
                                                                    </time>
                                                                </div>
                                                            </div>

                                                            <div class="horizontal-line"></div>
                                                            <div class="user-replay-content">
                                                                <label>
                                                                    پاسخ :
                                                                </label>
                                                                <p>
                                                                    <?php
                                                                    echo $cr->Value;
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </div>
                                            <div class="answer-op">
                                                <a onclick="<?php
                                                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {

                                                } else {
                                                    echo 'loginFirst()';
                                                }
                                                ?>" href="
                               <?php
                                                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                                    echo "Answer.php?commentId=$c->CommentId&productId=$product->ProductId";
                                                } else {
                                                    echo '#';
                                                }
                                                ?>">
                                <span class="arrow-left">
                                </span>
                                                    به این پرسش پاسخ دهید
                                                </a>
                                            </div>

                                            <?php
                                            $t++;
                                        }
                                    } elseif (!isset($_SESSION[SESSION_INT_CURRENT_PAGE]) && 1 <= $pp2 && $pp2 <= 30) {
                                        if ($c->ReplyId == 0) {
                                            $_SESSION[SESSION_INT_COMMENTS_COUNTER]++;
                                            ?>
                                            <div class="faq-panel">
                                                <div class="heading">
                                <span class="header-title">
                                    <span class="question-ico"></span>
                                    پرسش
                                </span>
                                                    <time class="time">
                                                        <?php echo $c->Date; ?>
                                                    </time>
                                                    <span class="auther">
                                    <?php echo $c->Customer->Name . ' ' . $c->Customer->Family; ?>
                                </span>
                                                </div>
                                                <div class="question-body rounr-corner">
                                                    <?php echo $c->Value; ?>
                                                </div>
                                                <?php
                                                $commentR = new Comment();
                                                $commentRs = $commentR->FindOneCommentReplies($c->CommentId);
                                                if ($commentRs != null) {
                                                    foreach ($commentRs as $cr) {
                                                        ?>
                                                        <div class="answer-body rounr-corner">
                                                            <i class="user-comment-ico"></i>
                                                            <div class="user-replay-header">
                                                                <div class="auther">
                                                                    <h5>
                                                                        <?php echo $cr->Customer->Name . ' ' . $cr->Customer->Family; ?>
                                                                    </h5>
                                                                    <time>
                                                                        <?php echo $cr->Date; ?>
                                                                    </time>
                                                                </div>
                                                            </div>

                                                            <div class="horizontal-line"></div>
                                                            <div class="user-replay-content">
                                                                <label>
                                                                    پاسخ :
                                                                </label>
                                                                <p>
                                                                    <?php
                                                                    echo $cr->Value;
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </div>
                                            <div class="answer-op">
                                                <a onclick="<?php
                                                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {

                                                } else {
                                                    echo 'loginFirst()';
                                                }
                                                ?>" href="
                               <?php
                                                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                                                    echo "Answer.php?commentId=$c->CommentId&productId=$product->ProductId";
                                                } else {
                                                    echo '#';
                                                }
                                                ?>">
                                <span class="arrow-left">
                                </span>
                                                    به این پرسش پاسخ دهید
                                                </a>
                                            </div>

                                            <?php
                                            $t++;
                                        }
                                    }
                                    $pp2++;
                                }
                                if ($t == 0) {
                                    echo '<div class="CommentText">';
                                    echo "پرسشی ثبت نشده است .";
                                    echo '</div>';
                                }
                                ?>
                                <?php
                                if ($pages != 1 && $comments != null) { ?>
                                    <div class="Pager2">
                                        <a class="page-link" id="1" href="#faq">صفحه اول</a>
                                        <?php
                                        $s = 1;
                                        for ($j = 1; $j <= $pages; $j++) {
                                            if ($j <= 5) {
                                                echo ' <a class="page-link ';
                                                if ($j == 1) {
                                                    echo ' Selected ';
                                                }
                                                echo '" id="' . $j . '" ';
                                                echo ' href="#faq">' . $j . '</a>';
                                            }
                                            if ($j == 5) {
                                                echo ' <span >...</span>';
                                            }
                                        }
                                        ?>
                                        <a id="<?php echo $pages; ?>" class="page-link" href="#faq">آخرین صفحه</a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function () {
                            $(".page-link").click(function () {
                                $("#wait").fadeIn(0);
                                $.ajax({
                                    url: 'AjaxSearch/CommentPager.php',
                                    type: 'POST',
                                    data: {
                                        page: $(this).attr('id'), product: <?php echo $_GET['id']; ?>
                                    },
                                    success: function (result) {
                                        $("#comments5").html(result);
                                    },
                                    error: function (result) {
                                        alert("لطفا دوباره امتحان کنید!");
                                    }
                                });
                            });
                        });
                        $(document).ready(function () {
                            $(".page-link2").click(function () {
                                $("#wait2").fadeIn(0);
                                $.ajax({
                                    url: 'AjaxSearch/OpinionPager.php',
                                    type: 'POST',
                                    data: {
                                        page: $(this).attr('id'), product: <?php echo $_GET['id']; ?>
                                    },
                                    success: function (result) {
                                        $("#opinions5").html(result);
                                    },
                                    error: function (result) {
                                        alert("لطفا دوباره امتحان کنید!");
                                    }
                                });
                            });
                        });
                    </script>

                    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>-->
                    <script src="Template/Rating/dist/jquery.barrating.min.js" type="text/javascript"></script>
                    <script type="text/javascript">
                        $(function () {
                            $('#rate').barrating({
                                theme: 'fontawesome-stars'
                            });

                            $('#rate2').barrating({
                                theme: 'fontawesome-stars',
                                readonly: true
                            });
                            $('#rate2').barrating('set', <?php
                                $opds = new OpinionDataSource();
                                $opds->open();
                                echo $opds->GetRateForProduct($_GET['id']);
                                $opds->close();

                                ?>);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
<?php
require_once 'Template/bottom.php';
    