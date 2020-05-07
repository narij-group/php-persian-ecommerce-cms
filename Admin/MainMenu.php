<!DOCTYPE html>
<?php

$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';

$mainmenu = new MainMenu();
if (isset($_GET['id'])) {
    $cm = "edit";
    $p = new MainMenuDataSource();
    $p->open();
    $mainmenu = $p->FindOneMainMenuBasedOnId($_GET['id']);
}
?>
<?php
include_once 'Template/top.php';
?>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#group").select2({
            placeholder: "انتخاب کنید...",
            dir: "rtl"
        });
    });
</script>
<?php

if ($role->MenuSettings != 1) {
    header('Location:Index.php');
    die();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
$group = new GroupDataSource();
$group->open();
$groups = $group->Fill();
$group->close();
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>منوی اصلی</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Main Menu</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="MainMenus.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست منوی های اصلی
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            منوی اصلی
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateMainMenu.php" method="post">
                                    <input type="hidden" id="id" name="id" value="<?php echo $p->MainMenuId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام منو اصلی :
                                            </label>
                                            <div class="col-sm-12">
                                                <select required="" id="group" name="group" class="form-control m-b" style="width: 100%;">
                                                    <option></option>
                                                    <?php
                                                    foreach ($groups as $g) {
                                                        echo '<option ';
                                                        if ($g->GroupId == $mainmenu->Group->GroupId) {
                                                            echo ' selected ';
                                                        }
                                                        echo ' value=' . $g->GroupId . '>';
                                                        echo $g->Name;
                                                        echo '</option>';
                                                    }
                                                    ?>
                                                </select>
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
