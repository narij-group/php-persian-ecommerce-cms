<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolListDataSource.inc';

$protocollist = new ProtocolListDataSource();
$protocollist->open();
$protocollists = $protocollist->Fill();
$protocollist->close();
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>پروتکل لیست ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Protocols</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>رنگ بندی</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="ProtocolList.php">
                        <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                            افزودن پروتکل لیست جدید
                        </button>
                    </a>
                    <div class="Database">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>نام</th>
                                <th> تصویر</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($protocollists as $s) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $s->ProtocolListId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' ><img src='../" . $s->Image . "' /></div></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='ProtocolList.php?id=" . $s->ProtocolListId . "'>" . "ویرایش" . "</a></button></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateProtocolList.php?id=" . $s->ProtocolListId . "'>" . "حذف" . "</a></button></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                            <!--                        <tfoot  style="direction: ltr">-->
                            <!--                        <tr>-->
                            <!--                            <td colspan="5">-->
                            <!--                                <ul class="pagination pull-right"></ul>-->
                            <!--                            </td>-->
                            <!--                        </tr>-->
                            <!--                        </tfoot>-->
                        </table>
                    </div>
                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php
include_once 'Template/bottom.php';
