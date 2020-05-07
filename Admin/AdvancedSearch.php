<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
include_once 'Template/top.php';

$suppergroup = new SupperGroupDataSource();
$suppergroup->open();
$suppergroups = $suppergroup->Fill();
$suppergroupId = $suppergroup->FirstId();
$suppergroup->close();

$productProperty = new ProductPropertyDataSource();
if (isset($_COOKIE[COOKIE_SUPPER_GROUP_ID])) {
    $suppergroupId = $_COOKIE[COOKIE_SUPPER_GROUP_ID];
}
$go_on = TRUE;
if (strpos($role->AllowedProductPropertySubGroups, $suppergroupId) == false) {
    foreach ($suppergroups as $sg) {
        if (strpos($role->AllowedProductPropertySubGroups, $sg->SupperGroupId) != false && $go_on == TRUE) {
            $go_on = FALSE;
            $suppergroupId = $sg->SupperGroupId;
        }
    }
}
$productProperty->open();
$productProperties = $productProperty->FindOneSupperGroupRecords($suppergroupId);
$productProperty->close();
?>
<?php
if ($role->ProductProperties != 1) {
    header('Location:Index.php');
    die();
}
?>
<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<script src="select2/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {

        $("#suppergroup").select2({
            placeholder: "زیر زیرمجموعه را انتخاب کنید...",
            dir: "rtl"
        });

        $('.acheck').change(function () {
            $(".th-loader").fadeIn(0)
            if ($(this).is(':checked')) {
                $(this).attr('disabled', "");
                $.ajax({
                    type: "POST",
                    url: "AjaxSearchSelection.php",
                    data: {id: $(this).val(), search_value: 1},
                    success: function () {
                        $(".th-loader").fadeOut(0)
//                        $("#success-msg").fadeIn(250);
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            positionClass: 'toast-top-left',
                            timeOut: 5000
                        };
                        toastr.success('انتخاب شما ذخیره شد!', 'پیام');
                        setTimeout(function () {
                            $("#success-msg").fadeOut(250);
                        }, 1000);
                    }
                });
            }
            else {
                $(this).attr('disabled', "");
                $.ajax({
                    type: "POST",
                    url: "AjaxSearchSelection.php",
                    data: {id: $(this).val(), search_value: 0},
                    success: function () {
                        $(".th-loader").fadeOut(0)
                        $("#success-msg").fadeIn(250);
                        setTimeout(function () {
                            $("#success-msg").fadeOut(250);
                        }, 1000);
                    }
                });
            }
            $(this).removeAttr('disabled', '');
        });
    });
</script>
<style>
    .checkboxFour input, .checkboxFour2 input {
        font-size: 0;
    }

    .checkboxFour, .checkboxFour2,.checkbox-circle {
        z-index: 1;

        /*width: 30px;*/
        /*height: 30px;*/

        /*background: #ddd;*/
        /*border-radius: 100%;*/

        position: relative;
        top: -15px;
        right: -10px;
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
<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>جستجوی پیشرفته</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Advanced Search</h2>
    </div>
</div>

<!--<div class="success-message" id="success-msg">انتخاب شما ذخیره شد!</div>-->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            انتخاب زیر زیرمجموعه
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <select id="suppergroup" name="suppergroup" class="form-control m-b" style="width: 100%;">
                                    <?php
                                    if ($role->ProductPropertySubGroupLimit == 1) {
                                        foreach ($suppergroups as $g) {
                                            if (strpos($role->AllowedProductPropertySubGroups, $g->SupperGroupId) != false) {
                                                echo '<option ';
                                                if (isset($_COOKIE[COOKIE_SUPPER_GROUP_ID])) {
                                                    if ($_COOKIE[COOKIE_SUPPER_GROUP_ID] == $g->SupperGroupId) {
                                                        echo ' selected ';
                                                    }
                                                }
                                                echo ' value=' . $g->SupperGroupId . '>';
                                                echo "( " . $g->Name . " ) " . $g->LatinName;
                                                echo '</option>';
                                            }
                                        }
                                    } else {
                                        foreach ($suppergroups as $g) {
                                            echo '<option ';
                                            if (isset($_COOKIE[COOKIE_SUPPER_GROUP_ID])) {
                                                if ($_COOKIE[COOKIE_SUPPER_GROUP_ID] == $g->SupperGroupId) {
                                                    echo ' selected ';
                                                }
                                            }
                                            echo ' value=' . $g->SupperGroupId . '>';
                                            echo "( " . $g->Name . " ) " . $g->LatinName;
                                            echo '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php
                    if ($role->InsertProductProperty == 1) {
                        ?>
                        <a id="add" href="ProductProperty.php?gid=<?php
                        if (isset($_COOKIE[COOKIE_SUPPER_GROUP_ID])) {
                            echo $_COOKIE[COOKIE_SUPPER_GROUP_ID];
                        } else {
                            echo $suppergroupId;
                        }
                        ?>">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن ویژگی محصول جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <div class="Database" id="db">
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
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th class="choose-th">انتخاب<img class="th-loader"
                                                                 src="Template/Images/gifs/loading.gif"/></th>
                                <th> نام</th>
                                <th data-hide="phone,tablet"> محتوا</th>
                                <!--                    <th> زیر زیرمجموعه</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($productProperties as $p) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' ></div>";
                                echo "<div class='checkbox checkbox-info checkbox-circle' ><input type = 'checkbox' ";
                                if ($p->Search == 1) {
                                    echo ' checked ';
                                }
                                echo " value = '" . $p->ProductPropertyId . "' id = 'check" . $p->ProductPropertyId . "' ";
                                echo " class='acheck' /><label for='check" . $p->ProductPropertyId . "' ></label ></div > ";
                                echo "</div >";
                                echo "</td>";
                                echo "<td><div class='DatabaseField' >" . $p->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                            <!--                        <tfoot  style="direction: ltr">-->
                            <!--                        <tr>-->
                            <!--                            <td colspan="5">-->
                            <!--                                <ul class="pagination pull-right"></ul>-->
                            <!--                            </td>-->
                            <!--                        </tr>-->
                            <!--                        </tfoot>-->
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#suppergroup").change(function () {
            var suppergroup = $(this).val();
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'AjaxProductProperties2.php',
                data: {suppergroup: suppergroup},
                success: function (data) {
                    $('#db').html(data);
                    $("#wait").fadeOut(0);
                }
            });
        });
    });
</script>
<?php
include_once 'Template/bottom.php';
