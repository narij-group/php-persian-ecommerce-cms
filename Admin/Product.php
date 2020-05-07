<!DOCTYPE html>
<?php
include_once 'Template/top.php';
$SelectedGroup = 0;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LogoDataSource.inc';
$lds = new LogoDataSource();
$lds->open();
$logos = $lds->Fill();
$lds->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
$gds = new GroupDataSource();
$gds->open();
$groups = $gds->Fill();
$gds->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';
$clds = new ColorListDataSource();
$clds->open();
$colors = $clds->Fill();
$clds->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeListDataSource.inc';
$glds = new GuaranteeListDataSource();
$glds->open();
$guarantees = $glds->Fill();
$glds->close();

$cm = "add";

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$product = new Product();
if (isset($_GET['id'])) {
    if ($role->EditProduct != 1) {
        header('Location:Index.php');
        die();
    }
    $cm = "edit";

    $pds = new ProductDataSource();
    $pds->open();
    $product = $pds->FindOneProductBasedOnId($_GET['id']);
    $pds->close();
} else {
    if ($role->InsertProduct != 1) {
        header('Location:Index.php');
        die();
    }
}
?>
<?php
include_once 'fileman/system.inc.php';
include_once 'fileman/php/functions.inc.php';
?>

<link href="fileman/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css"/>
<link href="fileman/css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">


<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<!--<script src="Scripts/jquery-1.10.2.min.js" type="text/javascript"></script>-->
<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script language="JavaScript" src="AjaxSelect/myminiAJAX.js"></script>
<script language="JavaScript" src="AjaxSelect/functionsjq.js"></script>
<!--<script language="JavaScript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>-->
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script>
    function openCustomRoxy2() {
//        $('#roxyCustomPanel2').dialog({modal: true, width: 875, height: 600});
    }

    function closeCustomRoxy2() {
        $("#wait").css("display", "block");
        $.ajax({
            type: 'POST',
            url: 'RefreshImage.php',
            data: {Image: $('#image').val()},
            success: function (data) {
//                $("#Filemanager2").fadeOut(250);
//                $("#modalback").fadeOut(250);
                $('.SelectBoxContainer').html(data);
//                $("#wait").css("display", "none");
//                $('#roxyCustomPanel2').dialog('close');
//                $('#closeModal1').click(function(){return true;}).click();
                $('#closeModal2').click(function () {
                    return true;
                }).click();
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        <?php
        if ($cm == 'edit') {
        ?>
        $.ajax({
            type: 'POST',
            url: 'AjaxMetaStatus.php',
            data: {
                chars: $('#metadescription').val().length
            },
            success: function (data) {
                $('#mdstatus').html(data);
            }

        });
        $.ajax({
            type: 'POST',
            url: 'AjaxMetaStatus2.php',
            data: {
                value: $('#keywords').val()
            },
            success: function (data) {
                $('#mkstatus').html(data);
            }

        });
        <?php
        }
        ?>


//        $("#filemanagerbtn").click(function () {
//            $("#Filemanager").fadeIn(250);
//            $("#modalback").fadeIn(250);
//        });
//        $(".Default").click(function () {
//            $("#Filemanager").fadeIn(250);
//            $("#modalback").fadeIn(250);
//        });
//        $("#filemanagerbtn2").click(function () {
//            $("#Filemanager2").fadeIn(250);
//            $("#modalback").fadeIn(250);
//        });
        $("#closeModal2").click(function () {
//            $("#Filemanager2").fadeOut(250);
//            $("#modalback").fadeOut(250);
            $("#wait").css("display", "block");
            $.ajax({
                type: 'POST',
                url: 'RefreshImageThumbs.php',
                data: {
                    FolderId: <?php
                    if ($cm == 'add') {
                        echo $_GET['newid'];
                    } else {
                        echo $_GET['id'];
                    }
                    ?>},
                success: function (data) {
                    $('.UploadBoxThumbs').html(data);
                    $("#wait").css("display", "none");
                }
            });
        });
        $("#wait").click(function () {
            $("#wait").fadeOut(500);
        });

        $("#confirm-btn").click(function () {
            $("#wait").css("display", "block");
//            $("#Filemanager").fadeOut(250);
//            $("#modalback").fadeOut(250);
            $.ajax({
                type: 'POST',
                url: 'RefreshImageThumbs.php',
                data: {
                    FolderId: <?php
                    if ($cm == 'add') {
                        echo $_GET['newid'];
                    } else {
                        echo $_GET['id'];
                    }
                    ?>},
                success: function (data) {
                    $('.UploadBoxThumbs').html(data);
                    $("#wait").css("display", "none");
                }
            });
        });
        $("#modalback").click(function () {
            $("#wait").css("display", "block");
            $("#Filemanager").fadeOut(250);
            $("#Filemanager2").fadeOut(250);
            $("#p-table").fadeOut(250);
            $("#p-info").fadeOut(250);
            $("#modalback").fadeOut(500);
            $.ajax({
                type: 'POST',
                url: 'RefreshImageThumbs.php',
                data: {
                    FolderId: <?php
                    if ($cm == 'add') {
                        echo $_GET['newid'];
                    } else {
                        echo $_GET['id'];
                    }
                    ?>},
                success: function (data) {
                    $('.UploadBoxThumbs').html(data);
                    $("#wait").css("display", "none");
                }
            });
        });
        $("#group").select2({
            placeholder: "مجموعه را انتخاب کنید...",
            dir: "rtl"
        });
        $("#subgroup").select2({
            placeholder: "زیر مجموعه را انتخاب کنید...",
            dir: "rtl"
        });
        $("#suppergroup").select2({
            placeholder: "زیر زیر مجموعه را انتخاب کنید...",
            dir: "rtl"
        });
        $("#brand").select2({
            placeholder: "تامین کننده محصول را انتخاب کنید...",
            dir: "rtl"
        });
        $("#color").select2({
            placeholder: "رنگ مورد نظر را انتخاب کنید...",
            dir: "rtl"
        });
        $("#guarantee").select2({
            placeholder: "گارانتی مورد نظر را انتخاب کنید...",
            dir: "rtl"
        });

        $("#group").change(function () {
            $('#loader1').fadeIn(0);
            var group = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'RefreshSubgroups.php',
                data: {group: group},
                success: function (data) {
                    $('#subgroup-td').html(data);
                    $('#suppergroup').html('<option></option>');
                    $('#loader1').fadeOut(0);
                }
            });
        });

    });
</script>
<script>
//    $(document).ready(function () {
//        $("#properties").click(function () {
//            $("#wait").fadeIn(0);
//            $.ajax({
//                url: 'AjaxProductAndProperties.php',
//                type: 'POST',
//                data: {
//                    productId: <?php
//                    if ($cm == 'add') {
//                        echo $_GET['newid'];
//                    } else {
//                        echo $_GET['id'];
//                    }
//                    ?>//, suppergroup: $('.SelectPropertiesBox').val()
//                },
//                success: function (result) {
//                    $("#modal-content").html(result);
////                    $("#p-info").fadeIn(250);
////                    $("#modalback").fadeIn(250);
//                    $("#wait").fadeOut(0);
//                }
//            });
//        });
//    });

    //    $(document).ready(function() {
    //        $("#properties2").click(function() {
    //            $("#wait").css("display", "block");
    //            $.ajax({
    //                url: 'AjaxProductAndProperties2.php',
    //                type: 'POST',
    //                data: {productId: <?php
    //if ($cm == 'add') {
    //    echo $_GET['newid'];
    //} else {
    //    echo $_GET['id'];
    //}
    ?>//, group: $('#group').val()},
    //                success: function(result) {
    //                    $("#wait").css("display", "none");
    //                    $("#p-table").html(result);
    //                    $("#p-table").fadeIn(250);
    //                    $("#modalback").fadeIn(250);
    //                }
    //            });
    //        });
    //    });

    $(document).ready(function () {
//        $("#properties2").click(function () {
//            $("#wait").fadeIn(0);
//            $.ajax({
//                url: 'AjaxProductAndProperties.php',
//                type: 'POST',
//                data: {
//                    productId: <?php
//                    if ($cm == 'add') {
//                        echo $_GET['newid'];
//                    } else {
//                        echo $_GET['id'];
//                    }
//                    ?>//, suppergroup: $('#suppergroup').val()
//                },
//                success: function (result) {
//                    $("#modal-content").html(result);
////                    $("#p-info").fadeIn(250);
////                    $("#modalback").fadeIn(250);
//                    $("#wait").fadeOut(0);
//                }
//            });
//        });

        $("#pp-btn").click(function () {
            $.ajax({
                url: 'AjaxInsertProductProperty.php',
                type: 'POST',
                data: {suppergroup: $('#suppergroup').val(),
                    product: <?php echo $_GET['id'];?>},
                success: function (result) {
                    $("#pp-modal").html(result);
//                    $("#pp-modal").fadeIn(500);
                }
            });
        });
    });

    $(document).ready(function () {

        $("#btnAddColor").click(function () {
            var color = $("#color").val();
            var quantity = $("#quantity").val();
            $.ajax({
                type: 'POST',
                url: 'AjaxAddColor.php',
                data: {
                    color: color, quantity: quantity, product:<?php
                    if ($cm == 'add') {
                        echo $_GET['newid'];
                    } else {
                        echo $_GET['id'];
                    }
                    if ($cm == 'add') {
                    } else {
                        echo ', editmode:1 ';
                    }
                    ?> },
                success: function (data) {
                    $('#colorSamples').html(data);
                    $('#quantity').val("");
                }
            });
            $.ajax({
                type: 'POST',
                url: 'RefreshColor.php',
                success: function (data) {
                    $('#color').html(data);
                }
            });
        });
        $("#btnAddGuarantee").click(function () {
            var guarantee = $("#guarantee").val();
            $.ajax({
                type: 'POST',
                url: 'AjaxAddGuarantee.php',
                data: {
                    guarantee: guarantee, product:<?php
                    if ($cm == 'add') {
                        echo $_GET['newid'];
                    } else {
                        echo $_GET['id'];
                    }
                    ?>},
                success: function (data) {
                    $('#guaranteeSamples').html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: 'RefreshGuarantee.php',
                success: function (data) {
                    $('#guarantee').html(data);
                }
            });
        });
        $("#subgroup").change(function () {
            $('#loader3').fadeIn(0);
            var subgroup = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'RefreshSuppergroups.php',
                data: {group: $('#group').val(), subgroup: subgroup},
                success: function (data) {
                    $('#suppergroup-td').html(data);
                    $('#loader3').fadeOut(0);
                }
            });
        });

        $("#suppergroup").change(function () {
            var suppergroup = $(this).val();
            $.ajax({
                url: 'AjaxEnablePropertiesBox.php',
                type: 'POST',
                data: {suppergroup: suppergroup},
                success: function (data) {
                    $('#properties').html(data);
                }
            });
        });
        $('#metadescription').on('input', function () {
            $.ajax({
                type: 'POST',
                url: 'AjaxMetaStatus.php',
                data: {
                    chars: $('#metadescription').val().length
                },
                success: function (data) {
                    $('#mdstatus').html(data);
                }

            });
        });
        $('#keywords').on('input', function () {
            $.ajax({
                type: 'POST',
                url: 'AjaxMetaStatus2.php',
                data: {
                    value: $('#keywords').val()
                },
                success: function (data) {
                    $('#mkstatus').html(data);
                }

            });
        });
    });
</script>
<script>
    tinyMCE.init({
        selector: '.tiny',
        plugins: 'link image fullscreen textcolor contextmenu searchreplace colorpicker',
        imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
        directionality: 'rtl',
        statusbar: true,
        contextmenu: "link image inserttable | cell row column deletetable",
        resize: true,
        toolbar1: "insertfile undo redo | styleselect | fontselect fontsizeselect bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | searchreplace ",
        toolbar2: "  bullist numlist outdent indent | link | image | fullscreen ",
        file_browser_callback: RoxyFileBrowser
    });

    function RoxyFileBrowser(field_name, url, type, win) {
        var roxyFileman = 'fileman2/index.html?integration=tinymce4';
        if (roxyFileman.indexOf("?") < 0) {
            roxyFileman += "?type=" + type;
        }
        else {
            roxyFileman += "&type=" + type;
        }
        roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
        if (tinyMCE.activeEditor.settings.language) {
            roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
        }
        tinyMCE.activeEditor.windowManager.open({
            file: roxyFileman,
            title: 'Roxy Fileman',
            width: 850,
            height: 650,
            resizable: "yes",
            plugins: "media",
            inline: "yes",
            close_previous: "no"
        }, {window: win, input: field_name});
        return false;
    }

</script>
<!--<script>
    $(document).ready(function() {
        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            autoOpen: false,
            modal: true,
            dialogClass: 'confirm-message',
            buttons: {
                "خیر": function() {
                    $(this).dialog("close");
                },
                "بله": function() {                    
                    $(this).dialog("close");
                }
            }
        });
        $(".ui-dialog-titlebar").hide();

        $(".Default").click(function() {
            $('#dialog-confirm').dialog('open');
        });
    });
</script>-->

<?php
include_once 'Template/menu.php';
?>
<!--<div id="dialog-confirm" title="Empty the recycle bin?">
    <div class="confirm-message" id="confirm-message">
        <div class="title"><img src="Template/Images/warning2.png" />اخطار</div>
        <div class="body">آیا میخواهید این عکس را حذف کنید ؟</div>
        <div class="buttons">
        </div>    
    </div>
</div>-->
<div class="modalback" id="modalback"></div>
<!--<div class="confirm-message" id="confirm-message">
    <div class="title"><img src="Template/Images/warning2.png" /><span>اخطار</span></div>
    <div class="body">آیا میخواهید این عکس را حذف کنید ؟</div>
    <div class="buttons">
        <input type="button" id="no" value="خیر" />  
        <input type="button" id="yes" value="بله" />              
    </div>    
</div>-->

<div class="modal inmodal fade" id="addModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" id="pp-modal">

        </div>
    </div>
</div>

<div class="modal inmodal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">


        </div>
    </div>
</div>

<div class="properties-table" id="p-table"></div>
<div></div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>محصول</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Product</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight ecommerce">

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1"> اطلاعات محصول</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2"> دسته بندی</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3"> تصاویر</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4"> ویژگی ها</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-5"> توضیحات اجمالی محصول</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-6"> نقد و بررسی</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-7">محتویات دانلود</a></li>

                </ul>

                <div class="Inputs">
                    <?php
                    if ($cm == "add") {
                    if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                        $_SESSION[SESSION_PATH_KEY] = "/DigitalShopv2/Images/" . $_GET['newid'] . "/";
                    } else {
                        $_SESSION[SESSION_PATH_KEY] = "/Images/" . $_GET['newid'] . "/";
                    }
                    ?>
                    <form action="InsertProduct.php" method="post">
                        <input type="hidden" id="productId" name="productId" value="<?php echo $_GET['newid']; ?>"/>
                        <?php
                        } elseif ($cm == "edit") {
                        if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                            $_SESSION[SESSION_PATH_KEY] = "/DigitalShopv2/Images/" . $product->ProductId . "/";
                        } else {
                            $_SESSION[SESSION_PATH_KEY] = "/Images/" . $product->ProductId . "/";
                        }


                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
                        $sbgds = new SubGroupDataSource();
                        $sbgds->open();
                        $subgroups = $sbgds->FillByGroup($product->Group->GroupId);
                        $sbgds->close();

                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
                        $spgds = new SupperGroupDataSource();
                        $spgds->open();
                        $suppergroups = $spgds->FillByGroupAndSubgroup($product->Group->GroupId, $product->SubGroup->SubGroupId);
                        $spgds->close();


                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductCouponDataSource.inc';
                        $pcds = new ProductCouponDataSource();
                        $pcds->open();
                        if ($pcds->FindOneProductCoupons2($product->ProductId) != NULL) {
                            $productLastCoupon = $pcds->FindOneProductCoupons2($product->ProductId);
                        }
                        $pcds->close();

                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
                        $dds = new DiscountDataSource();
                        $dds->open();
                        if ($dds->GetLastDiscountForOneProduct($product->ProductId) != NULL) {
                            $productLastDiscount = $dds->GetLastDiscountForOneProduct($product->ProductId);
                        }
                        $dds->close();

                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
                        $pcds = new PriceDataSource();
                        $pcds->open();
                        $lastPrice = $pcds->GetLastPriceForOneProduct($product->ProductId);
                        $pcds->close();

                        ?>
                        <form action="InsertProduct.php" method="post">
                            <input type="hidden" id="productId" name="productId"
                                   value="<?php echo $product->ProductId; ?>"/>
                            <input type="hidden" id="editmode" name="editmode" value="1"/>
                            <?php
                            }
                            ?>

                            <div class="db-cover2" id="wait">
                                <img class="loading-gif2" src="Template/Images/gifs/giphy (3).gif" alt=""/>
                                <span class="loading-title2 <?php
                                if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                                    echo " SBackground'";
                                } else {
                                    echo " GBackground'";
                                }
                                ?>">Loading...</span>

                            </div>

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">

                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">عنوان:</label>
                                                <div class="col-sm-12">
                                                    <input required placeholder="به فارسی..."
                                                           type="Text" class="form-control input-sm m-b-xs"
                                                           id="name" name="name"
                                                           value="<?php echo $product->Name; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                        class="col-sm-12 control-label"></label>
                                                <div class="col-sm-12">
                                                    <input placeholder="In English..."
                                                           type="Text"
                                                           class="form-control input-sm m-b-xs"
                                                           style="direction: ltr;" id="latinname"
                                                           name="latinname"
                                                           value="<?php echo $product->LatinName; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">قیمت:</label>
                                                <div class="col-sm-12">
                                                    <input required placeholder="قیمت به تومان..."
                                                           type="text"
                                                           onkeypress="return CheckNumeric();"
                                                           onkeyup="FormatCurrency(this);"
                                                           value="<?php
                                                           if ($detect->isMobile() && !$detect->isTablet() && $lastPrice != 0) {
                                                               echo number_format($lastPrice);
                                                           } else {
                                                               echo number_format($lastPrice);
                                                           }
                                                           ?>" class="form-control input-sm m-b-xs" id="price"
                                                           name="price"/></div>
                                            </div>


                                            <?php
                                            $stock_checked = "";
                                            if ($product->Stock == 1) {
                                                $stock_checked = " checked";
                                            }
                                            ?>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="checkbox checkbox-danger">
                                                        <input type="checkbox" value="1" id="stock"
                                                               name="stock" <?php echo $stock_checked; ?>/>
                                                        <label for="stock">
                                                            دست دوم
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $downloadable_checked = "";
                                            if ($product->Downloadable == 1) {
                                                $downloadable_checked = " checked";
                                            }
                                            ?>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="checkbox checkbox-danger">
                                                        <input type="checkbox" value="1" id="downloadable"
                                                               name="downloadable" <?php echo $downloadable_checked; ?>/>
                                                        <label for="downloadable">
                                                            دانلودی است
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">کپن
                                                    <span class="optional">(اختیاری)</span>:</label>
                                                <div class="col-sm-12">
                                                    <input placeholder="تعداد کپن دریافتی برای خرید محصول..."
                                                           type="number" min='0'
                                                           value="<?php echo $productLastCoupon; ?>"
                                                           class="form-control input-sm m-b-xs"
                                                           id="coupon"
                                                           name="coupon"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">تخفیف
                                                    <span class="optional">(اختیاری)</span>:</label>
                                                <div class="col-sm-12">
                                                    <input placeholder="چند درصد تخفیف...؟"
                                                           type="number" min='0' class="form-control input-sm m-b-xs"
                                                           value="<?php echo $productLastDiscount; ?>"
                                                           id="discount" name="discount"/>
                                                </div>
                                            </div>

                                            <div class="form-group
                                            <?php
                                            if ($role->ProductApprove == 1) {
                                                echo ' hide';
                                            }
                                            ?>">
                                                <label class="col-sm-12 control-label">
                                                    وضعیت محصول:
                                                </label>
                                                <div class="col-sm-12">
                                                    <div class="radio radio-danger">
                                                        <input type="radio" <?php
                                                        if ($product->Activated == 1 && $role->ProductApprove == 0) {
                                                            echo ' checked ';
                                                        }
                                                        ?> id="s-option" name="activated" value="1">
                                                        <label for="s-option">
                                                            فعال
                                                        </label>
                                                    </div>

                                                    <div class="radio radio-danger">
                                                        <input type="radio" <?php
                                                        if ($product->Activated == 0 || $role->ProductApprove == 1) {
                                                            echo ' checked ';
                                                        }
                                                        ?> id="f-option" name="activated" value="0">
                                                        <label for="f-option">
                                                            غیرفعال
                                                        </label>
                                                    </div>
                                                    <div class="clear-fix"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="alert alert-warning">
                                                        <span class="optional">: SEO</span>
                                                        <br>
                                                        توجه : کلمات کلیدی با استفاده از " , " از هم جدا می شوند . مثال
                                                        : "گوشی سامسونگ ,گوشی سامسونگ سری S "
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label" style="margin-bottom: 15px">
                                                    <span class="label" id="mkstatus" class="HIDE"
                                                          style="font-size: 15px;"></span>
                                                </label>
                                                <div class="col-sm-12">
                                                    <input title="کلماتی که به محصول شما مرتبط هستند "
                                                           placeholder="کلمات کلیدی ..."
                                                           type="Text" class="form-control input-sm m-b-xs"
                                                           id="keywords" name="keywords"
                                                           value="<?php echo $product->Keywords; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label" style="margin-bottom: 15px">
                                                    <span class="label" id="mdstatus" class="HIDE"
                                                          style="font-size: 15px;"></span>
                                                </label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control input-sm m-b-xs" rows="5"
                                                              id="metadescription"
                                                              placeholder="توضیحات محصول برای متا ..."
                                                              name="metadescription"
                                                              cols="20"><?php echo $product->MetaDescription; ?></textarea>
                                                </div>
                                            </div>

                                        </fieldset>

                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">

                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    دسته بندی:
                                                </label>
                                                <div class="col-sm-12">
                                                    <select required class="js-example-basic-single form-control m-b"
                                                            style="width: 100%;" id="group"
                                                            name="group">
                                                        <option></option>
                                                        <?php
                                                        if ($role->ProductGroupLimit) {

                                                            $grps = explode(',', trim($role->AllowedProductGroups, ','));

                                                            foreach ($groups as $g) {

                                                                if (in_array($g->GroupId, $grps)) {
                                                                    $selected = "";
                                                                    if ($product->Group->GroupId == $g->GroupId)
                                                                        $selected = ' selected ';

                                                                    echo "<option  value='$g->GroupId' $selected > $g->Name  $g->LatinName </option>";
                                                                }
//                    echo "<option ";
//                    if ($product->Group->GroupId == $g->GroupId) {
//                        echo ' selected ';
//                    }
//                    echo " value = '$g->GroupId'";
//                    if ($g->GroupId == $product->Group) {
//                        echo " selected >( " . $g->Name . " ) " . $g->LatinName . "</option>";
//                    } else {
//                        echo ">( " . $g->Name . " ) " . $g->LatinName . "</option>";
//                    }
                                                            }
                                                        } else {
                                                            foreach ($groups as $g) {
                                                                echo "<option ";
                                                                if ($product->Group->GroupId == $g->GroupId) {
                                                                    echo ' selected ';
                                                                }
                                                                echo " value = '$g->GroupId'";
                                                                if ($g->GroupId == $product->Group) {
                                                                    echo " selected >( " . $g->Name . " ) " . $g->LatinName . "</option>";
                                                                } else {
                                                                    echo ">( " . $g->Name . " ) " . $g->LatinName . "</option>";
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            if ($cm == 'edit') {
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-12 control-label">
                                                        <img class="loader"
                                                             id="loader3"
                                                             src="Template/Images/gifs/loading.gif"
                                                             width="40"
                                                             height="40"/>
                                                    </label>
                                                    <div class="col-sm-12" id="subgroup-td">

                                                        <select required
                                                                class="js-example-basic-single form-control m-b"
                                                                style="width: 100%;"
                                                                id="subgroup"
                                                                name="subgroup">
                                                            <option></option>
                                                            <?php
                                                            foreach ($subgroups as $g) {
                                                                echo "<option ";
                                                                if ($product->SubGroup->SubGroupId == $g->SubGroupId) {
                                                                    echo ' selected ';
                                                                }
                                                                echo " value = '$g->SubGroupId'";
                                                                if ($g->SubGroupId == $product->SubGroup) {
                                                                    echo " selected >( " . $g->Name . " ) " . $g->LatinName . "</option>";
                                                                } else {
                                                                    echo ">( " . $g->Name . " ) " . $g->LatinName . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-12 control-label">
                                                        <img class="loader"
                                                             id="loader3"
                                                             src="Template/Images/gifs/loading.gif"
                                                             width="40"
                                                             height="40"/>
                                                    </label>
                                                    <div class="col-sm-12" id="suppergroup-td">
                                                        <select required
                                                                class="js-example-basic-single form-control m-b"
                                                                style="width: 100%;"
                                                                id="suppergroup" name="suppergroup">
                                                            <option></option>
                                                            <?php
                                                            foreach ($suppergroups as $g2) {
                                                                echo "<option ";
                                                                if ($product->SupperGroup->SupperGroupId == $g2->SupperGroupId) {
                                                                    echo ' selected ';
                                                                }
                                                                echo " value = '$g2->SupperGroupId'";
                                                                if ($g2->SupperGroupId == $product->SupperGroup) {
                                                                    echo " selected > ( " . $g2->Name . " ) " . $g2->LatinName . "</option>";
                                                                } else {
                                                                    echo ">( " . $g2->Name . " ) " . $g2->LatinName . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <?php
                                            } else {
                                                ?>

                                                <div class="form-group">
                                                    <label class="col-sm-12 control-label">
                                                        <img class="loader"
                                                             id="loader3"
                                                             src="Template/Images/gifs/loading.gif"
                                                             width="40"
                                                             height="40"/>
                                                    </label>
                                                    <div class="col-sm-12" id="subgroup-td">
                                                        <select required
                                                                class="js-example-basic-single form-control m-b"
                                                                style="width: 100%;"
                                                                disabled
                                                                id="subgroup" name="subgroup">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-12 control-label">
                                                        <img class="loader"
                                                             id="loader3"
                                                             src="Template/Images/gifs/loading.gif"
                                                             width="40"
                                                             height="40"/>
                                                    </label>
                                                    <div class="col-sm-12" id="suppergroup-td">
                                                        <select required
                                                                class="js-example-basic-single form-control m-b"
                                                                style="width: 100%;"
                                                                disabled
                                                                id="suppergroup" name="suppergroup">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>


                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    گارانتی ها:
                                                </label>
                                                <div class="col-sm-12">
                                                    <?php
                                                    echo "<select  class='js-example-basic-single form-control m-b' style='width: 100%;' name='guarantee' id='guarantee' >";
                                                    echo "<option></option>";
                                                    foreach ($guarantees as $g) {
                                                        echo "<option value='$g->GuaranteeListId' > $g->Name - $g->Duration : " . number_format($g->Price) . " تومان </option>";
                                                    }
                                                    echo "</select>";
                                                    ?>
                                                    <br>
                                                    <button class="btn btn-info btn-w-m" type="button"
                                                            id="btnAddGuarantee">
                                                        <i class="fa fa-plus"></i>
                                                        افزودن
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                </label>
                                                <div class="col-sm-12" id="guaranteeSamples">
                                                    <?php
                                                    if ($cm == 'edit') {
                                                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';

                                                        $grds = new GuaranteeDataSource();
                                                        $grds->open();
                                                        $guarantee->GuaranteeId = $_POST['guaranteeId'];
                                                        $grds->Delete($_POST['guaranteeId']);
                                                        $grds->close();
                                                        $guarantees = $grds->GetGuaranteesForOneProduct($_GET['id']);
                                                        foreach ($guarantees as $p) {
                                                            echo "<div class='guaranteeSample'>" . $p->Guarantee->Name . "-" . $p->Guarantee->Duration . " : <span class='price'>" . number_format($p->Guarantee->Price) . " تومان</span><a class='dltbtn3'><img src='Template/Images/deleteX.png' alt='' />$p->GuaranteeId</a></div>";
                                                        }
                                                        ?>
                                                        <script>
                                                            $(document).ready(function () {
                                                                $(".dltbtn3").click(function () {
                                                                    if (confirm('آیا میخواهید این گارانتی را حذف نمایید ؟')) {
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: 'AjaxDeleteGuarantee.php',
                                                                            data: {
                                                                                guaranteeId: $(this).text(),
                                                                                product:<?php echo $_GET['id']; ?>},
                                                                            success: function (data) {
                                                                                $('#guaranteeSamples').html(data);
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    تامین کننده:
                                                </label>
                                                <div class="col-sm-12">
                                                    <?php
                                                    echo "<select required class='js-example-basic-single form-control m-b' style='width: 100%;' name='brand' id='brand' >";
                                                    echo "<option></option>";
                                                    if ($role->BrandLimit) {

                                                        $lgs = explode(',', trim($role->AllowedBrands, ','));

                                                        foreach ($logos as $l) {

                                                            if (in_array($l->LogoId, $lgs)) {
                                                                $selected = "";
                                                                if ($product->Brand->LogoId == $l->LogoId)
                                                                    $selected = ' selected ';

                                                                echo "<option value='$l->LogoId' $selected > $l->Name  $l->LatinName </option>";
                                                            }
                                                        }
                                                    } else {
                                                        foreach ($logos as $l) {
                                                            echo "<option ";
                                                            echo " value = '$l->LogoId'";
                                                            if ($l->LogoId == $product->Brand->LogoId) {
                                                                echo " selected >$l->LatinName ($l->Name)</option>";
                                                            } else {
                                                                echo ">$l->LatinName ($l->Name)</option>";
                                                            }
                                                        }
                                                    }
                                                    echo "</select>";
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    رنگ ها:
                                                </label>
                                                <div class="col-sm-12">
                                                    <?php
                                                    echo "<select  class='js-example-basic-single form-control m-b' style='width: 100%;' name='color' id='color' >";
                                                    echo "<option></option>";
                                                    foreach ($colors as $l) {
                                                        echo "<option value = '$l->ColorListId'>";
                                                        echo "$l->Name </option>";
                                                    }
                                                    echo "</select>";
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                </label>
                                                <div class="col-sm-12">
                                                    <input placeholder="تعداد موجودی..." type="Number" min='0'
                                                           class="form-control input-sm m-b-xs" id="quantity"
                                                           name="quantity"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                </label>
                                                <div class="col-sm-12" id="btnAddColorTd">
                                                    <button class="btn btn-info btn-w-m" type="button" id="btnAddColor">
                                                        <i class="fa fa-plus"></i>
                                                        افزودن
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                </label>
                                                <div class="col-sm-12" id="colorSamples">
                                                    <?php
                                                    if ($cm == 'edit') {
                                                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

                                                        $pcds = new ProductColorDataSource();
                                                        $pcds->open();
                                                        $pcds->Delete($_POST['colorId']);
                                                        $productcolors = $pcds->GetProductColorsForOneProduct($_GET['id']);
                                                        $pcds->close();
                                                        foreach ($productcolors as $p) {
                                                            echo "<div class = 'colorSample' style = 'border:3px solid " . $p->Color->Sample . ";' title = '" . $p->Color->Name . "'>" . $p->Quantity . "<a class='dltbtn2'><img src='Template/Images/deleteHover.png' alt='' />$p->ProductColorId</a></div>";
                                                        }
                                                        ?>
                                                        <script>
                                                            $(document).ready(function () {
                                                                $(".dltbtn2").click(function () {
                                                                    if (confirm('آیا میخواهید این رنگ را حذف نمایید ؟')) {
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: 'AjaxDeleteColor.php',
                                                                            data: {
                                                                                colorId: $(this).text(),
                                                                                product:<?php echo $_GET['id']; ?>},
                                                                            success: function (data) {
                                                                                $('#colorSamples').html(data);
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </fieldset>

                                    </div>
                                </div>
                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">

                                        <fieldset class="form-horizontal">
                                            <div class="ImageBox">
                                                <div class="col-md-6">
                                                    <a id="filemanagerbtn" data-toggle='modal'
                                                       data-target='#filemanModal1'>
                                                        <div class="UploadBoxContainer center">
                                                            <div class="UploadBox"></div>
                                                        </div>
                                                    </a>
                                                    <div class="modal inmodal fade" id="filemanModal1" tabindex="-1"
                                                         role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" id="closeModal1"><span
                                                                                aria-hidden="true">&times;</span><span
                                                                                class="sr-only">Close</span></button>
                                                                    <button type="button" id="confirm-btn"
                                                                            class="btn btn-primary" style="float: right"
                                                                            data-dismiss="modal">تایید
                                                                    </button>
                                                                    <h4 class="modal-title"><i
                                                                                class="fa fa-photo text-primary m-xs"></i>انتخاب
                                                                        تصویر</h4>
                                                                    <small class="font-bold">حجم مجاز : 5 مگابایت
                                                                    </small>
                                                                    <br>
                                                                    <small class="font-bold text-danger">برای ثبت تصویر
                                                                        حتما دکمه "تایید" را انتخاب نمایید.
                                                                    </small>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <iframe src="fileman/index4.html?integration=custom"
                                                                            style="width:100%;height:465px"
                                                                            frameborder="0"></iframe>
                                                                    </iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="UploadBoxThumbs center">
                                                        <?php
                                                        if ($cm == 'add') {
                                                            ?>
                                                            <div class='thumb-holder'><img class="Default"
                                                                                           data-toggle='modal'
                                                                                           data-target='#filemanModal1'
                                                                                           src='Template/Images/ImageThumb.png'/>
                                                            </div>
                                                            <div class='thumb-holder'><img class="Default"
                                                                                           data-toggle='modal'
                                                                                           data-target='#filemanModal1'
                                                                                           src='Template/Images/ImageThumb.png'/>
                                                            </div>
                                                            <div class='thumb-holder'><img class="Default"
                                                                                           data-toggle='modal'
                                                                                           data-target='#filemanModal1'
                                                                                           src='Template/Images/ImageThumb.png'/>
                                                            </div>
                                                            <div class='thumb-holder'><img class="Default"
                                                                                           data-toggle='modal'
                                                                                           data-target='#filemanModal1'
                                                                                           src='Template/Images/ImageThumb.png'/>
                                                            </div>

                                                            <?php
                                                        } else {
                                                            $max = 32;
                                                            $dir = "../Images/" . $_GET['id'];
                                                            $files = array_values(array_filter(scandir($dir), function ($file) {
                                                                return !is_dir($file);
                                                            }));
                                                            $n = 0;
                                                            foreach ($files as $file) {
                                                                if (strpos($file, 'png') !== false || strpos($file, 'jpg') !== false) {
                                                                    if ($n < $max) {
                                                                        $n++;
                                                                        echo "<div class='thumb-holder  ThumbImage'><img src='$dir/$file' /></div>";
                                                                        echo "<a class='deleteHover'>$dir/$file<img src='Template/Images/deleteHover.png' /></a> ";
                                                                    }
                                                                }
                                                            }
                                                            $rows = ceil($n / 4);
                                                            if ($n == 0) {
                                                                $rows = 1;
                                                            }
                                                            for ($i = (4 * $rows) - $n; $i > 0; $i--) {
                                                                echo "<div class='thumb-holder'><img class='Default' data-toggle='modal' data-target='#filemanModal1' src='Template/Images/ImageThumb.png' /></div>";
                                                            }
                                                        }
                                                        ?>
                                                        <div class="clear-fix"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <a id="filemanagerbtn2" data-toggle='modal'
                                                       data-target='#filemanModal2'>
                                                        <div class="SelectBoxContainer center">
                                                            <?php
                                                            if ($cm == 'edit' && trim($product->Image) != "") {
                                                                echo '<img src=../' . $product->Image . ' />';
                                                            } else {
                                                                echo '<div class="SelectBox"></div>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </a>
                                                    <div class="modal inmodal fade" id="filemanModal2" tabindex="-1"
                                                         role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" id="closeModal2"><span
                                                                                aria-hidden="true">&times;</span><span
                                                                                class="sr-only">Close</span></button>
                                                                    <h4 class="modal-title"><i
                                                                                class="fa fa-photo text-primary m-xs"></i>انتخاب
                                                                        تصویر</h4>
                                                                    <small class="font-bold">اگر تصاویر بارگذاری نشدند،
                                                                        روی پوشه کلیک نمایید.
                                                                    </small>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <iframe src="fileman/index3.html?integration=custom&type=files&txtFieldId=image"
                                                                            style="width:100%;height:465px"
                                                                            frameborder="0"></iframe>
                                                                    </iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="image" name="image"
                                                           value="<?php echo $product->Image; ?>"/>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="col-md-12">
                                            <?php
                                            if ($cm == 'add') {
                                                ?>
                                                <div id="properties" class="SelectBoxContainer2 center"
                                                     data-toggle="modal" data-target="#productModal"><input
                                                            disabled=""
                                                            type="button"
                                                            class="SelectPropertiesBox"/>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <style>
                                                    .SelectPropertiesBox:hover {
                                                        cursor: pointer;
                                                        background-position: -312px 15px;
                                                        border-color: #008aff;
                                                    }

                                                </style>
                                                <div id="properties2" class="SelectBoxContainer2 center"
                                                     data-toggle="modal" data-target="#productModal"><input
                                                            type="button"
                                                            class="SelectPropertiesBox"/>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-4" class="tab-pane">
                                    <div class="panel-body">

                                        <fieldset class="form-horizontal">
                                            <div class="col-md-12">
                                                <?php
                                                if ($cm == 'add') {
                                                    ?>
                                                    <div id="properties" class="SelectBoxContainer2 center"
                                                         data-toggle="modal" data-target="#productModal"><input
                                                                disabled=""
                                                                type="button"
                                                                class="SelectPropertiesBox"/>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a id="pp-btn" data-toggle="modal" data-target="#addModal">
                                                        <button class="btn btn-primary btn-w-m" type="button"
                                                                data-dismiss="modal"><i class="fa fa-plus"></i>
                                                            افزودن ویژگی جدید
                                                        </button>
                                                    </a>
                                                    <br>
                                                    <br>
                                                    <div class="alert alert-warning">
                                                        توجه : اگر خاصیتی در محصول مورد نظر صدق نمی کند آن را خالی
                                                        بگذارید .
                                                    </div>
                                                    <div class="alert alert-warning">
                                                        توجه : اگر خاصیتی از محصول را میخواهید حذف کنید، کافی است محتوای
                                                        آن را خالی کنید!
                                                    </div>

                                                    <fieldset id="properties" class="form-horizontal">
                                                        <?php
                                                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

                                                        $pds = new ProductDataSource();
                                                        $pds->open();
                                                        $productAndProperties = $pds->GetProperties($_GET['id']);
                                                        $pds->close();

                                                        $productAndProperty = new ProductAndPropertyDataSource();
                                                        $productAndProperty->open();
                                                        foreach ($productAndProperties as $check) {
                                                            if ($product->SupperGroup->SupperGroupId != $check->ProductProperty->Group) {
                                                                $productAndProperty->Delete($check->ProductAndPropertyId);
                                                            }
                                                        }
                                                        $productAndProperty->close();

                                                        ?>
                                                        <?php
                                                        $n = 0;
                                                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';

                                                        $productProperty = new ProductPropertyDataSource();
                                                        $productProperty->open();
                                                        $productProperties = $productProperty->FindOneSupperGroupRecords($product->SupperGroup->SupperGroupId);
                                                        $productProperty->close();

                                                        $pap = new ProductAndPropertyDataSource();
                                                        $pap->open();

                                                        foreach ($productProperties as $p2) {
                                                            echo '<div class="form-group">';
                                                            echo '<label class="col-sm-12 control-label">';
                                                            echo $p2->Name . " : ";
                                                            echo '</label>';
                                                            echo '<div class="col-sm-12">';
                                                            echo "<input type='hidden' class='form-control input-sm m-b-xs' value='$p2->ProductPropertyId' name='propertyname$n' id = 'propertyname$n' />";
                                                            echo '</div>';
                                                            echo '</div>';

                                                            if (trim($p2->Value) == "-" || trim($p2->Value) == "") {
                                                                ?>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="Text"
                                                                               id='property<?php echo $n; ?>'
                                                                               name='property<?php echo $n; ?>'
                                                                               class="form-control input-sm m-b-xs"
                                                                               id="value" name="value"
                                                                               value="<?php echo $pap->FindValue($product->ProductId, $p2->ProductPropertyId) ?>"/>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $n++;
                                                            } else {
                                                                ?>
                                                                <?php
                                                                echo '<div class="form-group">';
                                                                echo '<div class="col-sm-12">';
                                                                echo "<select class = 'form-control m-b' style='width: 100%' id='property$n' name='property$n' >";
                                                                echo "<option  value = '' ></option>";
                                                                $n++;
                                                                foreach (explode("-", $p2->Value) as $p3) {
                                                                    echo "<option ";
                                                                    if ($pap->FindValue($product->ProductId, $p2->ProductPropertyId) == $p3) {
                                                                        echo "selected";
                                                                    }
                                                                    echo " value = '$p3' >" . $p3 . "</option>";
                                                                }
                                                                echo "</select>";
                                                                echo '</div>';
                                                                echo '</div>';
                                                            }
                                                        }
                                                        $pap->close();
                                                        ?>
                                                    </fieldset>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </fieldset>

                                    </div>
                                </div>
                                <div id="tab-5" class="tab-pane">
                                    <div class="panel-body">

                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    توضیحات اجمالی محصول:
                                                </label>
                                                <div class="col-sm-12">
                                                    <textarea class='tiny' id="content" name="content" rows="17"
                                                              class="WideText"
                                                              style="height: 300px;"
                                                              cols="20"><?php echo str_replace("PostImages/", "../PostImages/", $product->Description); ?></textarea>
                                                </div>
                                            </div>
                                        </fieldset>

                                    </div>
                                </div>
                                <div id="tab-6" class="tab-pane">
                                    <div class="panel-body">

                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    نقد و بررسی:
                                                </label>
                                                <div class="col-sm-12">
                                                    <textarea class='tiny' id="review" name="review" rows="30"
                                                              class="WideText"
                                                              style="height: 300px;"
                                                              cols="20"><?php echo str_replace("PostImages/", "../PostImages/", $product->Review); ?></textarea>
                                                </div>
                                            </div>
                                        </fieldset>

                                    </div>
                                </div>
                                <div id="tab-7" class="tab-pane">
                                    <div class="panel-body">

                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    محتویات دانلود
                                                </label>
                                                <div class="col-sm-12">
                                                    <textarea class='tiny' id="downloadcontent" name="downloadcontent"
                                                              rows="30"
                                                              class="WideText"
                                                              style="height: 300px;"
                                                              cols="20"><?php echo str_replace("PostImages/", "../PostImages/", $product->getDownloadContent()); ?></textarea>
                                                </div>
                                            </div>
                                        </fieldset>

                                    </div>
                                </div>


                            </div>


                            <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user" name="user"/>
                            <div class="ibox-content">
                                <a href="Products.php" class="pull-left">
                                    <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                                        لیست محصولات
                                    </button>
                                </a>

                                <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                            class="fa fa-check"></i><strong>تایید</strong></button>
                                <div class="clear-fix"></div>
                            </div>
                        </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!--<script defer onload="jqueryLoaded()" type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<!--    <script defer src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>-->
<script src="fileman/js/main.js" type="text/javascript"></script>
<?php
include_once 'Template/bottom.php';
