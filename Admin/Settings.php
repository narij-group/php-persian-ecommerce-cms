<?php
require_once 'Template/top.php';
include_once 'fileman/system.inc.php';
include_once 'fileman/php/functions.inc.php';
?>

<script src="fileman/js/main.js" type="text/javascript"></script>

<link href="fileman/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css"/>
<link href="fileman/css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<script>
    function openCustomRoxy2() {
        $('#roxyCustomPanel2').dialog({modal: true, width: 875, height: 600});
    }

    function openCustomRoxy3() {
        $('#roxyCustomPanel3').dialog({modal: true, width: 875, height: 600});
    }

    function openCustomRoxy4() {
        $('#roxyCustomPanel4').dialog({modal: true, width: 875, height: 600});
    }

    function openCustomRoxy5() {
        $('#roxyCustomPanel5').dialog({modal: true, width: 875, height: 600});
    }

    function closeCustomRoxy2() {
//        $('#roxyCustomPanel2').dialog('close');
//        $('#roxyCustomPanel3').dialog('close');
//        $('#roxyCustomPanel4').dialog('close');
//        $('#roxyCustomPanel5').dialog('close');
        $('#closeModal1').click(function(){return true;}).click();
        $('#closeModal2').click(function(){return true;}).click();
        $('#closeModal3').click(function(){return true;}).click();
    }

    function closeCustomRoxy3() {
//        $('#roxyCustomPanel2').dialog('close');
//        $('#roxyCustomPanel3').dialog('close');
//        $('#roxyCustomPanel4').dialog('close');
//        $('#roxyCustomPanel5').dialog('close');
        $('#closeModal1').click(function(){return true;}).click();
        $('#closeModal2').click(function(){return true;}).click();
        $('#closeModal3').click(function(){return true;}).click();
    }

    function closeCustomRoxy4() {
//        $('#roxyCustomPanel2').dialog('close');
//        $('#roxyCustomPanel3').dialog('close');
//        $('#roxyCustomPanel4').dialog('close');
//        $('#roxyCustomPanel5').dialog('close');
        $('#closeModal1').click(function(){return true;}).click();
        $('#closeModal2').click(function(){return true;}).click();
        $('#closeModal3').click(function(){return true;}).click();
    }

    function closeCustomRoxy5() {
//        $('#roxyCustomPanel2').dialog('close');
//        $('#roxyCustomPanel3').dialog('close');
//        $('#roxyCustomPanel4').dialog('close');
//        $('#roxyCustomPanel5').dialog('close');
        $('#closeModal1').click(function(){return true;}).click();
        $('#closeModal2').click(function(){return true;}).click();
        $('#closeModal3').click(function(){return true;}).click();
    }

</script>
<link rel="stylesheet" href="jquery.switchButton.css">
<link rel="stylesheet" href="main.css">
<?php
include_once 'Template/menu.php';
if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
    $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/Logo/";
} else {
    $_SESSION[SESSION_PATH_KEY] = "Logo/";
}

if (trim($settings->MenuCustomButtonImage) == "") {
    $settings->MenuCustomButtonImage = "جهت انتخاب تصویر اینجا را کلیک کنید...";
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>تنظیمات</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Settings</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <div class="settingsContent">
                        <form action="ApplySettings.php" method="POST">
                                                        <div class="language">
                                                            <div class="slider demo" id="slider-2">
                                                                <input id="language" name="language" <?php
                                                                if ($settings->Language == "FA") {
                                                                    echo "checked";
                                                                }
                                                                ?> type="checkbox" value="1">
                                                            </div>
                                                        </div>
                            <?php
                            if ($role->ColorSettings == 1) {
                                ?>
                                <a href="Colors.php">
                                    <?php
                                    if ($settings->Language == "EN") {
//                                        echo 'Color Settings';
                                        echo '<button class="btn btn-info btn-w-m" type="button"><i
                                            class="fa fa-map"></i>Color Settings</button>';
                                    } else {
//                                        echo 'رنگ  بندی سایت';
                                        echo '<button class="btn btn-info btn-w-m" type="button"><i
                                            class="fa fa-delicious"></i>رنگ  بندی سایت</button>';
                                    }
                                    ?>
                                </a>
                                <?php
                            }
                            if ($role->MenuSettings == 1) {
                                ?>
                                <a href="SelectMenus.php">
                                    <?php
                                    if ($settings->Language == "EN") {
                                        echo '<button class="btn btn-warning btn-w-m" type="button"><i
                                            class="fa fa-th-list"></i>Menu Settings</button>';
//                                        echo 'Menu Settings';
                                    } else {
                                        echo '<button class="btn btn-warning btn-w-m" type="button"><i
                                            class="fa fa-th-list"></i>منو های سایت</button>';
//                                        echo 'منو های سایت';
                                    }
                                    ?>
                                </a>
                                <?php
                            }
                            if ($role->ProductProperties == 1) {
                                ?>
                                <a href="AdvancedSearch.php">
                                    <?php
                                    if ($settings->Language == "EN") {
                                        echo '<button class="btn btn-primary btn-w-m" type="button"><i
                                            class="fa fa-search"></i>Advanced Search</button>';
//                                        echo 'Advanced Search';
                                    } else {
                                        echo '<button class="btn btn-primary btn-w-m" type="button"><i
                                            class="fa fa-search"></i>جستجوی پیشرفته</button>';
//                                        echo 'جستجوی پیشرفته';
                                    }
                                    ?>
                                </a>
                                <?php
                            }
                            ?>
                            <div class="alert alert-warning">
                                تمامی لینک ها باید با //:http وارد شوند!
                            </div>
                            <!------------------------TITLE--------------------------->
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    Admin Panel
                                </div>
                                <div class="panel-body">
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام مالک سایت :
                                            </label>
                                            <div class="col-sm-12">
                                                <input id="owner" name="owner" value="<?php echo $settings->Owner; ?>"
                                                       maxlength="18"
                                                       class="form-control input-sm m-b-xs"
                                                       type="text"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام سایت :
                                            </label>
                                            <div class="col-sm-12">
                                                <input id="sitename" name="sitename"
                                                       value="<?php echo $settings->SiteName; ?>"
                                                       class="form-control input-sm m-b-xs"
                                                       type="text"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <!------------------------TITLE--------------------------->
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    Tax
                                </div>
                                <div class="panel-body">
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                مالیات <?php echo "( " . $settings->Tax . "% )"; ?>:
                                            </label>
                                            <div class="col-sm-12">
                                                <input id="tax" name="tax" type="number" min="0" value="<?php
                                                if ($settings->Tax != 0) {
                                                    echo $settings->Tax;
                                                }
                                                ?>" placeholder="چند درصد ...؟ "
                                                       class="form-control input-sm m-b-xs"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <!------------------------TITLE--------------------------->
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    Coupons
                                </div>
                                <div class="panel-body">
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                ارزش
                                                هرکپن <?php echo "( " . number_format($settings->Coupon) . " تومان )"; ?>
                                                :
                                            </label>
                                            <div class="col-sm-12">
                                                <input id="coupon" name="coupon" type="number" min="0" value="<?php
                                                if ($settings->Coupon != 0) {
                                                    echo $settings->Coupon;
                                                }
                                                ?>" placeholder="قیمت به تومان... "
                                                       class="form-control input-sm m-b-xs"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                مدت زمان ارزش
                                                هرکپن <?php echo "( " . number_format($settings->CouponExpire) . " روز )"; ?>
                                                :
                                            </label>
                                            <div class="col-sm-12">
                                                <input id="couponexpire" name="couponexpire" type="number" min="0"
                                                       value="<?php
                                                       if ($settings->CouponExpire != 0) {
                                                           echo $settings->CouponExpire;
                                                       }
                                                       ?>" placeholder="چند روز ...؟ "
                                                       class="form-control input-sm m-b-xs"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                حداکثر تعداد مجاز استفاده از کپن در هر خرید :
                                            </label>
                                            <div class="col-sm-12">
                                                <input id="maxcoupon" name="maxcoupon" type="number" min="0"
                                                       value="<?php
                                                       if ($settings->MaxCoupon != 0) {
                                                           echo $settings->MaxCoupon;
                                                       }
                                                       ?>" placeholder="چند تا ...؟"
                                                       class="form-control input-sm m-b-xs"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                حداکثر درصد مجاز تخفیف برای هر
                                                محصول<?php echo "( " . number_format($settings->MaxCouponPercentage) . "% )"; ?>
                                                :
                                            </label>
                                            <div class="col-sm-12">
                                                <input id="maxpercent" name="maxpercent" type="number" min="0"
                                                       value="<?php
                                                       if ($settings->MaxCouponPercentage != 0) {
                                                           echo $settings->MaxCouponPercentage;
                                                       }
                                                       ?>" placeholder="چند درصد ...؟ "
                                                       class="form-control input-sm m-b-xs"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Logos
                        </div>
                        <div class="panel-body">
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        لوگو سایت(png.) :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="plogo" name="plogo" dir="rtl" value="<?php echo $settings->PLogo; ?>"
                                               type="text"
                                               readonly="readonly" style="cursor: pointer;"
                                               data-toggle='modal' data-target='#filemanModal1'
                                               class="form-control input-sm m-b-xs"/>

                                        <div class="modal inmodal fade" id="filemanModal1" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" id="closeModal1"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title"><i class="fa fa-photo text-primary m-xs"></i>انتخاب تصویر</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe src="fileman/index.html?integration=custom&type=files&txtFieldId=plogo"
                                                                style="width:100%;height:100%" frameborder="0">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        لوگو سایت(ico.) :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="ilogo" name="ilogo" dir="rtl" value="<?php echo $settings->ILogo; ?>"
                                               type="text"
                                               readonly="readonly" style="cursor: pointer;"
                                               data-toggle='modal' data-target='#filemanModal2'
                                               class="form-control input-sm m-b-xs"/>

                                        <div class="modal inmodal fade" id="filemanModal2" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" id="closeModal2"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title"><i class="fa fa-photo text-primary m-xs"></i>انتخاب تصویر</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe src="fileman/index.html?integration=custom&type=files&txtFieldId=ilogo"
                                                                style="width:100%;height:100%" frameborder="0">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            E-Namad
                        </div>
                        <div class="panel-body">
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        نماد الکترونیک :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="enamadlink" dir="ltr" name="enamadlink" placeholder="Paste Here..."
                                               value="<?php echo $settings->ENamadLink; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Free Shipping
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-warning">
                                0 (صفر) به معنای غیرفعال می باشد
                            </div>
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        ارسال رایگان بالای (<?php
                                        if ($settings->FreeShipping == 0) {
                                            echo 'غیرفعال';
                                        } else {
                                            echo number_format($settings->FreeShipping) . ' تومان';
                                        }
                                        ?>) :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="freeshipping" name="freeshipping" type="number" min="0" value="<?php
                                        if ($settings->FreeShipping != 0) {
                                            echo $settings->FreeShipping;
                                        }
                                        ?>" placeholder="قیمت به تومان... "
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Mailing
                        </div>
                        <div class="panel-body">
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        پست الکترونیک سایت (Webmail) :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="email" dir="ltr" name="email" value="<?php echo $settings->Email; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        رمز عبور پست الکترونیک سایت :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="password" dir="ltr" name="password"
                                               value="<?php echo $settings->Password; ?>"
                                               type="password"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        آدرس سرور SMTP :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="smtp" dir="ltr" name="smtp" value="<?php echo $settings->SMTP; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        پورت SMTP :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="smtpport" dir="ltr" name="smtpport"
                                               value="<?php echo $settings->SMTPPort; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Menu Custom Item
                        </div>
                        <div class="panel-body">
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        نام :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="custombtnname" name="custombtnname"
                                               value="<?php echo $settings->MenuCustomButtonName; ?>" type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        لینک :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="custombtnlink" name="custombtnlink"
                                               value="<?php echo $settings->MenuCustomButtonLink; ?>" type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        تصویر :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="custombtnimage" dir="rtl" name="custombtnimage"
                                               value="<?php echo $settings->MenuCustomButtonImage; ?>" type="text"
                                               readonly="readonly" style="cursor: pointer;"
                                               data-toggle='modal' data-target='#filemanModal3'
                                               class="form-control input-sm m-b-xs"/>

                                        <div class="modal inmodal fade" id="filemanModal3" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" id="closeModal3"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title"><i class="fa fa-photo text-primary m-xs"></i>انتخاب تصویر</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe src="fileman/index.html?integration=custom&type=files&txtFieldId=custombtnimage"
                                                                style="width:100%;height:100%" frameborder="0">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Link Boxes & Footer
                        </div>
                        <div class="panel-body">
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        سال تاسیس (میلادی) :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="cdate" name="cdate" value="<?php echo $settings->CreationDate; ?>"
                                               type="number"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        شماره تلفن (های) تماس :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="numbers" name="numbers" value="<?php echo $settings->Numbers; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        لینک صفحه فیس بوک :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="facebook" dir="ltr" name="facebook"
                                               value="<?php echo $settings->Facebook; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        لینک صفحه توییتر :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="twitter" dir="ltr" name="twitter"
                                               value="<?php echo $settings->Twitter; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        لینک کانال تلگرام :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="telegram" dir="ltr" name="telegram"
                                               value="<?php echo $settings->Telegram; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        لینک صفحه اینستاگرام :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="instagram" dir="ltr" name="instagram"
                                               value="<?php echo $settings->Instagram; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        درباره سایت :
                                    </label>
                                    <div class="col-sm-12">
                                        <textarea id="aboutSite"
                                                  name="aboutSite"
                                                  class="form-control input-sm m-b-xs"><?php echo $settings->AboutSite; ?></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            SEO - Home Page
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-warning">
                                کلمات کلیدی را با استفاده از " , " جدا کنید!
                            </div>
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        نویسنده :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="metaa" name="metaa" value="<?php echo $settings->MetaAuthor; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        کلمات کلیدی :
                                    </label>
                                    <div class="col-sm-12">
                                        <input id="metak" name="metak" value="<?php echo $settings->MetaKeywords; ?>"
                                               type="text"
                                               class="form-control input-sm m-b-xs"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">
                                        توضیحات متا :
                                    </label>
                                    <div class="col-sm-12">
                                        <textarea id="metad"
                                                  name="metad"
                                                  class="form-control input-sm m-b-xs"><?php echo $settings->MetaDescription; ?></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Customers Notifications
                        </div>
                        <div class="panel-body">
                            <div style="width: 100%; text-align: center; font-size: 15px;">
                                <div class="checkbox checkbox-success checkbox-inline">
                                    <input type="checkbox" <?php
                                    if ($settings->isEmail == 1) {
                                        echo ' checked ';
                                    }
                                    ?> id="isEmail" name="isEmail"/>
                                    <label for="isEmail"> ارسال ایمیل به مشتری </label>
                                </div>
                                <div class="checkbox checkbox-success checkbox-inline">
                                    <input type="checkbox" <?php
                                    if ($settings->SMS == 1) {
                                        echo ' checked ';
                                    }
                                    ?> id="SMS" name="SMS"/>
                                    <label for="SMS"> ارسال اس ام اس به مشتری </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------TITLE--------------------------->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Cart
                        </div>
                        <div class="panel-body">
                            <div style="width: 100%; text-align: center; font-size: 15px;">
                                <div class="checkbox checkbox-success checkbox-inline">
                                    <input type="checkbox" <?php
                                    if ($settings->AskQuantityForAdding == 1) {
                                        echo ' checked ';
                                    }
                                    ?> id="AskQuantityForAdding" name="AskQuantityForAdding"/>
                                    <label for="AskQuantityForAdding"> امکان انتخاب تعداد محصول هنگام افزودن به
                                        سبد خرید </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--                            <input type="submit" value="SAVE"/>-->
                    <button class="btn btn-primary btn-w-m" type="submit" style="width: 100%"><i
                                class="fa fa-check"></i><strong>تایید</strong></button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
</div>

<style>
    .checkboxFour input, .checkboxFour2 input {
        font-size: 0;
    }

    .checkboxFour, .checkboxFour2 {
        z-index: 1;

        width: 25px;
        height: 25px;
        padding-top: 5px;
        padding-right: 5px;

        background: #ddd;
        border-radius: 100%;
        float: right;
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
        top: 0;
        left: 0;
        z-index: 999;

        background: #333;
    }

    .checkboxFour input[type=checkbox]:checked + label, .checkboxFour2 input[type=checkbox]:checked + label {
        background: #26ca28;
    }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="jquery.switchButton.js"></script>

<script>
    $(function () {

        $("#slider-2.demo input").switchButton({
            width: 45,
            height: 25,
            button_width: 25,
            on_label: 'FA',
            off_label: 'EN'
        });
    })
</script>

<?php
include_once 'Template/bottom.php';