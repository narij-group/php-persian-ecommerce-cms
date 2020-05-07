<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolListDataSource.inc';
$protocol = new Protocol();
if (isset($_GET['id'])) {
    $p = new ProtocolDataSource();
    $p->open();
    $protocol = $p->FindOneProtocolBasedOnId($_GET['id']);
    $p->close();
}
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>پروتکل</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Protocol</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Protocols.php?id=<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            پروتکل ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            پروتکل
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <form action="operateProtocol.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $protocol->ProtocolId; ?>"/>
                                    <?php
                                    if (isset($_GET['pid']) == TRUE) {
                                        ?>
                                        <input type="hidden" id="pid" name="pid" value="<?php echo $_GET['pid'] ?>"/>
                                        <?php
                                    }
                                    ?>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                پروتکل محصول :
                                            </label>
                                            <div class="col-sm-12">
                                                <?php
                                                $protocollist = new ProtocolListDataSource();
                                                $protocollist->open();
                                                $protocollists = $protocollist->Fill();
                                                $protocollist->close();
                                                echo "<select  class='form-control m-b' name='protocollist' id='protocollist' >";
                                                foreach ($protocollists as $p) {
                                                    echo "<option value = '$p->ProtocolListId'";
                                                    if ($p->ProtocolListId == $protocol->ProtocolList->ProtocolListId) {
                                                        echo " selected >$p->Name</option>";
                                                    } else {
                                                        echo ">$p->Name</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                ?>
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
