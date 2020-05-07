<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
include_once 'Template/top.php';

$spgds = new SupperGroupDataSource();
$spgds->open();
$suppergroups = $spgds->Fill();
$suppergroupId = $spgds->FirstId();
$spgds->close();

if (isset($_COOKIE[COOKIE_SUPPER_GROUP_ID])) {
    $suppergroupId = $_COOKIE[COOKIE_SUPPER_GROUP_ID];
}
$go_on = TRUE;

$temps = explode(',', $role->AllowedProductPropertySubGroups);
$i = 0;
$SupGroups = array();
foreach ($temps as $t) {
    if (trim($t) != "") {
        $SupGroups[$i] = $t;
        $i++;
    }
}


if (in_array($suppergroupId, $SupGroups)) {
    foreach ($suppergroups as $sg) {
        if (in_array($sg->SupperGroupId, $SupGroups) && $go_on == TRUE) {
            $go_on = FALSE;
            $suppergroupId = $sg->SupperGroupId;
        }
    }
}

$ppds = new ProductPropertyDataSource();
$ppds->open();
$productProperties = $ppds->FindOneSupperGroupRecords($suppergroupId);
$ppds->close();
?>
<?php
if ($role->ProductProperties != 1) {
    header('Location:Index.php');
    die();
}
?>
<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $("#suppergroup").select2({
            placeholder: "زیر زیرمجموعه را انتخاب کنید...",
            dir: "rtl"
        });
    });
</script>
<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>ویژگی های محصولات</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Product Properties</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست ویژگی های محصولات</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-sitemap"></i> انتخاب زیر زیرمجموعه
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <select id="suppergroup" name="suppergroup" class="form-control m-b" style="width: 100%">
                                    <?php
                                    if ($role->ProductPropertySubGroupLimit == 1) {
                                        foreach ($suppergroups as $g) {
                                            if (in_array($g->SupperGroupId, $SupGroups)) {
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
                                افزودن ویژگی جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>
                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                           placeholder="جستجو در لیست موجود در این صفحه">
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
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> نام</th>
                                <th> محتوا</th>
                                <!--                    <th> زیر زیرمجموعه</th>-->
                                <?php
                                if ($role->EditProductProperty == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteProductProperty == 1) {
                                    ?>
                                    <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($productProperties as $p) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->ProductPropertyId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
                                if ($role->EditProductProperty == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='ProductProperty.php?id=" . $p->ProductPropertyId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteProductProperty == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a  onclick='return deleteConfirm()' href='operateProductProperty.php?id=" . $p->ProductPropertyId . "'>" . "حذف" . "</a></button></td>";
                                }
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
            $('#add').attr('href', 'ProductProperty.php?gid=<?php echo $suppergroupId; ?>');
            $.ajax({
                type: 'POST',
                url: 'AjaxProductProperties.php',
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
    