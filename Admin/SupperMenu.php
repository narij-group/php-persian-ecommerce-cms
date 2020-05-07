<!DOCTYPE html>
<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->Fill();
$mainmenu->close();

$submenus = array();
$titles = array();
$suppergroups = array();
$suppermenu = new SupperMenu();

if (isset($_GET['id'])) {
    $p = new SupperMenuDataSource();
    $p->open();
    $suppermenu = $p->FindOneSupperMenuBasedOnId($_GET['id']);
    $p->close();

    $submenu = new SubMenuDataSource();
    $submenu->open();
    $submenus = $submenu->getOneMainMenuSubMenus($suppermenu->MainMenu->MainMenuId);
    $submenu->close();

    $title = new MenuTitleDataSource();
    $title->open();
    $titles = $title->getOneSubMenuTitles($suppermenu->SubMenu->SubMenuId);
    $title->close();

    $suppergroup = new SupperGroupDataSource();
    $suppergroup->open();
    $suppergroups = $suppergroup->FillBySubgroup($suppermenu->SubMenu->SubGroup);
    $suppergroup->close();
}
?>
<?php
if ($role->MenuSettings != 1) {
    header('Location:Index.php');
    die();
}
?>
<!--<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>-->
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    //    alert("mm");
    $(document).ready(function () {
//        alert("mm1");
//        $("#mainmenu").select2({
//            placeholder: "منوی اصلی را انتخاب کنید...",
//            dir: "rtl"
//        });
//
//        $("#submenu").select2({
//            placeholder: "زیر منو را انتخاب کنید...",
//            dir: "rtl"
//        });
//
//        $("#suppergroup").select2({
//            placeholder: "زیر زیرمنو را انتخاب کنید...",
//            dir: "rtl"
//        });
//
//        $("#title").select2({
//            placeholder: "عنوان را انتخاب کنید...",
//            dir: "rtl"
//        });

        $("#mainmenu").change(function () {
//            alert("a");
            var mainmenu = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'RefreshSubmenus2.php',
                data: {mainmenu: mainmenu},
                success: function (data) {
//                    alert(data);
                    $('#submenu-td').html(data);
                }
            });
        });
    });
</script>
<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>زیر زیرمنو</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Supper Menu</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="SupperMenus.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست زیر زیرمنو ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            زیر زیرمنو
                        </div>
                        <div class="panel-body">

                            <!--        <div class="tip3"> اگر یک "زیر منو" ، "زیر زیر منو" ندارد ، کافی است زیر زیر منو را با عنوانی دلخواه و نام زیر-->
                            <!--            زیر منو "ندارد" ذخیره کنید تا نمایش داده نشود. <img src="Template/Images/warning.png"/></div>-->
                            <div class="Inputs">
                                <form action="operateSupperMenu.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $suppermenu->SupperMenuId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                منو اصلی :
                                            </label>
                                            <div class="col-sm-12">
                                                <?php
                                                echo "<select  class='form-control m-b' required name='mainmenu' id='mainmenu' >";
                                                echo "<option></option>";
                                                foreach ($mainmenus as $m) {
                                                    echo "<option value = '$m->MainMenuId'";
                                                    if ($m->MainMenuId == $suppermenu->MainMenu->MainMenuId) {
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
                                                زیر منو :
                                            </label>
                                            <div class="col-sm-12" id="submenu-td">
                                                <?php
                                                echo "<select ";
                                                if ($cm == 'add') {
                                                    echo ' disabled ';
                                                }
                                                echo "class='form-control m-b' required name='submenu' id='submenu' >";
                                                echo "<option></option>";
                                                foreach ($submenus as $sg) {
                                                    echo "<option value = '$sg->SubMenuId'";
                                                    if ($sg->SubMenuId == $suppermenu->SubMenu->SubMenuId) {
                                                        echo " selected >" . $sg->SubGroup->Name . "</option>";
                                                    } else {
                                                        echo ">" . $sg->SubGroup->Name . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                عنوان :
                                            </label>
                                            <div class="col-sm-12" id="title-td">
                                                <?php
                                                echo "<select ";
                                                if ($cm == 'add') {
                                                    echo ' disabled ';
                                                }
                                                echo "class='form-control m-b' required name='title' id='title' >";
                                                echo "<option></option>";
                                                foreach ($titles as $t) {
                                                    echo "<option value = '$t->MenuTitleId' ";
                                                    if ($t->MenuTitleId == $suppermenu->Title->MenuTitleId) {
                                                        echo " selected >$t->Name</option>";
                                                    } else {
                                                        echo ">" . $t->Name . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام زیر زیرمنو :
                                            </label>
                                            <div class="col-sm-12" id="suppergroup-td">
                                                <?php
                                                echo "<select ";
                                                if ($cm == 'add') {
                                                    echo ' disabled ';
                                                }
                                                echo "class='form-control m-b' required name='suppergroup' id='suppergroup' >";
                                                echo "<option></option>";
                                                //                                echo "<option value='0' >ندارد</option>";
                                                foreach ($suppergroups as $t) {
                                                    echo "<option value = '$t->SupperGroupId'";
                                                    if ($t->SupperGroupId == $suppermenu->SupperGroup->SupperGroupId) {
                                                        echo " selected >$t->Name</option>";
                                                    } else {
                                                        echo ">" . $t->Name . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
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
