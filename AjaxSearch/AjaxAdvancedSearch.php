<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Globals/Sessions.php';

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


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductAndPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SearchDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';
//$search = new Search();
$pap = new ProductAndProperty();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$products = array();
session_start();
if (isset($_POST['page'])) {
    $_SESSION[SESSION_INT_CURRENT_PAGE] = $_POST['page'];
}
if (isset($_POST['order'])) {
    $_SESSION[SESSION_STRING_ORDER] = $_POST['order'];
}
if (isset($_POST['ordertype'])) {
    $_SESSION[SESSION_STRING_ASC_DESC_ORDER_TYPE] = $_POST['ordertype'];
}
if (isset($_POST['Price'])) {
    $_SESSION[SESSION_INT_PRICE_HOLDER] = $_POST['Price'];
}
if (isset($_POST['checked_box'])) {
    $_SESSION[SESSION_STRING_CHECKED_BOX] = $_POST['checked_box'];
}
if (isset($_POST['search_box'])) {
    $_SESSION[SESSION_STRING_SEARCH_BOX] = $_POST['search_box'];
}
$query = "";
if (trim($_SESSION[SESSION_STRING_SEARCH_BOX]) != "") {
    $s = $_SESSION[SESSION_STRING_SEARCH_BOX];
    if (!isset($_POST['whole_search_box'])) {
        $query = "AND (products.LatinName LIKE  '%$s%' || products.Name LIKE  '%$s%' || logos.Name LIKE  '%$s%' || logos.LatinName LIKE  '%$s%' ||  products.ProductId = '$s' ||  products.Keywords LIKE '%$s%') ";
    } else {
        $s2 = $_POST['whole_search_box'];
        $query = "AND ((products.LatinName LIKE  '%$s%' || products.Name LIKE  '%$s%' || logos.Name LIKE  '%$s%' || logos.LatinName LIKE  '%$s%' ||  products.ProductId = '$s' ||  products.Keywords LIKE '%$s%') AND (products.LatinName LIKE  '%$s2%' || products.Name LIKE  '%$s2%' || logos.Name LIKE  '%$s2%' || logos.LatinName LIKE  '%$s2%' ||  products.ProductId = '$s2' ||  products.Keywords LIKE '%$s2%')) ";
    }
}
if (trim($_SESSION[SESSION_INT_PRICE_HOLDER]) != "") {
    $searchQuery = explode("-", $_SESSION[SESSION_INT_PRICE_HOLDER]);
    $i = 0;
    foreach ($searchQuery as $s) {
        $s = str_replace(",", "", $s);
        $s = str_replace("تومان", "", $s);
        $s = (int)trim($s);
        $prices[$i] = $s;
        $i++;
    }
    $query .= " AND ((SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) >= $prices[0] && (SELECT prices.Value FROM prices WHERE prices.Product = products.ProductId ORDER BY PriceId DESC LIMIT 1 ) <= $prices[1] ) ";
}
if (trim($_SESSION[SESSION_STRING_CHECKED_BOX]) != "") {

    $options = explode(",", $_SESSION[SESSION_STRING_CHECKED_BOX]);

    //==============BRAND==============//
    $and = "not ok";
    foreach ($options as $s) {
        if (strpos($s, 'brand-') !== false) {
            $and = 'ok';
        }
    }
    if ($and == 'ok') {
        $query .= " AND (";
    }
    $i = 0;
    foreach ($options as $s) {
        if (strpos($s, 'brand-') !== false) {
            $s2 = str_replace('brand-', "", $s);
            if ($i != 0) {
                $query .= " || ";
            }
            $query .= " products.Brand = " . $s2;
            $i++;
        }
    }
    if ($and == 'ok') {
        $query .= " )";
    }

    //==============COLOR==============//
    $and = "not ok";
    foreach ($options as $s) {
        if (strpos($s, 'color-') !== false) {
            $and = 'ok';
        }
    }
    if ($and == 'ok') {
        $query .= " AND (";
    }
    $i = 0;
    foreach ($options as $s) {
        if (strpos($s, 'color-') !== false) {
            $s2 = str_replace('color-', "", $s);
            if ($i != 0) {
                $query .= " || ";
            }
            $query .= " IFNULL((Select Color from productcolors where Product = products.ProductId AND Color=$s2),0) != 0 ";
            $i++;
        }
    }
    if ($and == 'ok') {
        $query .= " )";
    }


    //==============Product Properties==============//
    $and = "not ok";
    $dont = false;
    sort($options);
    foreach ($options as $s) {
        if (strpos($s, 'property-') !== false) {
            $and = 'ok';
        }
    }
    if ($and == 'ok') {
        $query .= " AND (";
    }
    $i = 0;
    $propertyholder = 0;
    foreach ($options as $s) {
        if (strpos($s, 'property-') !== false) {
            $s2 = str_replace('property-', "", $s);
            $items = explode('-', $s2);
            if ($propertyholder != 0 && $propertyholder != $items[0]) {
                $dont = true;
                $query .= ") AND (";
            }
            if ($i != 0 && ($propertyholder == 0 || $propertyholder == $items[0])) {
                $query .= " || ";
            }
            $query .= " IFNULL((Select ProductAndPropertyId from productandproperties where Product = products.ProductId AND productandproperties.ProductProperty=$items[0] AND productandproperties.Value = '$items[1]'),0) != 0 ";
            if ($propertyholder != 0 && $propertyholder != $items[0] && $dont == false) {
                $query .= ")";
            }
            $propertyholder = $items[0];
            $i++;
        }
    }
    if ($and == 'ok') {
        $query .= " )";
    }
}
if (isset($_POST['supper_groups'])) {
    $TEMP = explode(',', $_POST['supper_groups']);
    $query .= ' AND (';
    foreach ($TEMP as $item) {
        if ($item != '') {
            $query .= " SupperGroupId = $item";
            if ($item != end($TEMP)) {
                $query .= ' OR ';
            }
        }
    }
    $query .= ' )';
}

if (isset($_POST['group_id'])) {
    $query .= ' AND (groups.GroupId = ' . $_POST['group_id'] . ')';
}
if (isset($_POST['sub_group'])) {
    $query .= ' AND (subgroups.SubGroupId = ' . $_POST['sub_group'] . ')';
}
if (isset($_POST['supper_group'])) {
    $query .= ' AND (suppergroups.SupperGroupId = ' . $_POST['supper_group'] . ')';
}
if (isset($_POST['brand'])) {
    $query .= ' AND (logos.LogoId = ' . $_POST['brand'] . ')';
}
if (isset($_POST['special_offers'])) {
    $query .= ' AND (SELECT specialoffers.Product FROM specialoffers WHERE specialoffers.Product = products.ProductId AND specialoffers.SpecialOfferTitle = ' . $_POST['special_offers'] .  ' ORDER BY SpecialOfferId DESC LIMIT 1)';
}
if (isset($_POST['whole_search_box']) && trim($_SESSION[SESSION_STRING_SEARCH_BOX]) == "") {
    $s = $_POST['whole_search_box'];
    $query = "AND (products.LatinName LIKE  '%$s%' || products.Name LIKE  '%$s%' || logos.Name LIKE  '%$s%' || logos.LatinName LIKE  '%$s%' ||  products.ProductId = '$s' ||  products.Keywords LIKE '%$s%') ";
}


$product = new ProductDataSource();
$product->open();
$products = $product->CAdvancedFill($query, $_SESSION[SESSION_STRING_ORDER], $_SESSION[SESSION_STRING_ASC_DESC_ORDER_TYPE]);
$product->close();


$opinion = new OpinionDataSource();
$opinion->open();

?>
<div class="db-cover5" id="wait">
    <span class="loading-title"></span>
    <img class="loading-gif" src="Template/Images/loading.gif" alt=""/>
</div>
<div class="row">
    <div class="TBL">
        <?php
        $i = 0;
        $j = 30;
        foreach ($products as $p1) {
            $i++;
        }
        $pages = ceil($i / $j);
        $pp2 = 1;
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/UI/WidgetBuilder.php';
        if (count($products) != 0) {
            foreach ($products as $p1) {

//                WidgetBuilder::createProductThumbWidget($p1);
//                $_GET['PRODUCT'] = serialize($p1);
//                include '../Widgets/ProductThumb.widget';

                //TODO START
//                $discount = new DiscountDataSource();
//                $discount->open();
//                $last_discount = $discount->GetLastDiscountForOneProduct($p1->ProductId);
//                $discount->close();
//                $price = new PriceDataSource();
//                $price->open();
//                $last_price = $price->GetLastPriceForOneProduct($p1->ProductId);
//                $price->close();


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
        } else {
            ?>
            <div class="search-error-p">
                <?php
                if (isset($_POST['group_id']) || isset($_POST['supper_groups']) || isset($_POST['sub_group']) || isset($_POST['supper_group']) || isset($_POST['brand']) || isset($_POST['special_offers']) || $_SESSION[SESSION_STRING_SEARCH_BOX] != "" || $_SESSION[SESSION_STRING_CHECKED_BOX] != "") {
                    ?>
                    <div>متاسفانه موردی بین <b>محصولات این دسته بندی</b> پیدا نشد.</div>
                    <?php
                } else {
                    ?>
                    <div>متاسفانه موردی بین محصولات پیدا نشد.</div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php
if ($pages != 1 && $products != null) {
    ?>
    <div class="Pager">
        <a class="page-link" id="1" href="">صفحه اول</a>
        <?php
        $s = 1;
        if ($_SESSION[SESSION_INT_CURRENT_PAGE] > 3) {
            for ($j = $_SESSION[SESSION_INT_CURRENT_PAGE] - 30; $j <= $pages; $j++) {
                if ($j <= $_SESSION[SESSION_INT_CURRENT_PAGE] + 30 && $j > 0) {
                    echo ' <a href="" id="' . $j . '"  class="page-link  ';
                    if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE]) {
                        echo ' Selected "';
                    } else {
                        echo '"';
                    }
                    echo 'page=' . $j . ' " >' . $j . '</a>';
                } else {

                }
                if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE] + 3) {
                    echo ' <span >...</span>';
                }
            }
        } else {
            for ($j = 1; $j <= $pages; $j++) {
                if ($j <= 5) {
                    echo ' <a id="' . $j . '"  class="page-link  ';
                    if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE]) {
                        echo ' Selected "';
                    } else {
                        echo '"';
                    }
                    echo ' href="">' . $j . '</a>';
                }
                if ($j == 5) {
                    echo ' <span >...</span>';
                }
            }
        }
        ?>
        <a id="<?php echo $pages; ?>" class="page-link" href="">آخرین صفحه</a>
    </div>
    <?php
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("img").unveil();
    });
</script>
<script>
    function addComma(str) {
        var objRegex = new RegExp('(-?[0-9]+)([0-9]{3})');
        while (objRegex.test(str)) {
            str = str.replace(objRegex, '$1,$2');
        }
        return str;
    }
</script>
<script>
    $(document).ready(function () {

        $(".product-view-btn").click(function () {
            $("#purchase-box", $(this).parent().parent()).fadeIn(500);
        });

        $(".btn-cancle").click(function () {
            $("#purchase-box", $(this).parent().parent().parent()).fadeOut(250);
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
            if (val < max) {
                val++;
            }
            var totalval = addComma(parseFloat(realval) * parseInt(val) + "000");
            $("#txtcount", $(this).parent()).prop('value', val);
            $("#price-box #total_price", $(this).parent().parent()).prop('value', totalval);

        });

        $(".btn-down").click(function () {
            var val = $("#txtcount", $(this).parent()).val();
            var realval = $("#price-box #real_price", $(this).parent().parent()).val();
            if (val > 1) {
                val--;
                var totalval = addComma(parseFloat(realval) * parseInt(val) + "000");
                $("#txtcount", $(this).parent()).prop('value', val);
                $("#price-box #total_price", $(this).parent().parent()).prop('value', totalval);
            }
        });


        $("#lower-value").bind("DOMSubtreeModified", function () {
            $("#wait").css("display", "block");
            delay(function () {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    data: {
                        Price: $("#lower-value").text() + '-' + $("#upper-value").text(), <?php
                        if (isset($_POST['group_id'])) {
                            echo "group_id :  " . $_POST['group_id'];
                        } elseif (isset($_POST['supper_groups'])) {
                            echo "supper_groups : " . $_POST['supper_groups'];
                        } elseif (isset($_POST['sub_group'])) {
                            echo "sub_group :  " . $_POST['sub_group'];
                        } elseif (isset($_POST['supper_group'])) {
                            echo "supper_group :  " . $_POST['supper_group'];
                        } elseif (isset($_POST['brand'])) {
                            echo "brand : " . $_POST['brand'];
                        } elseif (isset($_POST['special_offers'])) {
                            echo "special_offers :  " . $_POST['special_offers'];
                        } elseif (isset($_POST['whole_search_box'])) {
                            echo "whole_search_box  : '" . $_POST['whole_search_box'] . "'";
                        }
                        ?> },
                    success: function (data) {
                        $("#wait").css("display", "none");
                        $('#products').html(data);
                    }
                });
            }, 1000);
        });
        $("#upper-value").bind("DOMSubtreeModified", function () {
            $("#wait").css("display", "block");
            delay(function () {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    data: {
                        Price: $("#lower-value").text() + '-' + $("#upper-value").text(), <?php
                        if (isset($_POST['group_id'])) {
                            echo "group_id :  " . $_POST['group_id'];
                        } elseif (isset($_POST['supper_groups'])) {
                            echo "supper_groups : " . $_POST['supper_groups'];
                        } elseif (isset($_POST['sub_group'])) {
                            echo "sub_group :  " . $_POST['sub_group'];
                        } elseif (isset($_POST['supper_group'])) {
                            echo "supper_group :  " . $_POST['supper_group'];
                        } elseif (isset($_POST['brand'])) {
                            echo "brand : " . $_POST['brand'];
                        } elseif (isset($_POST['special_offers'])) {
                            echo "special_offers :  " . $_POST['special_offers'];
                        } elseif (isset($_POST['whole_search_box'])) {
                            echo "whole_search_box  : '" . $_POST['whole_search_box'] . "'";
                        }
                        ?> },
                    success: function (data) {
                        $("#wait").css("display", "none");
                        $('#products').html(data);
                    }
                });
            }, 1000);

        });
        var values = "";
        $(".checkboxCheck").change(function () {
            $("#wait").css("display", "block");
            if ($(this).is(":checked")) {
                values += $(this).attr('value') + ",";
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    data: {
                        checked_box: values, <?php
                        if (isset($_POST['group_id'])) {
                            echo "group_id :  " . $_POST['group_id'];
                        } elseif (isset($_POST['supper_groups'])) {
                            echo "supper_groups : " . $_POST['supper_groups'];
                        } elseif (isset($_POST['sub_group'])) {
                            echo "sub_group :  " . $_POST['sub_group'];
                        } elseif (isset($_POST['supper_group'])) {
                            echo "supper_group :  " . $_POST['supper_group'];
                        } elseif (isset($_POST['brand'])) {
                            echo "brand : " . $_POST['brand'];
                        } elseif (isset($_POST['special_offers'])) {
                            echo "special_offers :  " . $_POST['special_offers'];
                        } elseif (isset($_POST['whole_search_box'])) {
                            echo "whole_search_box  : '" . $_POST['whole_search_box'] . "'";
                        }
                        ?> },
                    success: function (data) {
                        $("#wait").css("display", "none");
                        $('#products').html(data);
                    }
                });
            }
            else {
                values = values.replace($(this).attr('value') + ',', '');
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    data: {
                        checked_box: values, <?php
                        if (isset($_POST['group_id'])) {
                            echo "group_id :  " . $_POST['group_id'];
                        } elseif (isset($_POST['supper_groups'])) {
                            echo "supper_groups : " . $_POST['supper_groups'];
                        } elseif (isset($_POST['sub_group'])) {
                            echo "sub_group :  " . $_POST['sub_group'];
                        } elseif (isset($_POST['supper_group'])) {
                            echo "supper_group :  " . $_POST['supper_group'];
                        } elseif (isset($_POST['brand'])) {
                            echo "brand : " . $_POST['brand'];
                        } elseif (isset($_POST['special_offers'])) {
                            echo "special_offers :  " . $_POST['special_offers'];
                        } elseif (isset($_POST['whole_search_box'])) {
                            echo "whole_search_box  : '" . $_POST['whole_search_box'] . "'";
                        }
                        ?> },
                    success: function (data) {
                        $("#wait").css("display", "none");
                        $('#products').html(data);
                    }
                });
            }
        });
        $("#Order1").change(function () {
            var order = $(this).val();
            $("#wait").css("display", "block");
            delay(function () {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    data: {
                        order: order, <?php
                        if (isset($_POST['group_id'])) {
                            echo "group_id :  " . $_POST['group_id'];
                        } elseif (isset($_POST['supper_groups'])) {
                            echo "supper_groups : " . $_POST['supper_groups'];
                        } elseif (isset($_POST['sub_group'])) {
                            echo "sub_group :  " . $_POST['sub_group'];
                        } elseif (isset($_POST['supper_group'])) {
                            echo "supper_group :  " . $_POST['supper_group'];
                        } elseif (isset($_POST['brand'])) {
                            echo "brand : " . $_POST['brand'];
                        } elseif (isset($_POST['special_offers'])) {
                            echo "special_offers :  " . $_POST['special_offers'];
                        } elseif (isset($_POST['whole_search_box'])) {
                            echo "whole_search_box  : '" . $_POST['whole_search_box'] . "'";
                        }
                        ?> },
                    success: function (data) {
                        $("#wait").css("display", "none");
                        $('#products').html(data);
                    }
                });
            }, 1000);
        });
        $("#Order2").change(function () {
            var order = $(this).val();
            $("#wait").css("display", "block");
            delay(function () {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    data: {
                        ordertype: order, <?php
                        if (isset($_POST['group_id'])) {
                            echo "group_id :  " . $_POST['group_id'];
                        } elseif (isset($_POST['supper_groups'])) {
                            echo "supper_groups : " . $_POST['supper_groups'];
                        } elseif (isset($_POST['sub_group'])) {
                            echo "sub_group :  " . $_POST['sub_group'];
                        } elseif (isset($_POST['supper_group'])) {
                            echo "supper_group :  " . $_POST['supper_group'];
                        } elseif (isset($_POST['brand'])) {
                            echo "brand : " . $_POST['brand'];
                        } elseif (isset($_POST['special_offers'])) {
                            echo "special_offers :  " . $_POST['special_offers'];
                        } elseif (isset($_POST['whole_search_box'])) {
                            echo "whole_search_box  : '" . $_POST['whole_search_box'] . "'";
                        }
                        ?> },
                    success: function (data) {
                        $("#wait").css("display", "none");
                        $('#products').html(data);
                    }
                });
            }, 1000);
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
                        if (isset($_POST['group_id'])) {
                            echo "group_id :  " . $_POST['group_id'];
                        } elseif (isset($_POST['supper_groups'])) {
                            echo "supper_groups : " . $_POST['supper_groups'];
                        } elseif (isset($_POST['sub_group'])) {
                            echo "sub_group :  " . $_POST['sub_group'];
                        } elseif (isset($_POST['supper_group'])) {
                            echo "supper_group :  " . $_POST['supper_group'];
                        } elseif (isset($_POST['brand'])) {
                            echo "brand : " . $_POST['brand'];
                        } elseif (isset($_POST['special_offers'])) {
                            echo "special_offers :  " . $_POST['special_offers'];
                        } elseif (isset($_POST['whole_search_box'])) {
                            echo "whole_search_box  : '" . $_POST['whole_search_box'] . "'";
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
                    if (isset($_POST['group_id'])) {
                        echo "group_id :  " . $_POST['group_id'];
                    } elseif (isset($_POST['supper_groups'])) {
                        echo "supper_groups : " . $_POST['supper_groups'];
                    } elseif (isset($_POST['sub_group'])) {
                        echo "sub_group :  " . $_POST['sub_group'];
                    } elseif (isset($_POST['supper_group'])) {
                        echo "supper_group :  " . $_POST['supper_group'];
                    } elseif (isset($_POST['brand'])) {
                        echo "brand : " . $_POST['brand'];
                    } elseif (isset($_POST['special_offers'])) {
                        echo "special_offers :  " . $_POST['special_offers'];
                    } elseif (isset($_POST['whole_search_box'])) {
                        echo "whole_search_box  : '" . $_POST['whole_search_box'] . "'";
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
    });
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
</script>