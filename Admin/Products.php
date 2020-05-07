<!DOCTYPE html>
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
$productcolor = new ProductColor();
//$product = new Product();


$pds = new ProductDataSource();
$pds->open();
$products = $pds->Fill();
$pds->close();
//----------Remove Empty Folder And Empty Record----
//$emptyProducts = $product->FindEmptyProducts();
//$product2 = new Product();
//foreach ($emptyProducts as $ep) {
//    $product2->ProductId = $ep;
//    $ep2 = $product2->FindOneProduct2();
//    if ($ep2->User + (3600 * 12) <= time()) {
//        $product2->Delete();
//        $product2->DeleteFolder("../Images/$ep");
//    }
//}
//-------------------------Cookies---------------
session_start();
$_SESSION[SESSION_STRING_GROUP_CK] = "";
$_SESSION[SESSION_STRING_SUB_GROUP_CK] = "";
$_SESSION[SESSION_STRING_SUPPER_GROUP_CK] = "";
$_SESSION[SESSION_STRING_ORDER_CK] = " ProductId ";
$_SESSION[SESSION_STRING_ORDER_TYPE_CK] = " DESC ";
$_SESSION[SESSION_STRING_SEARCH_KEY_CK] = "";
$_SESSION[SESSION_INT_CURRENT_PAGE] = 1;
$_SESSION[SESSION_STRING_ENTRY] = 30;
$_SESSION[SESSION_STRING_SPECIAL_OFFER] = "";

if (isset($_SESSION[SESSION_YES_NO_USER_LOGGED_IN]) == FALSE) {
    $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "NO";
}
if ($_SESSION[SESSION_YES_NO_USER_LOGGED_IN] == "NO" || !isset($_COOKIE[COOKIE_MY_USER_ID])) {
    header('location:../Index.php');
}
?>
<?php
include_once 'Template/top3.php';
if ($role->Products != 1) {
    header('Location:Index.php');
    die();
}
?>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<?php
include_once 'Template/menu.php';
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>محصولات</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Products</h2>
    </div>
</div>


<div class="modal inmodal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">


        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>منو</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <div class="row">
                        <form id="search_form" class="search_form">
                            <div class="orders2">
                                <select id="group" name="group" class="form-control m-b">
                                    <option value="0">مجموعه...</option>
                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
                                    $gds = new GroupDataSource();
                                    $gds->open();
                                    $groups = $gds->Fill();
                                    $gds->close();
                                    if ($role->ProductGroupLimit == 1) {
                                        foreach ($groups as $gp) {
                                            if (strpos($role->AllowedProductGroups, $gp->GroupId) != false) {
                                                if (strpos($role->AllowedProductGroups, $gp->GroupId) != false) {
                                                    echo '<option value="' . $gp->GroupId . '" >';
                                                    echo $gp->Name;
                                                    echo '</option>';
                                                }
                                            }
                                        }
                                    } else {
                                        foreach ($groups as $gp) {
                                            echo '<option value="' . $gp->GroupId . '" >';
                                            echo $gp->Name;
                                            echo '</option>';
                                        }
                                    }


                                    ?>
                                </select>
                                <span id="subgroup-td">
                    <select id="subgroup" name="subgroup" class="form-control m-b" disabled>
                        <option>زیر مجموعه...</option>
                    </select>
                </span>
                                <span id="suppergroup-td">
                    <select id="subgroup" name="subgroup" class="form-control m-b" disabled>
                        <option>زیر زیر مجموعه...</option>
                    </select>
                </span>
                            </div>
                            <div class="orders">
                                <!--<span>بر اساس</span>-->
                                <select id="order" class="form-control m-b">
                                    <option value=" ProductId ">جدید ترین</option>
                                    <option value=" Sells ">پرفروش ترین</option>
                                    <option value=" Visits ">پربازدید ترین</option>
                                    <option value=" Name ">نام</option>
                                    <option value=" Price ">قیمت</option>
                                    <option value=" Quantity ">موجودی</option>
                                    <!--                                    <option value=" SO DESC , ProductId ">پیشنهاد ویژه</option>-->
                                </select>
                                <select id="ordertype" class="form-control m-b">
                                    <option value=" DESC ">نزولی</option>
                                    <option value=" ASC ">صعودی</option>
                                </select>
                            </div>
                            <div class="orders">
                                <select id="entry" class="form-control m-b">
                                    <option value="5">5 تا</option>
                                    <option value="20">20 تا</option>
                                    <option value="30" selected>30 تا</option>
                                    <option value="50">50 تا</option>
                                    <option value="100">100 تا</option>
                                    <option value="all">همه</option>
                                </select>
                                <label class="entry-lbl hidden-xs">نمایش</label>
                            </div>

                            <div class="database-search">
                                <input class="form-control" type="text" name="search_box" id="search_box"
                                       placeholder="جستجو..."
                                       title="جستجو بر اساس نام محصول، نام لاتین محصول، برند محصول و شناسه محصول"
                                       value=""/>
                                <!--<input type="submit" id="search_btn" value="جستجو" />-->
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <form id="special_form" class="special_form" style="text-align: center">
                            <div class="orders">
                                <select id="specialoffer_title" class="form-control m-b" style="max-width: 500px">
                                    <option value="">بدون انتخاب...</option>
                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SpecialOfferTitleDataSource.inc';
                                    $stds = new SpecialOfferTitleDataSource();
                                    $stds->open();
                                    $specialoffertitle = $stds->Fill();
                                    $stds->close();
                                    foreach ($specialoffertitle as $st) {
                                        echo '<option value="' . $st->SpecialOfferTitleId . '"';
                                        echo '>';
                                        echo $st->Title;
                                        echo '</option>';
                                    }
                                    ?>
                                </select>
                                <label class="entry-lbl" style="width: 110px;padding-right: 10px;">پیشنهادات
                                    ویژه</label>
                            </div>
                        </form>
                    </div>
                    <div class="clear-fix"></div>


                    <?php
                    if ($role->DeleteProduct == 1 || $role->EditProduct == 1) {
                        ?>
                        <div class="row">
                            <div class="select-options">
                                <div class="hr-line-dashed"></div>
                                <div class="col-md-12">
                                    <?php
                                    if ($role->DeleteProduct == 1) {
                                        ?>
                                        <div class="col-md-4">
                                            <a href="#" id='delete-btn'>
                                                <button type="button" class="btn btn-w-m btn-danger" data-toggle="modal"
                                                        data-target="#deleteModal">حذف موارد انتخاب شده
                                                </button>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($role->EditProduct == 1) {
                                    ?>
                                    <div class="col-md-4">
                                        <a href="#" id='sort-btn'>
                                            <button type="button" class="btn btn-w-m btn-warning" data-toggle="modal"
                                                    data-target="#sortModal">تغییر دسته بندی
                                            </button>
                                        </a>
                                    </div>
                                    <?php
                                    if ($role->ProductApprove == 0) {
                                        ?>
                                        <div class="col-md-4">
                                            <a href="#" id='status-btn'>
                                                <button type="button" class="btn btn-w-m btn-warning"
                                                        data-toggle="modal" data-target="#statusModal">تغییر وضعیت
                                                </button>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <a href="#" id='discount-btn'>
                                            <button type="button" class="btn btn-w-m btn-info" data-toggle="modal"
                                                    data-target="#discountModal">گذاشتن تخفیف
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="#" id='coupon-btn'>
                                            <button type="button" class="btn btn-w-m btn-primary" data-toggle="modal"
                                                    data-target="#couponModal">افزودن کپن
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="#" id='specialoffer-btn'>
                                            <button type="button" class="btn btn-w-m btn-success" data-toggle="modal"
                                                    data-target="#specialofferModal">پیشنهاد ویژه
                                            </button>
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="clear-fix"></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="clear-fix"></div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست محصولات</h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php
                    if ($role->InsertProduct == 1) {
                        ?>
                        <a href="ProductInsertingPrepration.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن محصول جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                           placeholder="جستجو در لیست موجود در این صفحه">

                    <div id="db" name="db">
                        <div class="Database">
                            <div class="db-cover" id="wait">
                    <span class="loading-title <?php
                    if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                        echo " SBackground'";
                    } else {
                        echo " GBackground'";
                    }
                    ?>">Loading...</span>
                                <img class="loading-gif" src="Template/Images/gifs/giphy (3).gif" alt=""/>
                            </div>
                            <form id="products-form">
                                <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user" name="user"/>

                                <div class="modal inmodal fade" id="deleteModal" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span><span
                                                            class="sr-only">Close</span></button>
                                                <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>اخطار
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="body">آیا میخواهید این موارد را حذف کنید ؟</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">خیر
                                                </button>
                                                <button type="button" id="delete-confirm-btn" class="btn btn-primary"
                                                        data-dismiss="modal">بله
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal inmodal fade" id="sortModal" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span><span
                                                            class="sr-only">Close</span></button>
                                                <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>انتقال
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="body">دسته بندی مورد نظر را انتخاب کنید :</div>
                                                <div>
                                                    <select id="group2" name="group2" class="form-control m-b"
                                                            style="padding: 0;">
                                                        <option value="0" id="group-s" name='group-s'>مجموعه...</option>
                                                        <?php
                                                        if ($role->ProductGroupLimit) {
                                                            foreach ($groups as $gp) {
                                                                if (strpos($role->AllowedProductGroups, $gp->GroupId) != false) {
                                                                    echo '<option value="' . $gp->GroupId . '" >';
                                                                    echo $gp->Name;
                                                                    echo '</option>';
                                                                }
                                                            }
                                                        } else {
                                                            foreach ($groups as $gp) {
                                                                echo '<option value="' . $gp->GroupId . '" >';
                                                                echo $gp->Name;
                                                                echo '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="subgroup-td2">
                                <select id="subgroup2" name="subgroup2" class="form-control m-b" disabled
                                        style="padding: 0;">
                                    <option>زیر مجموعه...</option>
                                </select>
                            </span>
                                                    <span id="suppergroup-td2">
                                <select id="suppergroup2" name="suppergroup2" class="form-control m-b" disabled>
                                    <option>زیر زیر مجموعه...</option>
                                </select>
                            </span>
                                                </div>
                                                <div class="alert alert-warning">
                                                    توجه! تغییر "مجموعه" منجر به پاک شدن ویژگی محصولات میشود!
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                                                </button>
                                                <button type="button" id="sort-confirm-btn" class="btn btn-primary"
                                                        data-dismiss="modal">انتقال
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal inmodal fade" id="statusModal" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span><span
                                                            class="sr-only">Close</span></button>
                                                <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>وضعیت
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="body">وضعیت را انتخاب کنید :</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                                                </button>
                                                <button type="button" id="activate-confirm-btn" class="btn btn-primary"
                                                        data-dismiss="modal" style="float: left">فعال
                                                </button>
                                                <button type="button" id="deactivate-confirm-btn" class="btn btn-danger"
                                                        data-dismiss="modal" style="float: left">غیرفعال
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal inmodal fade" id="specialofferModal" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span><span
                                                            class="sr-only">Close</span></button>
                                                <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>پیشنهاد
                                                    ویژه</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="body">حالت مورد نظر و دسته بندی را انتخاب کنید :</div>
                                                <select id="specialoffers" name="specialoffers"
                                                        class="form-control m-b" style="padding: 0;margin-top: 10px">
                                                    <option value="">انتخاب کنید...</option>
                                                    <?php
                                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SpecialOfferTitleDataSource.inc';
                                                    $stds = new SpecialOfferTitleDataSource();
                                                    $stds->open();
                                                    $specialoffertitle = $stds->Fill();
                                                    $stds->close();
                                                    foreach ($specialoffertitle as $st) {
                                                        echo '<option value="' . $st->SpecialOfferTitleId . '"';
                                                        if (isset($_SESSION[SESSION_STRING_SPECIAL_OFFER]) && $_SESSION[SESSION_STRING_SPECIAL_OFFER] == $st->SpecialOfferTitleId) {
                                                            echo ' selected ';
                                                        }
                                                        echo '>';
                                                        echo $st->Title;
                                                        echo '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                                                </button>
                                                <button type="button" id="add-confirm-btn" class="btn btn-primary"
                                                        data-dismiss="modal" style="float: left">افزودن به پیشنهادات
                                                    ویژه
                                                </button>
                                                <button type="button" id="remove-confirm-btn" class="btn btn-danger"
                                                        data-dismiss="modal" style="float: left">حذف از پیشنهادات ویژه
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal inmodal fade" id="discountModal" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span><span
                                                            class="sr-only">Close</span></button>
                                                <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>تخفیف
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="body">درصد تخفیف :</div>
                                                <input type="number" class="form-control input-sm m-b-xs" id="discount"
                                                       name="discount" placeholder="چند درصد...؟"/>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                                                </button>
                                                <button type="button" id="discount-confirm-btn" class="btn btn-primary"
                                                        data-dismiss="modal">تمام
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal inmodal fade" id="couponModal" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span><span
                                                            class="sr-only">Close</span></button>
                                                <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>کپن
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="body">تعداد کپن :</div>
                                                <input type="number" id="coupon" name="coupon"
                                                       placeholder="چند کپن به تعداد کپن فعلی محصولات اضافه شود...؟"
                                                       class="form-control input-sm m-b-xs"/>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                                                </button>
                                                <button type="button" id="coupon-confirm-btn" class="btn btn-primary"
                                                        data-dismiss="modal">تمام
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <input type="hidden" id="action" name="action" value="none"/>
                                </div>
                                <style>
                                    .checkboxFour input, .checkboxFour2 input {
                                        font-size: 0;
                                    }

                                    .checkboxFour, .checkboxFour2, .checkbox-circle {
                                        z-index: 1;

                                        /*width: 30px;*/
                                        /*height: 30px;*/

                                        /*background: #ddd;*/
                                        /*border-radius: 100%;*/
                                        float: right;
                                        top: -5px;
                                        right: 0;
                                        position: relative;
                                    }

                                    .checkboxFour label, .checkboxFour2 label {
                                        display: block;
                                        width: 26px;
                                        height: 26px;
                                        border-radius: 100px;

                                        transition: all .5s ease;
                                        cursor: pointer;
                                        position: absolute;
                                        top: 2px;
                                        left: 2px;
                                        z-index: 999;

                                        background: #333;
                                    }

                                    .checkboxFour input[type=checkbox]:checked + label, .checkboxFour2 input[type=checkbox]:checked + label {
                                        background: #26ca28;
                                    }
                                </style>
                                <div class="add-btn">
                                    <a href="ProductInsertingPrepration.php"><img src="Template/Images/Add.png"/></a>

                                </div>

                                <div class="ScrollViewDiv">
                                    <table class="footable table table-stripped" data-page-size="1000000000"
                                           data-filter=#filter>
                                        <thead>
                                        <tr>
                                            <th data-sort-ignore="true">شناسه
                                                <div class='checkbox checkbox-info checkbox-circle'
                                                     style='margin-right : 5px;'><input
                                                            type='checkbox'
                                                            value='checkall'
                                                            id='checkall'
                                                            name='checkall'/><label
                                                            for='checkall'></label></div>
                                            </th>
                                            <th data-hide="phone,tablet">تصویر</th>
                                            <th>عنوان</th>
                                            <th data-hide="phone,tablet">تعداد</th>
                                            <th data-hide="phone,tablet">بازدید</th>
                                            <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                            <th data-hide="phone,tablet" id="th1" data-sort-ignore="true"></th>
                                            <!--                                            --><?php
                                            //                                            if ($role->DeleteProduct == 1 || $role->EditProduct == 1) {
                                            //                                                ?>
                                            <!--                                                <th data-hide="phone,tablet" id="th2" data-sort-ignore="true"></th>-->
                                            <!--                                                --><?php
                                            //                                            }
                                            //                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!--                                        <script src="../Template/Scripts/jquery-3.1.1.js"-->
                                        <!--                                                type="text/javascript"></script>-->
                                        <?php
                                        $i = 0;
                                        $j = $_SESSION[SESSION_STRING_ENTRY];
                                        foreach ($products as $p1) {
                                            $i++;
                                        }
                                        $pages = ceil($i / $j);
                                        $pp2 = 1;
                                        $postsCounter = 0;
                                        $counter2 = 0;
                                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/UI/WidgetBuilder.php';
                                        if ($role->ProductGroupLimit) {
                                            foreach ($products as $p) {
                                                if (strpos($role->AllowedProductGroups, $p->Group->GroupId) != false && strpos($role->AllowedProductSubGroups, $p->SubGroup->SubGroupId) != false && strpos($role->AllowedProductSupperGroups, $p->SupperGroup->SupperGroupId) != false) {
                                                    if ((1 * $_SESSION[SESSION_STRING_ENTRY]) - ($_SESSION[SESSION_STRING_ENTRY] - 1) <= $pp2 && $pp2 <= 1 * $_SESSION[SESSION_STRING_ENTRY]) {
                                                        $counter2++;
                                                        // WidgetBuilder::createProductTableRowDetailViewAdmin($p);
//                                            $price = new Price();
////                                        $menu = new Menu();
//                                            $guarantee = new Guarantee();
//                                            $protocol = new Protocol();
//                                            $pcolor = new ProductColor();
//                                            $pprotocol = $protocol->GetProtocolsForOneProduct($p->ProductId);
//                                            $pguarantee = $guarantee->GetGuaranteesForOneProduct($p->ProductId);
//                                            $ppcolor = $pcolor->GetProductColorsForOneProduct($p->ProductId);
//                                        $pmenu = $menu->GetMenusForOneProduct($p->ProductId);
                                                        ?>
                                                        <div class="product-info"
                                                             id="p-info<?php echo $p->ProductId; ?>">
                                                        </div>
                                                        <?php
                                                        $postsCounter++;

                                                        WidgetBuilder::createProductTableRowDetailViewAdmin($p, $role);


                                                    }
                                                    $pp2++;
                                                }
                                            }
                                        } else {
                                            foreach ($products as $p) {
                                                if ((1 * $_SESSION[SESSION_STRING_ENTRY]) - ($_SESSION[SESSION_STRING_ENTRY] - 1) <= $pp2 && $pp2 <= 1 * $_SESSION[SESSION_STRING_ENTRY]) {

//                                        $price = new Price();
////                                    $menu = new Menu();
//                                        $prds = new ProtocolDataSource();
//                                        $prds->open();
//                                        $pprotocol = $prds->GetProtocolsForOneProduct($p->ProductId);
//                                        $prds->close();
//
//
//                                        $grds = new GuaranteeDataSource();
//                                        $grds->open();
//                                        $pguarantee = $grds->GetGuaranteesForOneProduct($p->ProductId);
//                                        $grds->close();
//
//                                        $pcds = new ProductColorDataSource();
//                                        $pcds->open();
//                                        $ppcolor = $pcds->GetProductColorsForOneProduct($p->ProductId);
//                                        $pcds->close();
////                                    $pmenu = $menu->GetMenusForOneProduct($p->ProductId);
                                                    ?>
                                                    <div class="product-info" id="p-info<?php echo $p->ProductId; ?>">
                                                    </div>
                                                    <?php
                                                    $postsCounter++;


                                                    WidgetBuilder::createProductTableRowDetailViewAdmin($p, $role);


                                                }
                                                $pp2++;
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <!--                                        <tfoot>-->
                                        <!--                                        <tr>-->
                                        <!--                                            <td colspan="5">-->
                                        <!--                                                <ul class="pagination pull-right"></ul>-->
                                        <!--                                            </td>-->
                                        <!--                                        </tr>-->
                                        <!--                                        </tfoot>-->
                                    </table>
                                </div>
                            </form>
                        </div>
                        <?php
                        if ($pages != 1) { ?>
                            <div class="Pager">
                                <a class="page-link btn btn-success" id="1" href="">صفحه اول</a>
                                <?php
                                $s = 1;
                                for ($j = 1; $j <= $pages; $j++) {
                                    if ($j <= 5) {
                                        echo ' <a class="page-link ';
                                        if ($j == 1) {
                                            echo ' btn btn-warning ';
                                        } else {
                                            echo ' btn btn-success ';
                                        }
                                        echo '" id="' . $j . '" ';
                                        echo ' href="">' . $j . '</a>';
                                    }
                                    if ($j == 5) {
                                        echo ' <span >...</span>';
                                    }
                                }
                                ?>
                                <a id="<?php echo $pages; ?>" class="page-link btn btn-success" href="">آخرین صفحه</a>
                            </div>
                            <div class="clear-fix"></div>
                            <?php
                        }
                        if ($role->ProductGroupLimit) {
                            ?>
                            <div class="RecordsCounter">Access : <?php echo $counter2; ?></div>
                            <?php
                        } else {
                            $pds = new ProductDataSource();
                            $pds->open();
                            ?>
                            <div class="RecordsCounter">Total : <?php echo $pds->TotalPosts(); ?></div>
                            <?php
                            $pds->close();
                        }
                        ?>
                    </div>


                    <div class="modal inmodal fade" id="quantityModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                                class="sr-only">Close</span></button>
                                    <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>تغییر موجودی
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="body">رنگ و تعداد را وارد کنید :</div>
                                    <input type="hidden" id="quantityContent" value="">
                                    <input type="hidden" id="quantityId" value="">
                                    <select id="color" name="color" class="form-control m-b" style="font-size: 12px;">
                                        <?php
                                        $clds = new ColorListDataSource();
                                        $clds->open();
                                        $colorlists = $clds->Fill2();
                                        $clds->close();

                                        foreach ($colorlists as $c) {
                                            echo "<option value='$c->ColorListId' >$c->Name</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="number" id="quantity" name="quantity"
                                           placeholder="تعداد موجود در انبار...؟"
                                           class="form-control input-sm m-b-xs"/>

                                    <div class="quantity_product">
                                        <div class="col-sm-12" id="colorSamples">

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">بستن</button>
                                    <button type="button" id="quantity-add-btn" class="btn btn-primary"
                                            data-dismiss="modal">ثبت
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal inmodal fade" id="priceModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                                class="sr-only">Close</span></button>
                                    <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>قیمت</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="body">قیمت را وارد کنید :</div>
                                    <input type="hidden" id="priceId" value="">
                                    <input type="number" id="priceval" name="priceval"
                                           placeholder="قیمت به تومان...؟"
                                           class="form-control input-sm m-b-xs"/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">بستن</button>
                                    <button type="button" id="price-add-btn" class="btn btn-primary"
                                            data-dismiss="modal">ثبت
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--                    <div class="confirm-message2" id="price-pop">-->
                    <!--                        <div class="title"><img src="Template/Images/warning2.png"/><span>قیمت</span></div>-->
                    <!--                        <div class="body">قیمت را وارد کنید :</div>-->
                    <!--                        <input type="hidden" id="priceId" value="">-->
                    <!--                        <input type="number" id="priceval" name="priceval"-->
                    <!--                               placeholder="قیمت به تومان...؟"/>-->
                    <!---->
                    <!--                        <div class="buttons">-->
                    <!--                            <input type="button" class="cancel-btn" value="بستن"/>-->
                    <!--                            <input type="button" id="price-add-btn" value="ثبت"/>-->
                    <!--                        </div>-->
                    <!--                    </div>-->

                </div>
            </div>
        </div>
    </div>

</div>


<script>
    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();
    $(document).ready(function () {
        var timeoutID = null;

        function findMember(str) {
            console.log('search: ' + str);
        }

        $(".product-id3").click(function () {
//            $("#wait").fadeIn(0);
            var productId = $(this).val();
            $.ajax({
                url: 'ProductInfo.php',
                type: 'POST',
                data: {productId: productId},
                success: function (result) {
                    $("#modal-content").html(result);
                }
            });
        });

        $(".quantity").click(function () {
            var productId = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'AjaxLoadColor.php',
                data: {product:productId },
                success: function (data) {
                    $('#colorSamples').html(data);
                }
            });

            $('#quantityId').attr('value', $(this).attr('id'));
            $('#quantityContent').attr('value', $(this).val());
            $("#quantity-pop").fadeIn(250);
            $("#modalback").fadeIn(250);
        });

        $(".product-price").click(function () {
            $('#priceId').attr('value', $(this).attr('id'));
            $("#price-pop").fadeIn(250);
            $("#modalback").fadeIn(250);

        });
        $("#modalback").click(function () {
            $("#p-info").fadeOut(250);
            $("#quantity-pop").fadeOut(250);
            $("#price-pop").fadeOut(250);
            $("#delete-confirm-message").fadeOut(250);
            $("#status-confirm-message").fadeOut(250);
            $("#specialoffer-confirm-message").fadeOut(250);
            $("#sort-confirm-message").fadeOut(250);
            $("#coupon-confirm-message").fadeOut(250);
            $("#discount-confirm-message").fadeOut(250);
            $("#modalback").fadeOut(500);
        });


        $('#search_box').keyup(function () {
            $("#wait").fadeIn(0);
            delay(function () {
                $.ajax({
                    type: 'POST',
                    url: 'ajaxSearch.php',
                    data: $('#search_form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                    }
                });
            }, 1000);
        });

        $("#delete-confirm-btn").click(function () {
            $("#modalback").fadeOut(500);
            $("#delete-confirm-message").fadeOut(500);
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'multiSelect.php',
                data: $('#products-form').serialize(),
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                    $('.select-options').slideUp(500);
                }
            });
        });

        $("#quantity-add-btn").click(function () {
            $("#modalback").fadeOut(500);
            $("#quantity-pop").fadeOut(500);
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'In-tableUpdate.php',
                data: {
                    color: $('#color').val(),
                    quantity: $('#quantity').val(),
                    quantityContent: $('#quantityContent').val(),
                    quantityId: $('#quantityId').val()
                },
                success: function (result) {
                    $.ajax({
                        type: 'POST',
                        url: 'ajaxSearch.php',
                        data: {},
                        success: function (result) {
                            $("#db").html(result);
                            $("#wait").fadeOut(0);
                        }
                    });
                }
            });

        });

        $("#price-add-btn").click(function () {
            $("#modalback").fadeOut(500);
            $("#price-pop").fadeOut(500);
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'In-tableUpdate.php',
                data: {price: $('#priceval').val(), priceId: $('#priceId').val()},
                success: function (result) {
                    $("#wait").fadeOut(0);
                }
            });
            $.ajax({
                type: 'POST',
                url: 'ajaxSearch.php',
                data: {},
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                }
            });
        });

        $("#discount-confirm-btn").click(function () {
            $("#modalback").fadeOut(500);
            $("#discount-confirm-message").fadeOut(500);
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'multiSelect.php',
                data: $('#products-form').serialize(),
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                    $('.select-options').slideUp(500);

                }
            });
        });

        $("#coupon-confirm-btn").click(function () {
            $("#modalback").fadeOut(500);
            $("#coupon-confirm-message").fadeOut(500);
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'multiSelect.php',
                data: $('#products-form').serialize(),
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                    $('.select-options').slideUp(500);

                }
            });
        });

        $("#sort-confirm-btn").click(function () {
            $("#modalback").fadeOut(500);
            $("#sort-confirm-message").fadeOut(500);
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'multiSelect.php',
                data: $('#products-form').serialize(),
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                    $('.select-options').slideUp(500);

                }
            });
        });

        $("#deactivate-confirm-btn").click(function () {
            $('#action').attr('value', 'status-deactivate');
            $("#modalback").fadeOut(500);
            $("#status-confirm-message").fadeOut(500);
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'multiSelect.php',
                data: $('#products-form').serialize(),
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                    $('.select-options').slideUp(500);

                }
            });
        });

        $("#activate-confirm-btn").click(function () {
            $('#action').attr('value', 'status-activate');
            $("#modalback").fadeOut(500);
            $("#status-confirm-message").fadeOut(500);
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'multiSelect.php',
                data: $('#products-form').serialize(),
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                    $('.select-options').slideUp(500);

                }
            });
        });

        $("#add-confirm-btn").click(function () {
            $('#action').attr('value', 'add-specialoffer');
            $("#modalback").fadeOut(500);
            $("#specialoffer-confirm-message").fadeOut(500);
            $("#wait").fadeIn(0);
            var special_offer = $("#specialoffers").val();
            if (special_offer == "") {
                alert("لطفا یکی از گزینه ها را انتخاب نمایید!");
                $("#wait").fadeOut(0);
            } else {
                $.ajax({
                    type: 'POST',
                    url: 'multiSelect.php',
                    data: $('#products-form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                        $('.select-options').slideUp(500);

                    }
                });
            }
        });

        $("#remove-confirm-btn").click(function () {
            $('#action').attr('value', 'remove-specialoffer');
            $("#modalback").fadeOut(500);
            $("#specialoffer-confirm-message").fadeOut(500);
            $("#wait").fadeIn(0);
            var special_offer = $("#specialoffers").val();
            if (special_offer == "") {
                alert("لطفا یکی از گزینه ها را انتخاب نمایید!");
                $("#wait").fadeOut(0);
            } else {
                $.ajax({
                    type: 'POST',
                    url: 'multiSelect.php',
                    data: $('#products-form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                        $('.select-options').slideUp(500);

                    }
                });
            }
        });


        $(".page-link").click(function (e) {
            $("#wait").fadeIn(0);
            e.preventDefault();
            $.ajax({
                url: 'ajaxPager.php',
                type: 'POST',
                data: {
                    page: $(this).attr('id')
                },
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                },
                error: function (result) {
                    alert("لطفا دوباره امتحان کنید!");
                }
            });
        });
        $(".cancel-btn").click(function () {
            $("#delete-confirm-message").fadeOut(250);
            $("#status-confirm-message").fadeOut(250);
            $("#quantity-pop").fadeOut(250);
            $("#price-pop").fadeOut(250);
            $("#sort-confirm-message").fadeOut(250);
            $("#coupon-confirm-message").fadeOut(250);
            $("#specialoffer-confirm-message").fadeOut(250);
            $("#discount-confirm-message").fadeOut(250);
            $("#modalback").fadeOut(500);
            $('#group-s').attr('value', '0');
            $('#subgroup-td').html("<select id = 'subgroup2' name = 'subgroup2' class='form-control m-b' disabled style='padding: 0;'><option> زیر زیر مجموعه... </option></select>");
            $('#subgroup-td').html("<select id = 'suppergroup2' name = 'suppergroup2' class='form-control m-b' disabled style='padding: 0;'><option> زیر مجموعه... </option></select>");
            $('#discount').attr('value', '');
            $('#coupon').attr('value', '');
        });
        $("#delete-btn").click(function () {
            $('#action').attr('value', 'delete');
            $("#delete-confirm-message").fadeIn(250);
            $("#modalback").fadeIn(250);
        });
        $("#status-btn").click(function () {
            $('#action').attr('value', 'status');
            $("#status-confirm-message").fadeIn(250);
            $("#modalback").fadeIn(250);
        });
        $("#specialoffer-btn").click(function () {
            $('#action').attr('value', 'specialoffer');
            $("#specialoffer-confirm-message").fadeIn(250);
            $("#modalback").fadeIn(250);
        });
        $("#sort-btn").click(function () {
            $('#action').attr('value', 'sort');
            $("#sort-confirm-message").fadeIn(250);
            $("#modalback").fadeIn(250);
        });
        $("#coupon-btn").click(function () {
            $('#action').attr('value', 'coupon');
            $("#coupon-confirm-message").fadeIn(250);
            $("#modalback").fadeIn(250);
        });
        $("#discount-btn").click(function () {
            $('#action').attr('value', 'discount');
            $("#discount-confirm-message").fadeIn(250);
            $("#modalback").fadeIn(250);
        });

        $('#checkall').change(function () {
            if ($(this).is(':checked')) {
                $('.acheck').prop('checked', true);
                $('.select-options').slideDown(500);
            }
            else {
                $('.acheck').prop('checked', false);
                $('.select-options').slideUp(500);
            }
        });

        $('.acheck').change(function () {
            $('.select-options').slideDown(500);
            if ($('.acheck').is(':checked')) {
            }
            else {
                $('.select-options').slideUp(500);
            }
        });

        $("#order").change(function (e) {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(findMember.bind(undefined, e.target.value), 500);
            $("#wait").fadeIn(0);
            var order = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'ajaxSearch.php',
                data: {order: order},
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                }
            });
        });

        $("#specialoffer_title").change(function (e) {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(findMember.bind(undefined, e.target.value), 500);
            $("#wait").fadeIn(0);
            var special_offer = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'ajaxSearch.php',
                data: {special_offer: special_offer},
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                }
            });
        });

        $("#entry").change(function (e) {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(findMember.bind(undefined, e.target.value), 500);
            $("#wait").fadeIn(0);
            var entry = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'AjaxUpdateEntry.php',
                data: {entry: entry},
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                }
            });
        });
        $("#ordertype").change(function (e) {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(findMember.bind(undefined, e.target.value), 500);
            $("#wait").fadeIn(0);
            var ordertype = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'ajaxSearch.php',
                data: {ordertype: ordertype},
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                }
            });
        });
        $("#group").change(function (e) {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(findMember.bind(undefined, e.target.value), 500);
            $("#wait").fadeIn(0);
            var group = $(this).val();
            var subgroup = '';
            var suppergroup = '';
            $.ajax({
                type: 'POST',
                url: 'RefreshSubgroups4.php',
                data: {group: group},
                success: function (data) {
                    $('#subgroup-td').html(data);
                    $('#suppergroup').html("<option value='0' >زیر زیر مجموعه ...</option>");
                }
            });
            $.ajax({
                type: 'POST',
                url: 'ajaxSearch.php',
                data: {group: group, subgroup: subgroup, suppergroup: suppergroup},
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                }
            });
        });

        $("#group2").change(function (e) {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(findMember.bind(undefined, e.target.value), 500);
            var group = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'RefreshSubgroups3.php',
                data: {group: group},
                success: function (data) {
                    $('#subgroup-td2').html(data);
                }
            });
        });
    });
</script>
<?php
include_once 'Template/bottom.php';
