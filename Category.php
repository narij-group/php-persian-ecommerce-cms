<?php
include_once 'Template/top.php';
$_SESSION[SESSION_INT_PRICE_HOLDER] = "";
$_SESSION[SESSION_INT_CURRENT_PAGE] = 1;
$_SESSION[SESSION_STRING_ORDER] = " ProductId";
if (isset($_GET['BestSellers'])) {
    $_SESSION[SESSION_STRING_ORDER] = " Sells";
} elseif (isset($_GET['MostPopular'])) {
    $_SESSION[SESSION_STRING_ORDER] = " Popularity";
}
$_SESSION[SESSION_STRING_ASC_DESC_ORDER_TYPE] = " DESC ";
$_SESSION[SESSION_STRING_CHECKED_BOX] = "";
$_SESSION[SESSION_STRING_SEARCH_BOX] = "";
?>
    <title><?php echo $settings->SiteName; ?>- جستجو</title>
    <script>
        $(document).ready(function () {

            $('ul.needmore').each(function () {

                var LiN = $(this).find('li').length;
                if (LiN > 6) {
                    $('li', this).eq(5).nextAll().hide().addClass('toggleable');
                    $(this).append('<li class="more">+ بیشتر...</li>');
                }

            });
            $('ul').on('click', '.more', function () {
                if ($(this).hasClass('less')) {
                    $(this).text('+ بیشتر...').removeClass('less');
                } else {
                    $(this).text('- بستن...').addClass('less');
                }
                $(this).siblings('li.toggleable').slideToggle();
            });
        });</script>
    <!--<link href="Template/noUiSlider/nouislider.min.css" rel="stylesheet" type="text/css"/>-->
    <link href="Template/noUiSlider/nouislider.css" rel="stylesheet" type="text/css"/>


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="Template/Rating/dist/themes/custom2.css" rel="stylesheet" type="text/css"/>

    <div class="success-message" id="cart-success-msg">محصول با موفقیت به سبد خرید افزوده شد</div>

<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SubGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SupperGroupDataSource.inc';


//$protocol = new ProtocolList();
//$protocols = $protocol->Fill();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/LogoDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SubMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SupperMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/MenuTitleDataSource.inc';
//$logo = new LogoDataSource();
//$logo->open();
//$logos = $logo->Fill();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/OpinionDataSource.inc';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductColorDataSource.inc';


$color = new ProductColorDataSource();
$color->open();
$colors = $color->Fill();
$color->close();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/DiscountDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductDataSource.inc';
$product = new Product();


$opinion = new OpinionDataSource();
$opinion->open();


$discount = new DiscountDataSource();
$discount->open();
$price = new PriceDataSource();
$price->open();

$products = array();
if (isset($_GET['group'])) {


    $pds = new ProductDataSource();
    $pds->open();
    $productIds = $pds->FillByG($_GET['group']);
    $pds->close();
    $products = array();
    $i = 0;
    $GroupId = $_GET['group'];
    foreach ($productIds as $p) {
        $p2 = new ProductDataSource();
        $p2->open();
//        $p2->ProductId = $p;
        $products[$i] = $p2->FindOneProductBasedOnId($p);
        $p2->close();
        $i++;
    }
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }
} else {


    $p = new ProductDataSource();
    $p->open();
    $products = $p->CFill($_SESSION[SESSION_STRING_ORDER], $_SESSION[SESSION_STRING_ASC_DESC_ORDER_TYPE]);
    $p->close();
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
//            $logo->LogoId = $l;
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }
}
?>
    <title>دسته بندی ها</title>
    <script>
        $(document).ready(function () {

            var $li = $('#catmenu li').click(function () {
                $li.removeClass('selected');
                $(this).addClass('selected');
            });

            var $a = $('.items a').click(function () {
                $a.removeClass('selected');
                $(this).addClass('selected');
            });

            var elem = document.querySelector('#flickity');
            var elem2 = document.querySelector('.gallery');
            var flkty = new Flickity(elem, {
                // options
                cellAlign: 'right',
                contain: true,
                freeScroll: true,
                pageDots: false,
                rightToLeft: true,
                prevNextButtons: false
            });

            var flkty = new Flickity(elem2, {
                // options
                cellAlign: 'right',
                contain: true,
                freeScroll: true,
                pageDots: false,
                rightToLeft: true,
                prevNextButtons: false
            });
        });

    </script>

    <script type='text/javascript' src='Template/Scripts/flickity-docs.min.js'></script>
    <link rel='stylesheet' href='Template/Styles/flickity-docs.css' type='text/css'/>

    <meta name="description" content="Category"/>
<?php
include_once 'Template/menu.php';
?>
    <div class="success-message" style="display: none;" id="success-compare">محصول با موفقیت به لیست مقایسه
        افزوده شد!
    </div>
    <div class="error-message" style="display: none;" id="error-compare">شما قبلا این محصول را به لیست
        مقایسه اضافه
        کردید!
    </div>

    <div class="success-message" style="background-color: #fff49e; color: black;" id="cart-warning-cart-msg">
        محصول قبلا به سبد خرید اضافه شده است
    </div>
    <div class="container">
        <div class="main-container">

            <?php
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GroupDataSource.inc';
            $gds = new GroupDataSource();
            $gds->open();
            $groups = $gds->Fill();
            $gds->close();
            echo '<div class="row hidden-xs">';
            echo '<div class="top-category">';
            foreach ($groups as $g) {
                if ($g->PlaceAsMainCat == 1) {
                    echo '<a class="pointer">';
                    echo '<div class="gallery_category col-lg-2 col-md-2 col-sm-2 col-xs-6 filter hdpe" id="' . $g->GroupId . '">';
                    echo '<img src="' . $g->Image . '" class="img-responsive">';
                    echo '<div class="desc">' . $g->Name . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            }
            echo '</div>';
            echo '</div>';

            echo '<div class="row visible-xs" id="catmenu" style="margin-top: -15px; margin-bottom: 15px;">';
            echo '<ul class="gallery">';
            foreach ($groups as $g) {
                echo '<a class="pointer">';
                echo '<li class="gallery-cell gallery_category_mob" id="' . $g->GroupId . '">';
                echo '<div class="image">';
                echo '<img src="' . $g->Image . '">';
                echo '</div>';
                echo '<div class="text">';
                echo $g->Name;
                echo '</div>';
                echo '</li>';
                echo '</a>';
            }
            echo '</ul>';
            echo '<div class="clear-fix"></div>';
            echo '<div id="category-list2">';
            echo ' <div class="items" id="flickity">';
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SubGroupDataSource.inc';
            $sgds = new SubGroupDataSource();
            $sgds->open();
            $subgroups1 = $sgds->FillByGroup($_GET['group']);
            $sgds->close();
            foreach ($subgroups1 as $sb) {
                echo '<a class="pointer sgmobile" id="' . $sb->SubGroupId . '">';
                echo '<div class="gallery-cell">';
                echo $sb->Name;
                echo '</div>';
                echo '</a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            ?>


            <div class="row">
                <div class="content col-md-9">
                    <!--Content-->
                    <div class="Products">
                        <div class="header">
                            <div class="title col-md-12">
                                <span>عنوان</span>
                            </div>
                        </div>
                        <div class="header-line"></div>

                        <div class="Search">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="order">
                                        <span> مرتب سازی بر اساس</span>
                                        <select id="Order1">
                                            <option value="ProductId">تازگی</option>
                                            <option value="Price">قیمت</option>
                                            <option value="Sells" <?php
                                            if (isset($_GET['BestSellers'])) {
                                                echo ' selected ';
                                            }
                                            ?>>فروش
                                            </option>
                                            <option value="Visits">بازدید</option>
                                            <option value="Popularity" <?php
                                            if (isset($_GET['MostPopular'])) {
                                                echo ' selected ';
                                            }
                                            ?> >محبوبیت
                                            </option>
                                        </select>
                                        <select id="Order2">
                                            <option value="DESC">نزولی</option>
                                            <option value="ASC">صعودی</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <input type="text" name="search_box" id="search_box2"
                                           placeholder="جستجو بین کالاهای زیر..."/>
                                </div>
                            </div>
                        </div>
                        <div id="products">
                            <div class="db-cover5" id="wait">
                                <span class="loading-title"></span>
                                <img class="loading-gif" src="Template/Images/loading.gif" alt=""/>
                            </div>

                            <div class="col-md-12">
                                <div class="TBL">
                                    <?php
                                    $i = 0;
                                    $j = 30;
                                    foreach ($products as $p1) {
                                        $i++;
                                    }
                                    $pages = ceil($i / $j);
                                    $pp2 = 1;

                                    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/UI/WidgetBuilder.php';
                                    if (count($products) != 0 && !isset($_GET['special_offers'])) {
                                        foreach ($products as $p1) {
                                            //TODO START

                                            if (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == TRUE && ($_SESSION[SESSION_INT_CURRENT_PAGE] * 30) - (30 - 1) <= $pp2 && $pp2 <= $_SESSION[SESSION_INT_CURRENT_PAGE] * 30) {
                                                if ($settings->AskQuantityForAdding == 1) {
                                                    WidgetBuilder::createProductThumbWidgetInstantPurchase($p1, $tax);
                                                } else {
                                                    WidgetBuilder::createProductThumbWidget($p1, $tax);
                                                }
                                            } elseif (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == FALSE && 1 <= $pp2 && $pp2 <= 30) {
                                                if ($settings->AskQuantityForAdding == 1) {
                                                    WidgetBuilder::createProductThumbWidgetInstantPurchase($p1, $tax);
                                                } else {
                                                    WidgetBuilder::createProductThumbWidget($p1, $tax);
                                                }
                                            }
                                            //TODO END
                                            $pp2++;
                                        }
                                    } elseif (isset($_GET['special_offers'])) {

                                        foreach ($products as $p1) {
                                            if ($settings->AskQuantityForAdding == 1) {
                                                WidgetBuilder::createProductThumbWidgetInstantPurchase($p1, $tax);
                                            } else {
                                                WidgetBuilder::createProductThumbWidget($p1, $tax);
                                            }
                                        }

                                    } else {
                                        ?>
                                        <div class="search-error-p">
                                            <div>متاسفانه موردی بین محصولات پیدا نشد.</div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                            <div class="clear-fix"></div>


                            <?php
                            if ($pages != 1 && $products != null) { ?>
                                <div class="Pager">
                                    <a class="page-link" id="1" href="">صفحه اول</a>
                                    <?php
                                    $s = 1;
                                    for ($j = 1; $j <= $pages; $j++) {
                                        if ($j <= 5) {
                                            echo ' <a class="page-link ';
                                            if ($j == 1) {
                                                echo ' Selected ';
                                            }
                                            echo '" id="' . $j . '" ';
                                            echo ' href="">' . $j . '</a>';
                                        }
                                        if ($j == 5) {
                                            echo ' <span >...</span>';
                                        }
                                    }
                                    ?>
                                    <a id="<?php echo $pages; ?>" class="page-link" href="">آخرین صفحه</a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>

                <div class="col-md-3 hidden-xs">
                    <div class="Categorize">
                        <div class="header">
                            <div class="title">
                                <span>دسته بندی ها</span>
                            </div>
                        </div>
                        <div class="header-line"></div>
                        <ul class="category-list" id="category-list">
                            <?php
                            foreach ($subgroups1 as $sb) {
                                echo '<li class="sgdesktop" id="' . $sb->SubGroupId . '"><a class="pointer"><i class="fa fa-angle-double-left"></i>';
                                echo $sb->Name;
                                echo '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function () {

            $(".gallery_category").on("click", function () {
                var categoryid = $(this).attr("id");

                $.ajax({
                    url: 'AjaxCategoryLoad.php',
                    type: 'post',
                    data: {
                        category_item_id: categoryid,
                        category_item_type: "desktop"
                    },
                    success: function (response) {
                        $('#category-list').html(response);

//                        $('html,body').animate({
//                                scrollTop: $(".Products").offset().top
//                            },
//                            'slow');
                        $("#wait").css("display", "block");
                        $.ajax({
                            url: 'AjaxSearch/AjaxAdvancedSearch.php',
                            type: 'POST',
                            data: {
                                page: "1",
                                group_id : categoryid
                            },
                            success: function (result) {
                                $("#wait").css("display", "none");
                                $("#products").html(result);
                            },
                            error: function (result) {
                                alert("لطفا دوباره امتحان کنید!");
                            }
                        });

                    },
                });

            });

            $(".gallery_category_mob").on("click", function () {
                var categoryid = $(this).attr("id");

                $.ajax({
                    url: 'AjaxCategoryLoad.php',
                    type: 'post',
                    data: {
                        category_item_id: categoryid,
                        category_item_type: "mobile",
                    },
                    success: function (response) {
                        $('#category-list2').html(response);

//                        $('html,body').animate({
//                                scrollTop: $(".Products").offset().top
//                            },
//                            'slow');
                        $("#wait").css("display", "block");
                        $.ajax({
                            url: 'AjaxSearch/AjaxAdvancedSearch.php',
                            type: 'POST',
                            data: {
                                page: "1",
                                group_id : categoryid
                            },
                            success: function (result) {
                                $("#wait").css("display", "none");
                                $("#products").html(result);
                            },
                            error: function (result) {
                                alert("لطفا دوباره امتحان کنید!");
                            }
                        });

                    },
                });

            });


            $(".sgdesktop").on("click", function () {
                var sgid = $(this).attr("id");

//                $('html,body').animate({
//                        scrollTop: $(".Products").offset().top
//                    },
//                    'slow');
                $("#wait").css("display", "block");
                $.ajax({
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    type: 'POST',
                    data: {
                        page: "1",
                        sub_group : sgid
                    },
                    success: function (result) {
                        $("#wait").css("display", "none");
                        $("#products").html(result);
                    },
                    error: function (result) {
                        alert("لطفا دوباره امتحان کنید!");
                    }
                });

            });

            $(".sgdesktop").on("click", function () {
                var sgid = $(this).attr("id");

//                $('html,body').animate({
//                        scrollTop: $(".Products").offset().top
//                    },
//                    'slow');
                $("#wait").css("display", "block");
                $.ajax({
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    type: 'POST',
                    data: {
                        page: "1",
                        sub_group : sgid
                    },
                    success: function (result) {
                        $("#wait").css("display", "none");
                        $("#products").html(result);
                    },
                    error: function (result) {
                        alert("لطفا دوباره امتحان کنید!");
                    }
                });

            });

            $(".sgmobile").on("click", function () {
                var sgid = $(this).attr("id");

//                $('html,body').animate({
//                        scrollTop: $(".Products").offset().top
//                    },
//                    'slow');
                $("#wait").css("display", "block");
                $.ajax({
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    type: 'POST',
                    data: {
                        page: "1",
                        sub_group : sgid
                    },
                    success: function (result) {
                        $("#wait").css("display", "none");
                        $("#products").html(result);
                    },
                    error: function (result) {
                        alert("لطفا دوباره امتحان کنید!");
                    }
                });

            });


        });
    </script>
    <script>
        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $(document).ready(function () {

            $(".compare-btn-link").click(function () {
                $("#success-compare").fadeOut(250);
                $("#error-compare").fadeOut(250);
                var ID = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: 'AddToCompare.php',
                    data: {id: ID},
                    success: function (data) {
                        $('#div').html(data);
                    }
                });
            });


            $(".page-link").click(function (e) {
                $('html,body').animate({
                        scrollTop: $(".Products").offset().top
                    },
                    'slow');
                $("#wait").css("display", "block");
                e.preventDefault();
                $.ajax({
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    type: 'POST',
                    data: {
                        page: $(this).attr('id'), <?php
                        if (isset($_GET['tid'])) {
                            echo "supper_groups : '$TitleSupperGroups'";
                        } elseif (isset($_GET['sbgroup'])) {
                            echo "sub_group :  " . $_GET['sbgroup'];
                        } elseif (isset($_GET['spgroup'])) {
                            echo "supper_group :  " . $_GET['spgroup'];
                        } elseif (isset($_GET['brand'])) {
                            echo "brand : " . $_GET['brand'];
                        } elseif (isset($_GET['special_offers'])) {
                            echo 'special_offers : 1';
                        } elseif (isset($_GET['search_box'])) {
                            echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                        }
                        ?>
                    },
                    success: function (result) {
                        $("#wait").css("display", "none");
                        $("#products").html(result);
                    },
                    error: function (result) {
                        alert("لطفا دوباره امتحان کنید!");
                    }
                });
            });
            $('#search_box2').on('input', function () {
                $("#wait").css("display", "block");
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/AjaxAdvancedSearch.php',
                        data: {
                            search_box: $('#search_box2').val(),
                            <?php
                            if (isset($_GET['tid'])) {
                                echo "supper_groups : '$TitleSupperGroups'";
                            } elseif (isset($_GET['sbgroup'])) {
                                echo "sub_group :  " . $_GET['sbgroup'];
                            } elseif (isset($_GET['spgroup'])) {
                                echo "supper_group :  " . $_GET['spgroup'];
                            } elseif (isset($_GET['brand'])) {
                                echo "brand : " . $_GET['brand'];
                            } elseif (isset($_GET['special_offers'])) {
                                echo 'special_offers : 1';
                            } elseif (isset($_GET['search_box'])) {
                                echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                            }
                            ?>
                        },
                        success: function (data) {
                            $("#wait").css("display", "none");
                            $('#products').html(data);
                        }

                    });
                }, 1000);
            });


        });
    </script>
<?php
include_once "Template/bottom.php";
    