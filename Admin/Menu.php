<!DOCTYPE html>
<?php
$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';
if (isset($_GET['id'])) {
    $cm = "edit";
    $p = new MenuDataSource();
    $p->open();
    $menu = $p->FindOneMenuBasedOnId($_GET['id']);
    $p->close();
}
?>
<?php
include_once 'Template/top.php';
?>
<script language="JavaScript" src="AjaxSelect/myminiAJAX.js"></script>
<script language="JavaScript" src="AjaxSelect/functionsjq.js"></script>
<script language="JavaScript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script>
    jQuery().ready(function ($) {


// Ajax Called When Page is Load/Ready (Load Manufacturer)
        jQuery.ajax({
            url: 'AjaxSelect/man_list.php',
            global: false,
            type: "POST",
            dataType: "xml",
            async: false,
            success: populateComp
        });


//Ajax Called When You Change  Manufaturer
        $("#mainmenu").change(function () {
            resetValues();

            var data = {man: $(this).attr('value')};
            jQuery.ajax({
                url: 'AjaxSelect/type_list.php',
                type: "POST",
                dataType: "xml",
                data: data,
                async: false,
                success: populateType
            });
        });

//Ajax Called When You Change Type of Printer
        $("#submenu").change(function () {

            var data = {
                man: $('#mainmenu').val(),
                typ: $(this).attr('value')
            };
            jQuery.ajax({
                url: 'AjaxSelect/model_list.php',
                type: "POST",
                dataType: "xml",
                data: data,
                async: false,
                success: populateModel
            });
        });

//Do What You Want With Result .......... :)
        $("#suppermenu").change(function () {
            //'you select Model='+$('#mainmenu').val()+'type='+$('#submenu').val()+'And Model='+$('#suppermenu').val()                    
        });


    });
</script>
<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>منو</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Menu</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Menus.php?id=<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست منو ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            منو
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <?php
                                if ($cm == "add") {
                                ?>
                                <form action="InsertMenu.php" method="post">
                                    <?php
                                    } elseif ($cm == "edit") {
                                    ?>
                                    <form action="UpdateMenu.php" method="post">
                                        <input type="hidden" id="id" name="id" value="<?php echo $menu->MenuId; ?>"/>
                                        <?php
                                        if (isset($_GET['pid']) == TRUE) {
                                            ?>
                                            <input type="hidden" id="pid" name="pid"
                                                   value="<?php echo $_GET['pid'] ?>"/>
                                            <?php
                                        }
                                        }
                                        ?>
                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    منو اصلی :
                                                </label>
                                                <div class="col-sm-12">
                                                    <select class="form-control m-b" name="mainmenu" id="mainmenu">
                                                        <option value="">منو اصلی را انتخاب کنید...</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    زیر منو :
                                                </label>
                                                <div class="col-sm-12">
                                                    <select class="form-control m-b" name="submenu" id="submenu">
                                                        <option value="">زیر منو را انتخاب کنید...</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    زیر زیر منو :
                                                </label>
                                                <div class="col-sm-12">
                                                    <select class="form-control m-b" name="suppermenu" id="suppermenu">
                                                        <option value="">زیر زیر منو را انتخاب کنید...</option>
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
