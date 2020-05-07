<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
include_once 'Template/top.php';
$subgroup = new SubGroup();
$group = new Group();
$gds = new GroupDataSource();
$gds->open();
$groups = $gds->Fill();
$gds->close();

if (isset($_GET['id'])) {
    if ($role->EditSubGroup != 1) {
        header('Location:Index.php');
        die();
    }
    $sgds = new SubGroupDataSource();
    $sgds->open();
    $subgroup = $sgds->FindOneSubGroupBasedOnId($_GET['id']);
    $sgds->close();

} else {
    if ($role->InsertSubGroup != 1) {
        header('Location:Index.php');
        die();
    }
}

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
//            $('#roxyCustomPanel2').dialog('close');
            $('#closeModal').click(function(){return true;}).click();
        }
    </script>
<?php
include_once 'Template/menu.php';
?>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-6">
            <h2>زیرمجموعه</h2>
        </div>
        <div class="col-lg-6 title-en">
            <h2>Sub Group</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <a href="SubGroups.php">
                            <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                                لیست زیرمجموعه ها
                            </button>
                        </a>

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                زیرمجموعه
                            </div>
                            <div class="panel-body">

                                <div class="alert alert-warning">
                                    توجه : اندازه تصویر نباید کمتر از 300x300 باشد، در غیر این صورت کیفیت خود را از دست خواهد
                                    دهد.
                                    <br>
                                    دقت کنید که طول و عرض تصاویر با یکدیگر برابر باشند.
                                </div>

                                <div class="Inputs">

                                    <?php
                                    if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                                        $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV2/MainCatImage/SubGroup/";
                                    } else {
                                        $_SESSION[SESSION_PATH_KEY] = "MainCatImage/SubGroup/";
                                    }
                                    ?>

                                    <form action="operateSubGroup.php" method="post">
                                        <input type="hidden" id="id" name="id"
                                               value="<?php echo $subgroup->SubGroupId; ?>"/>
                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    نام:
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                           value="<?php echo $subgroup->Name; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    نام لاتین:
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="Text" class="form-control input-sm m-b-xs" id="latinname"
                                                           name="latinname"
                                                           value="<?php echo $subgroup->LatinName; ?>"/>
                                                </div>
                                            </div>

                                            <?php
                                            $mainCat_checked = "";
                                            if ($subgroup->PlaceAsMainCat == 1) {
                                                $mainCat_checked = " checked";
                                            }
                                            ?>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="checkbox checkbox-danger">
                                                        <input type="checkbox" value="1" id="maincat"
                                                               name="maincat" <?php echo $mainCat_checked; ?>/>
                                                        <label for="maincat">
                                                            قرار گرفتن در دسته بندی صفحه اصلی
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    تصویر :
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control input-sm m-b-xs" id="image" name="image"
                                                           readonly="readonly"
                                                           value="<?php echo $subgroup->Image; ?>"
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
                                                    گروه:
                                                </label>
                                                <div class="col-sm-12">
                                                    <?php
                                                    echo "<select  class='form-control m-b' name='group' id='group' >";
                                                    foreach ($groups as $l) {
                                                        echo "<option value = '$l->GroupId'";
                                                        if ($l->GroupId == $subgroup->Group->GroupId) {
                                                            echo " selected >$l->Name - $l->LatinName</option>";
                                                        } else {
                                                            echo ">$l->Name - $l->LatinName</option>";
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
