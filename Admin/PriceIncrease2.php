<!DOCTYPE html>
<?php
include_once 'Template/top.php';
if ($role->PriceChange != 1) {
    header('Location:Index.php');
    die();
}
?>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#group").select2({
            placeholder: "مجموعه را انتخاب کنید...",
            dir: "rtl"
        });
        $("#subgroup").select2({
            placeholder: "زیر مجموعه را انتخاب کنید...",
            dir: "rtl"
        });
        $("#suppergroup").select2({
            placeholder: "زیر زیرمجموعه را انتخاب کنید...",
            dir: "rtl"
        });
        $("#brand").select2({
            placeholder: "برند محصول را انتخاب کنید...",
            dir: "rtl"
        });
    });
</script>
<?php
include_once 'Template/menu.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LogoDataSource.inc';
$group = new GroupDataSource();
$group->open();
$brand = new LogoDataSource();
$brand->open();
$groups = $group->Fill();
$groupId = $group->FirstId();
$brands = $brand->Fill();

$group->close();
$brand->close();

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>تغییر قیمت</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Price Change</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Prices.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست قیمت ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            تغییر قیمت
                        </div>
                        <div class="panel-body">

                            <div class="alert alert-warning">
                                توجه : برای کاهش قیمت کافی است آن را منفی وارد کنید. ( مثال : -10 )
                            </div>
                            <div class="Inputs">
                                <form action="ChangePrices2.php" method="post">
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                مجموعه :
                                            </label>
                                            <div class="col-sm-12">
                                                <select required="" id="group" name="group" class='form-control m-b' style="width: 100%;">
                                                    <option></option>
                                                    <?php
                                                    foreach ($groups as $g) {
                                                        echo '<option ';
                                                        echo ' value=' . $g->GroupId . '>';
                                                        echo "( " . $g->Name . " ) " . $g->LatinName;
                                                        echo '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                زیر مجموعه :
                                            </label>
                                            <div class="col-sm-12" id="subgroup-td">
                                                <select id="subgroup" disabled="" name="subgroup" class='form-control m-b' style="width: 100%;">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                زیر زیرمجموعه :
                                            </label>
                                            <div class="col-sm-12" id="suppergroup-td">
                                                <select id="suppergroup" disabled="" name="suppergroup"
                                                        class='form-control m-b' style="width: 100%;">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                برند :
                                            </label>
                                            <div class="col-sm-12">
                                                <select id="brand" name="brand" class='form-control m-b' style="width: 100%;">
                                                    <option></option>
                                                    <?php
                                                    foreach ($brands as $g) {
                                                        echo '<option ';
                                                        echo ' value=' . $g->LogoId . '>';
                                                        echo "( " . $g->Name . " ) " . $g->LatinName;
                                                        echo '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                میزان افزایش :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="number" placeholder='چند درصد...؟' class="form-control input-sm m-b-xs"
                                                       id="value" name="value"/>
                                            </div>
                                        </div>
                                    </fieldset>
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
        $("#group").change(function () {
            var group = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'RefreshSubgroups.php',
                data: {group: group},
                success: function (data) {
                    $('#subgroup-td').html(data);
                }
            });
        });
    });
</script>
<?php
include_once 'Template/bottom.php';
