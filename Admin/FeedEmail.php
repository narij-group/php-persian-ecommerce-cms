<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';
include_once 'fileman/system.inc.php';
include_once 'fileman/php/functions.inc.php';
if ($role->FeedSendEmail != 1) {
    header('location:Feeds.php');
}
?>
<script defer onload="jqueryLoaded()" type="text/javascript" src="fileman/js/jquery.min.js"></script>
<script defer src = "fileman/js/jquery-ui-min.js" ></script>
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
        <h2>ایمیل</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Email</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Feeds.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست خبرنامه ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            ایمیل
                        </div>
                        <div class="panel-body">

                            <div class="alert alert-warning">
                                <fieldset class="form-horizontal">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-danger">
                                                <input type="checkbox" value="0" id="customer"
                                                       name="customer" />
                                                <label for="customer">
                                                    ارسال برای مشتری ها
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-danger">
                                                <input type="checkbox" value="1" id="feed"
                                                       name="feed" checked />
                                                <label for="feed">
                                                    ارسال برای کاربران عضو خبرنامه
                                                </label>
                                            </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="Inputs">
                                <form action="SendFeedEmail.php" method="get">
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
                                                متن ایمیل :
                                            </label>
                                            <div class="col-sm-12" id="content">
                                                <textarea id="emailcontent" name="emailcontent" rows="17"
                                                          class="form-control input-sm m-b-xs" cols="20"></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                class="fa fa-at"></i><i
                                                class="fa fa-mail-forward"></i><strong>ارسال</strong></button>
                                </form>
                            </div>
                            <br/>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php
include_once 'Template/bottom.php';
