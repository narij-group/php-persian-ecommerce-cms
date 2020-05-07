<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ThumbDataSource.inc';
$thumb = new Thumb();
$cm = "add";
if (isset($_GET['id'])) {
    if ($role->EditThumb != 1) {
        header('Location:Index.php');
        die();
    }

    $cm = "edit";
    $t = new ThumbDataSource();
    $t->open();
    $t->ThumbId = $_GET['id'];
    $thumb = $t->FindOneThumbBasedOnId($_GET['id']);
    $t->close();
} else {
    if ($role->InsertThumb != 1) {
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
            <h2>ریز عکس</h2>
        </div>
        <div class="col-lg-6 title-en">
            <h2>Thumb</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <a href="Thumbs.php">
                            <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                                لیست ریز عکس ها
                            </button>
                        </a>

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                ریز عکس
                            </div>
                            <div class="panel-body">

                                <div class="alert alert-warning">
                                    توجه : اندازه تصویر باید 325x280 باشد، در غیر این صورت کیفیت خود را از دست خواهد
                                    دهد.
                                </div>

                                <div class="Inputs">

                                    <?php
                                    if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                                        $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/ThumbImage/";
                                    } else {
                                        $_SESSION[SESSION_PATH_KEY] = "ThumbImage/";
                                    }
                                    ?>

                                    <form action="operateThumb.php" method="post">
                                        <input type="hidden" id="id" name="id"
                                               value="<?php echo $thumb->ThumbId; ?>"/>
                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    نام:
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                           value="<?php echo $thumb->Name; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    تصویر :
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control input-sm m-b-xs" id="image" name="image"
                                                           readonly="readonly"
                                                           value="<?php echo $thumb->Image; ?>"
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
                                                    لینک صفحه:
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control input-sm m-b-xs" id="link" name="link"
                                                           value="<?php echo $thumb->Link; ?>"/>
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
