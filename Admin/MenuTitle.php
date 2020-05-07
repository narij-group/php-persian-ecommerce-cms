<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
$menutitle = new MenuTitle();
if (isset($_GET['id'])) {
    $p = new MenuTitleDataSource();
    $p->open();
    $menutitle = $p->FindOneMenuTitleBasedOnId($_GET['id']);
    $p->close();
}
?>
<?php
include_once 'Template/top.php';
?>
<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#submenu").select2({
            placeholder: "زیر منو را انتخاب کنید...",
            dir: "rtl"
        });
    });
</script>
<?php

if ($role->MenuSettings != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>عنوان منو</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Menu Title</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="MenuTitles.php">
                        <button class="btn btn-info MenuTitle.php" type="button"><i class="fa fa-list-ol"></i>
                            لیست عنوان منو ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            عنوان منو
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateMenuTitle.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $menutitle->MenuTitleId; ?>"/>
                                    <div class="alert alert-warning">
                                        <i class="fa fa-exclamation-circle"></i>ستون باید بین 1-4 باشد
                                    </div>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                عنوان :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php echo $menutitle->Name; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                ستون :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Number" max="4" min="1" class="form-control input-sm m-b-xs" id="column"
                                                       name="column"
                                                       value="<?php echo $menutitle->Column; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                زیر منو :
                                            </label>
                                            <div class="col-sm-12">
                                                <?php
                                                $submenu = new SubMenuDataSource();
                                                $submenu->open();
                                                $submenus = $submenu->Fill();
                                                $submenu->close();
                                                echo "<select class='form-control m-b' name='submenu' id='submenu' style='width: 100%;' >";
                                                echo "<option></option>";
                                                foreach ($submenus as $s) {
                                                    echo "<option value = '$s->SubMenuId'";
                                                    if ($s->SubMenuId == $menutitle->SubMenu->SubMenuId) {
                                                        echo " selected >" . $s->SubGroup->Name . "</option>";
                                                    } else {
                                                        echo ">" . $s->SubGroup->Name . "</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <button class="btn btn-primary MenuTitle.php pull-right" type="submit"><i
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
