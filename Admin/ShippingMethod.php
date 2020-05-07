<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingMethodDataSource.inc';
$shippingmethod = new ShippingMethod();
if (isset($_GET['id'])) {
    if ($role->EditShippingMethod != 1) {
        header('Location:Index.php');
        die();
    }
    $smds = new ShippingMethodDataSource();
    $smds->open();
//    $p = new ShippingMethod();
//    $p->ShippingMethodId = $_GET['id'];
    $shippingmethod = $smds->FindOneShippingMethodBasedOnId($_GET['id']);
    $smds->close();
} else {
    if ($role->InsertShippingMethod != 1) {
        header('Location:Index.php');
        die();
    }
}

?>
<?php
include_once 'fileman/system.inc.php';
include_once 'fileman/php/functions.inc.php';
?>
<!--<script defer onload="jqueryLoaded()" type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<script defer src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script src="fileman/js/main.js" type="text/javascript"></script>

<link href="fileman/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css"/>
<link href="fileman/css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<script>
    function openCustomRoxy2() {
        $('#roxyCustomPanel2').dialog({modal: true, width: 875, height: 600});
    }

    function closeCustomRoxy2() {
//        $('#roxyCustomPanel2').dialog('close');
        $('#closeModal').click(function(){return true;}).click();
    }
</script>
<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>روش حمل</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Shipping Method</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="ShippingMethods.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست روش های حمل ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            روش حمل
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <?php
                                if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                                    $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/ShippingMethodImages/";
                                } else {
                                    $_SESSION[SESSION_PATH_KEY] = "ShippingMethodImages/";
                                }
                                ?>

                                <form action="operateShippingMethod.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $shippingmethod->ShippingMethodId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام روش حمل :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php
                                                       echo $shippingmethod->Name;
                                                       ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                توضیحات :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="comment" name="comment"
                                                       value="<?php
                                                       echo $shippingmethod->Comment;
                                                       ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                قیمت افزوده به هزینه ارسال:
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control input-sm m-b-xs" id="price"
                                                       placeholder="قیمت را به تومان وارد کنید..."
                                                       onkeypress="return CheckNumeric();"
                                                       onkeyup="FormatCurrency(this);" name="price" value="<?php
                                                echo number_format($shippingmethod->Price);
                                                ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                تصویر :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control input-sm m-b-xs" id="image" name="image"
                                                       readonly="readonly"
                                                       value="<?php echo $shippingmethod->Image; ?>"
                                                       style="cursor: pointer;"
                                                       data-toggle='modal' data-target='#filemanModal'/>

                                                <div class="modal inmodal fade" id="filemanModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" id="closeModal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4 class="modal-title"><i class="fa fa-photo text-primary m-xs"></i>انتخاب تصویر</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <iframe src="fileman/index4.html?integration=custom&type=files&txtFieldId=image"
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
                                                وضعیت :
                                            </label>
                                            <div class="col-sm-12">
                                                <div class="radio radio-danger">
                                                    <input type="radio" <?php
                                                    if ($shippingmethod->Activated == 1) {
                                                        echo ' checked ';
                                                    }
                                                    ?> id="s-option" name="activated" value="1">
                                                    <label for="s-option">
                                                        فعال
                                                    </label>
                                                </div>

                                                <div class="radio radio-danger">
                                                    <input type="radio" <?php
                                                    if ($shippingmethod->Activated == 0) {
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
                                            <label class="col-sm-12 control-label">
                                                مخصوص :
                                            </label>
                                            <div class="col-sm-12">
                                                <div class="radio radio-danger">
                                                    <input type="radio" <?php
                                                    if (trim($shippingmethod->AllowedCities) == "") {
                                                        echo ' checked ';
                                                    }
                                                    ?> id="s-option2" name="special" value="0">
                                                    <label for="s-option2">
                                                        همگانی
                                                    </label>
                                                </div>

                                                <div class="radio radio-danger">
                                                    <input type="radio" <?php
                                                    if (trim($shippingmethod->AllowedCities) != "") {
                                                        echo ' checked ';
                                                    }
                                                    ?> id="f-option2" name="special" value="1">
                                                    <label for="f-option2">
                                                        مخصوص
                                                    </label>
                                                </div>
                                                <div class="clear-fix"></div>
                                            </div>
                                        </div>

                                        <div class="form-group" style="<?php
                                        if (trim($shippingmethod->AllowedCities) == "") {
                                            echo 'display: none;';
                                        }
                                        ?>" id="the_box">
                                            <label class="col-sm-12 control-label">
                                                استان :
                                            </label>
                                            <div class="col-sm-12">
                                                <select class="form-control m-b" id="cestate" name="cestate">
                                                    <option value="0">انتخاب استان...</option>
                                                    <?php
                                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProvinceDataSource.inc';
                                                    $province = new ProvinceDataSource();
                                                    $province->open();
                                                    $provinces = $province->Fill();
                                                    $province->close();
                                                    foreach ($provinces as $pr) {
                                                        echo "<option value='$pr->ProvinceId' ";
                                                        if ($customer->Estate == $pr->ProvinceId) {
                                                            echo ' selected ';
                                                        }
                                                        echo ">";
                                                        echo $pr->Name;
                                                        echo '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" style="<?php
                                        if (trim($shippingmethod->AllowedCities) == "") {
                                            echo 'display: none;';
                                        }
                                        ?>" id="the_box2">
                                            <label class="col-sm-12 control-label">
                                                شهر :
                                            </label>
                                            <div class="col-sm-12">
                                                <select class="form-control m-b" required id="ccity" name="ccity">
                                                    <option value="0">انتخاب شهر...</option>
                                                </select>
                                            </div>
                                        </div>

                                        <script src="../Template/Scripts/jquery-3.1.1.js"
                                                type="text/javascript"></script>
                                        <div class="form-group" id="the_box2">
                                            <label class="col-sm-12 control-label">

                                            </label>
                                            <div class="col-sm-12" id="samples">
                                                <?php
                                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';
                                                $city = new CityDataSource();
                                                $city->open();
                                                $counter = 0;
                                                $city_ids = explode(",", $shippingmethod->AllowedCities);
                                                foreach ($city_ids as $c) {
                                                    if (trim($c) != "") {
                                                        $counter++;
                                                        echo "<div class='city-sample' id='sample" . $c . "' >" . $city->GetName($c) . "</div>";
                                                        if ($counter % 4 == 0) {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                        <script>
                                                            $(document).ready(function () {
                                                                $('#sample<?php echo trim($c); ?>').click(function () {
                                                                    $(this).fadeOut(250);
                                                                    $('#allowedcities').val("<?php echo str_replace(trim($c . ','), '', $shippingmethod->AllowedCities); ?>");
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: 'SHInsertTheCity.php',
                                                                        data: {cities: $('#allowedcities').val()},
                                                                        success: function (data) {
                                                                            $('#samples').html(data);
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                                }
                                                $city->close();
                                                ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <input type="hidden" id="allowedcities" name="allowedcities"
                                           value="<?php echo $shippingmethod->AllowedCities; ?>"/>
                                    <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                class="fa fa-check"></i><strong>تایید</strong></button>
                                </form>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#f-option2").change(function () {
            if ($(this).is(":checked")) {
                $('#the_box').slideDown(500);
                $('#the_box2').slideDown(500);
            }
        });
        $("#s-option2").change(function () {
            if ($(this).is(":checked")) {
                $('#the_box').slideUp(0);
                $('#the_box2').slideUp(0);
            }
        });
        $("#cestate").change(function () {
            $('#ccity').attr('disabled', '');
            var province = $(this).val();
            $.ajax({
                type: 'POST',
                url: '../AjaxSearch/CUpdateCities.php',
                data: {province: province},
                success: function (data) {
                    $('#ccity').html(data);
                    $('#ccity').removeAttr('disabled', '');

                }
            });
        });

        $('#ccity').change(function () {

            $('#allowedcities').val($('#allowedcities').val() + $(this).val() + ',');
            $.ajax({
                type: 'POST',
                url: 'SHInsertTheCity.php',
                data: {cities: $('#allowedcities').val()},
                success: function (data) {
                    $('#samples').html(data);
                }
            });

        });
    });
</script>
<?php
include_once 'Template/bottom.php';
