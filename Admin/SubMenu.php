<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';


$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->Fill();
$mainmenu->close();
$submenu = new SubMenu();
if (isset($_GET['id'])) {
    $p = new SubMenuDataSource();
    $p->open();
    $submenu = $p->FindOneSubMenuBasedOnId($_GET['id']);
    $p->close();

    $subgroup = new SubGroupDataSource();
    $subgroup->open();
    $subgroups = $subgroup->FillByGroup($submenu->MainMenu->Group);
    $subgroup->close();
}
?>
<?php
include_once 'Template/top.php';

if ($role->MenuSettings != 1) {
    header('Location:Index.php');
    die();
}
include_once 'fileman/system.inc.php';
include_once 'fileman/php/functions.inc.php';
?>
<!--<script defer onload="jqueryLoaded()" type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<script defer src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script src="fileman/js/main.js" type="text/javascript"></script>

<link href="fileman/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css"/>
<link href="fileman/css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
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
        <h2>زیرمنو</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Sub Menu</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="SubMenus.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست زیرمنو ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            زیرمنو
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <?php
                                if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                                    $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/SubMenuImages/";
                                } else {
                                    $_SESSION[SESSION_PATH_KEY] = "SubMenuImages/";
                                }
                                ?>

                                <form action="operateSubMenu.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $submenu->SubMenuId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <script src="../Template/Scripts/jquery-3.1.1.js"
                                                type="text/javascript"></script>
                                        <link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
                                        <script src="select2/dist/js/select2.min.js"></script>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
//                                $("#mainmenu").select2({
//                                    placeholder: "منوی اصلی را انتخاب کنید...",
//                                    dir: "rtl"
//                                });
//
//                                $("#subgroup").select2({
//                                    placeholder: "زیر منو را انتخاب کنید...",
//                                    dir: "rtl"
//                                });

                                                $("#mainmenu").change(function () {
                                                    var mainmenu = $(this).val();
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'RefreshSubgroups5.php',
                                                        data: {mainmenu: mainmenu},
                                                        success: function (data) {
                                                            //alert(data);
                                                            $('#subgroup-td').html(data);
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                منو اصلی :
                                            </label>
                                            <div class="col-sm-12">
                                                <?php
                                                echo "<select class='form-control m-b' required name='mainmenu' id='mainmenu' >";
                                                echo "<option></option>";
                                                foreach ($mainmenus as $m) {
                                                    echo "<option value = '$m->MainMenuId'";
                                                    if ($m->Group->GroupId == $submenu->MainMenu->Group) {
                                                        echo " selected >" . $m->Group->Name . "</option>";
                                                    } else {
                                                        echo ">" . $m->Group->Name . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام زیر منو :
                                            </label>
                                            <div class="col-sm-12" id="subgroup-td">
                                                <?php
                                                echo "<select ";
                                                if ($cm == 'add') {
                                                    echo ' disabled ';
                                                }
                                                echo "class='form-control m-b' required name='subgroup' id='subgroup' >";
                                                echo "<option></option>";
                                                foreach ($subgroups as $sg) {
                                                    echo "<option value = '$sg->SubGroupId'";
                                                    if ($sg->SubGroupId == $submenu->SubGroup->SubGroupId) {
                                                        echo " selected >$sg->Name</option>";
                                                    } else {
                                                        echo ">" . $sg->Name . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                تصویر :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control input-sm m-b-xs" id="image" name="image"
                                                       readonly="readonly"
                                                       value="<?php echo $submenu->Image; ?>"
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
<?php
include_once 'Template/bottom.php';
