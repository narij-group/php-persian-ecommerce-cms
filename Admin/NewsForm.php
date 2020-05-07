<!DOCTYPE html>
<?php
include_once 'Template/top.php';
$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/NewsDataSource.inc';


$new = new News();
if (isset($_GET['id'])) {
    if ($role->EditNews != 1) {
        header('Location:Index.php');
        die();
    }
    $cm = "edit";
    $uds = new NewsDataSource();
    $uds->open();
    $new = $uds->FindOneNewsBasedOnId($_GET['id']);
    $uds->close();
} else {
    if ($role->InsertNews != 1) {
        header('Location:Index.php');
        die();
    }
}
?>
<?php
include_once 'fileman/system.inc.php';
include_once 'fileman/php/functions.inc.php';
?>

<link href="fileman/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css"/>
<link href="fileman/css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">


<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>

<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script language="JavaScript" src="AjaxSelect/myminiAJAX.js"></script>
<script language="JavaScript" src="AjaxSelect/functionsjq.js"></script>
<!--<script language="JavaScript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>-->
<script>
    function openCustomRoxy2() {
        $('#roxyCustomPanel2').dialog({modal: true, width: 875, height: 600});
    }

    function closeCustomRoxy2() {
        $.ajax({
            type: 'POST',
            url: 'RefreshImage.php',
            data: {Image: $('#image').val()},
            success: function (data) {
                $("#Filemanager2").fadeOut(250);
                $("#modalback").fadeOut(250);
                $('.SelectBoxContainer').html(data);
                $('#roxyCustomPanel2').dialog('close');
                $('#closeModal').click(function () {
                    return true;
                }).click();
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#metadescription').on('input', function () {
            $.ajax({
                type: 'POST',
                url: 'AjaxMetaStatus.php',
                data: {
                    chars: $('#metadescription').val().length
                },
                success: function (data) {
                    $('#mdstatus').html(data);
                }

            });
        });
        <?php
        if ($cm == 'edit') {
        ?>
        $.ajax({
            type: 'POST',
            url: 'AjaxMetaStatus.php',
            data: {
                chars: $('#metadescription').val().length
            },
            success: function (data) {
                $('#mdstatus').html(data);
            }

        });
        $.ajax({
            type: 'POST',
            url: 'AjaxMetaStatus2.php',
            data: {
                value: $('#keywords').val()
            },
            success: function (data) {
                $('#mkstatus').html(data);
            }

        });
        <?php
        }
        ?>
        $(".Default").click(function () {
            $("#Filemanager").fadeIn(250);
            $("#modalback").fadeIn(250);
        });
        $("#filemanagerbtn2").click(function () {
            $("#Filemanager2").fadeIn(250);
//            $("#modalback").fadeIn(250);
        });
        $("#filemanagercloser2").click(function () {
            $("#Filemanager2").fadeOut(250);
            $("#modalback").fadeOut(250);
        });
        $("#modalback").click(function () {
            $("#wait").css("display", "block");
            $("#Filemanager").fadeOut(250);
            $("#Filemanager2").fadeOut(250);
            $("#modalback").fadeOut(500);
        });
        $('#keywords').on('input', function () {
            $.ajax({
                type: 'POST',
                url: 'AjaxMetaStatus2.php',
                data: {
                    value: $('#keywords').val()
                },
                success: function (data) {
                    $('#mkstatus').html(data);
                }

            });
        });
    });
</script>
<script>
    tinyMCE.init({
        selector: '.tiny',
        plugins: 'link image fullscreen textcolor contextmenu searchreplace colorpicker media lineheight',
        imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
        directionality: 'rtl',
        statusbar: true,
        height: 400,
        media_live_embeds: true,
        media_url_resolver: function (data, resolve/*, reject*/) {
            if (data.url.indexOf('YOUR_SPECIAL_VIDEO_URL') !== -1) {
                var embedHtml = '<iframe src="' + data.url +
                    '" width="400" height="400" ></iframe>';
                resolve({html: embedHtml});
            } else {
                resolve({html: ''});
            }
        },
        video_template_callback: function (data) {
            return '<video width="' + data.width + '" height="' + data.height + '"' + (data.poster ? ' poster="' + data.poster + '"' : '') + ' controls="controls">\n' + '<source src="' + data.source1 + '"' + (data.source1mime ? ' type="' + data.source1mime + '"' : '') + ' />\n' + (data.source2 ? '<source src="' + data.source2 + '"' + (data.source2mime ? ' type="' + data.source2mime + '"' : '') + ' />\n' : '') + '</video>';
        },
        contextmenu: "link image inserttable | cell row column deletetable",
        resize: true,
        toolbar1: "insertfile undo redo | styleselect | fontselect fontsizeselect bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | searchreplace ",
        toolbar2: "  bullist numlist outdent indent | link | image | fullscreen | media | lineheightselect ",
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
<?php include_once 'Template/menu.php'; ?>
<div class="modalback" id="modalback"></div>
<div></div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>خبر</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>News</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight ecommerce">

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1"> خبر</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2"> متن خبر</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3"> تصویر</a></li>

                </ul>

                <div class="Inputs">
                    <?php
                    if ($cm == "add") {
                    if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                        $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/News/";
                    } else {
                        $_SESSION[SESSION_PATH_KEY] = "/News/";
                    }
                    ?>
                    <form action="InsertNews.php" method="post">
                        <?php
                        } elseif ($cm == "edit") {
                        if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                            $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/News/";
                        } else {
                            $_SESSION[SESSION_PATH_KEY] = "/News/";
                        }
                        ?>
                        <form action="UpdateNews.php" method="post">
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>"/>
                            <?php
                            }
                            ?>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">

                                        <fieldset class="form-horizontal">
                                            <div class="form-group"><label
                                                        class="col-sm-12 control-label">عنوان:</label>
                                                <div class="col-sm-12">
                                                    <input required placeholder="تایپ کنید..." type="Text"
                                                           class="form-control input-sm m-b-xs"
                                                           id="newstitle" name="newstitle"
                                                           value="<?php echo $new->Title; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group
                                            <?php
                                            if ($role->NewsApprove == 1) {
                                                echo 'class="hide"';
                                            }
                                            ?>">
                                                <label class="col-sm-12 control-label">
                                                    وضعیت خبر
                                                </label>
                                                <div class="col-sm-12">
                                                    <div class="radio radio-danger">
                                                        <input type="radio" <?php
                                                        if ($new->Status == 1 && $role->ProductApprove == 0) {
                                                            echo ' checked ';
                                                        }
                                                        ?> id="s-option" name="status" value="1">
                                                        <label for="s-option">
                                                            فعال
                                                        </label>
                                                    </div>

                                                    <div class="radio radio-danger">
                                                        <input type="radio" <?php
                                                        if ($new->Status == 0 || $role->ProductApprove == 1) {
                                                            echo ' checked ';
                                                        }
                                                        ?> id="f-option" name="status" value="0">
                                                        <label for="f-option">
                                                            غیرفعال
                                                        </label>
                                                    </div>
                                                    <div class="clear-fix"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="alert alert-warning">
                                                        <span class="optional">: SEO</span>
                                                        <br>
                                                        توجه : کلمات کلیدی با استفاده از " , " از هم جدا می شوند . مثال
                                                        : "گوشی سامسونگ ,گوشی سامسونگ سری S "
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label" style="margin-bottom: 15px">
                                                    <span class="label" id="mkstatus" class="HIDE"
                                                          style="font-size: 15px;"></span>
                                                </label>
                                                <div class="col-sm-12">
                                                    <input title="کلماتی که به خبر شما مرتبط هستند "
                                                           placeholder="کلمات کلیدی ..."
                                                           type="Text" class="form-control input-sm m-b-xs"
                                                           id="keywords"
                                                           name="keywords"
                                                           value="<?php echo $new->Keywords; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label" style="margin-bottom: 15px">
                                                    <span class="label" id="mdstatus" class="HIDE"
                                                          style="font-size: 15px;"></span>
                                                </label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control input-sm m-b-xs" rows="5"
                                                              id="metadescription"
                                                              placeholder="توضیحات خبر برای متا ..."
                                                              name="metadescription"
                                                              cols="20"><?php echo $new->MetaDescription; ?></textarea>
                                                </div>
                                            </div>
                                        </fieldset>

                                    </div>
                                </div>

                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">

                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    متن خبر:
                                                </label>
                                                <div class="col-sm-12">
                                                    <textarea class='tiny' id="content" name="content" rows="30"
                                                              class="WideText"
                                                              cols="20"><?php echo str_replace("News/", "../News/", $new->Content); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    خلاصه خبر:
                                                </label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control input-sm m-b-xs" style="width:100%;"
                                                              rows="5" id="summary"
                                                              placeholder="خلاصه خبر (2 خط) ..."
                                                              name="summary"
                                                              cols="20"><?php echo $new->Summary; ?></textarea>
                                                </div>
                                            </div>
                                        </fieldset>

                                    </div>
                                </div>

                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">

                                        <fieldset class="form-horizontal">
                                            <div class="ImageBox2">
                                                <div class="col-md-12">
                                                    <a id="filemanagerbtn2" data-toggle='modal'
                                                       data-target='#filemanModal'>
                                                        <div class="SelectBoxContainer center">
                                                            <?php
                                                            if ($cm == 'edit' && trim($new->Image) != "") {
                                                                echo '<img src=../' . $new->Image . ' />';
                                                            } else {
                                                                echo '<div class="SelectBox"></div>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </a>

                                                    <div class="modal inmodal fade" id="filemanModal" tabindex="-1"
                                                         role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" id="closeModal"><span
                                                                                aria-hidden="true">&times;</span><span
                                                                                class="sr-only">Close</span></button>
                                                                    <h4 class="modal-title"><i
                                                                                class="fa fa-photo text-primary m-xs"></i>انتخاب
                                                                        تصویر</h4>
                                                                    <small class="font-bold text-danger">حجم مجاز : 5
                                                                        مگابایت
                                                                    </small>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <iframe src="fileman/index.html?integration=custom&type=files&txtFieldId=image"
                                                                            style="width:100%;height:465px"
                                                                            frameborder="0"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="image" name="image"
                                                           value="<?php echo $new->Image; ?>"/>
                                                </div>
                                            </div>

                                        </fieldset>

                                    </div>
                                </div>

                            </div>

                            <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user" name="user"/>
                            <div class="ibox-content">

                                <a href="News.php" class="pull-left">
                                    <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                                        لیست اخبار
                                    </button>
                                </a>

                                <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                            class="fa fa-check"></i><strong>تایید</strong></button>
                                <div class="clear-fix"></div>
                            </div>
                        </form>
                </div>

            </div>
        </div>

    </div>
</div>

<!--<script defer onload="jqueryLoaded()" type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<script defer src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script src="fileman/js/main.js" type="text/javascript"></script>
<?php
include_once 'Template/bottom.php';
