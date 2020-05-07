<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolListDataSource.inc';
$protocollist = new ProtocolList();
$cm = "add";
if (isset($_GET['id'])) {
    $cm = "edit";
    $s = new ProtocolListDataSource();
    $s->open();
    $protocollist = $s->FindOneProtocolListBasedOnId($_GET['id']);
    $s->close();
}
include_once 'Template/top.php';
include_once 'fileman/system.inc.php';
include_once 'fileman/php/functions.inc.php';
?>
<!--    <script defer onload="jqueryLoaded()" type="text/javascript"-->
<!--            src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <script
    defer
    src = "//code.jquery.com/ui/1.10.3/jquery-ui.min.js" ></script>
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
            <h2>پروتکل لیست</h2>
        </div>
        <div class="col-lg-6 title-en">
            <h2>ProtocolList</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <a href="ProtocolLists.php">
                            <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                                لیست پروتکل لیست ها
                            </button>
                        </a>

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                پروتکل لیست
                            </div>
                            <div class="panel-body">
                        <div class="alert alert-warning">
                            توجه : اندازه تصویر باید 155x55 باشد، در غیر این صورت کیفیت خود را از دست می دهد.
                        </div>
                        <div class="Inputs">
                            <?php
                            if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                                $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/ProtocolImages/";
                            } else {
                                $_SESSION[SESSION_PATH_KEY] = "ProtocolImages/";
                            }
                            ?>

                            <form action="operateProtocolList.php" method="post">
                                <input type="hidden" id="id" name="id"
                                       value="<?php echo $protocollist->ProtocolListId; ?>"/>
                                <fieldset class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">
                                            نام :
                                        </label>
                                        <div class="col-sm-12">
                                            <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                   value="<?php echo $protocollist->Name; ?>"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">
                                            تصویر :
                                        </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control input-sm m-b-xs" id="image" name="image"
                                                   readonly="readonly"
                                                   value="<?php echo $protocollist->Image; ?>" style="cursor: pointer;"
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

    <div class="Metro">
        <div class="Centerer">
            <div class="MainTitle2">
                <span <?php if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                    echo "class='SBackground'";
                } else {
                    echo "class='GBackground'";
                } ?> >ProtocolList</span><img src="Template/Images/trigger2.png" alt=""/></div>
            <div class="ProfileBar">
                <div class="Shortcut"><a href="ProtocolLists.php"><img src="Template/Images/Database.png" alt=""/></a>
                </div>
                <div class="Shortcut"><a href="Index.php"><img src="Template/Images/Start.png" alt=""/></a></div>
                <div class="Shortcut"><a href="ProtocolListff.php"><img src="Template/Images/Logoff.png" alt=""/></a>
                </div>
                <div class="Profile">
                    <img src="Template/Images/malecostume-128.png" alt=""/>
                    <div class="Name"><?php echo $settings->Owner; ?></div>

                </div>
            </div>
            <div class='Alert3'><span>توجه : </span>اندازه تصویر باید 155x55 باشد، در غیر این صورت کیفیت خود را از دست
                می دهد.
            </div>
            <div class="Inputs">
                <?php
                if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
                    $_SESSION[SESSION_PATH_KEY] = "/DigitalShopV1/ProtocolImages/";
                } else {
                    $_SESSION[SESSION_PATH_KEY] = "ProtocolImages/";
                }
                ?>

                <form action="operateProtocolList.php" method="post">
                    <input type="hidden" id="id" name="id" value="<?php echo $protocollist->ProtocolListId; ?>"/>
                    <table>
                        <tr>
                        <tr>
                            <td><label>نام : </label></td>
                            <td><input type="Text" class="NormalText" id="name" name="name"
                                       value="<?php echo $protocollist->Name; ?>"/></td>
                        </tr>
                        </tr>
                        <tr>
                            <td><label> تصویر : </label></td>
                            <td>
                                <input type="text" class="NormalText" id="image" name="image" readonly="readonly"
                                       value="<?php echo $protocollist->Image; ?>" style="cursor: pointer;"
                                       onclick="openCustomRoxy2()"/>
                                <div id="roxyCustomPanel2" style="display: none;">
                                    <iframe src="fileman/index4.html?integration=custom&type=files&txtFieldId=image"
                                            style="width:100%;height:100%" frameborder="0">
                                    </iframe>
                                </div>
                            </td>
                        </tr>
                        <tr class="SaveTr">
                            <td class="SaveTd"></td>
                            <td><input type="submit" class="Save" value=""/></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

<?php
include_once 'Template/bottom.php';
