<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';

$lds = new LinkBoxDataSource();
$lds->open();
$linkbox = $lds->FindOneLinkBoxBasedOnId($_GET['id']);
$lds->close();
include_once 'Template/top.php';
include_once 'fileman/system.inc.php';
include_once 'fileman/php/functions.inc.php';
?>
<script defer onload="jqueryLoaded()" type="text/javascript" src="fileman/js/jquery.min.js"></script>
<script
defer
src = "fileman/js/jquery-ui-min.js" ></script>
<script src="fileman/js/main.js" type="text/javascript"></script>
<link href="fileman/css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="Scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script>
    tinyMCE.init({
        selector: 'textarea',
        plugins: 'link image fullscreen textcolor contextmenu searchreplace colorpicker',
        imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
        directionality: 'rtl',
        statusbar: true,
        contextmenu: "link image inserttable | cell row column deletetable",
        resize: true,
        toolbar1: "insertfile undo redo | styleselect | fontselect fontsizeselect bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | searchreplace ",
        toolbar2: "  bullist numlist outdent indent | link | image | fullscreen ",
        file_browser_callback: RoxyFileBrowser
    });

    function RoxyFileBrowser(field_name, url, type, win) {
        var roxyFileman = 'fileman/index.html?integration=tinymce4';
        if (roxyFileman.indexOf("?") < 0) {
            roxyFileman += "?type=" + type;
        }
        else {
            roxyFileman += "&type=" + type;
        }
        roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
        if (tinyMCE.activeEditor.settings.language) {
            roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
        }
        tinyMCE.activeEditor.windowManager.open({
            file: roxyFileman,
            title: 'Roxy Fileman',
            width: 850,
            height: 650,
            resizable: "yes",
            plugins: "media",
            inline: "yes",
            close_previous: "no"
        }, {window: win, input: field_name});
        return false;
    }
</script>
<?php
include_once 'Template/menu.php';
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>محتوای پیوند</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Link Contents</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="LinkBoxes.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست پیوند ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            محتوای پیوند
                        </div>
                        <div class="panel-body">
                            <form action="UpdateLinkContent.php" method="post">
                                <input type="hidden" id="id" name="id" value="<?php echo $linkbox->LinkBoxId; ?>"/>
                                <?php
                                if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                                    $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/PostImages/";
                                } else {
                                    $_SESSION[SESSION_PATH_KEY] = "PostImages/";
                                }
                                ?>
                                <fieldset class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">
                                            <?php echo $linkbox->Name; ?> :
                                        </label>
                                        <div class="col-sm-12">
                                                <textarea id="content" name="content" rows="17" class="WideText"
                                                          cols="20"><?php echo $linkbox->Content; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">
                                            وضعیت :
                                        </label>
                                        <div class="col-sm-12">
                                            <div class="radio radio-danger">
                                                <input type="radio" <?php if ($linkbox->HaveForm == 0) {
                                                    echo 'checked';
                                                } ?> id="s-option" name="contactus" value="0">
                                                <label for="s-option">
                                                    بدون فرم
                                                </label>
                                            </div>

                                            <div class="radio radio-danger">
                                                <input type="radio" <?php if ($linkbox->HaveForm == 1) {
                                                    echo 'checked';
                                                } ?> id="f-option" name="contactus" value="1">
                                                <label for="f-option">
                                                    با فرم تماس با ما
                                                </label>
                                            </div>
                                            <div class="clear-fix"></div>
                                        </div>
                                    </div>
                                </fieldset>
                                <!--                                        <input type="submit" class="Save" value=""/>-->
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
