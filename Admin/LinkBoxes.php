<!DOCTYPE html>
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';
$lds = new LinkBoxDataSource();
$lds->open();
$linkboxes = $lds->Fill();
$lds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->LinkBoxes != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>پیوند ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Links Box</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست پیوند ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <div class="Database">
                        <?php
                        if ($role->InsertLinkBox == 1) {
                            ?>
                            <a href="LinkBox.php">
                                <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                    افزودن پیوند جدید
                                </button>
                            </a>
                            <?php
                        }
                        ?>
                        <?php
                        if ($role->LinkBoxGroup == 1) {
                            ?>
                            <a href="LinkboxTitles.php">
                                <button class="btn btn-info  btn-w-m" type="button"><i class="fa fa-sitemap"></i>
                                    زیر گروه ها
                                </button>
                            </a>
                            <?php
                        }
                        ?>

                        <div class="alert alert-warning">
                            توجه : شما قادر به افزودن 4 زیر گروه همنام هستید و بیشتر از آن نمایش داده نمیشود .
                        </div>

                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> نام</th>
                                <th > زیر گروه</th>
                                <th data-hide="phone,tablet"> لینک صفحه</th>
                                <th data-hide="phone,tablet"> کاربر</th>

                                <?php
                                if ($role->InsertLinkBox == 1 || $role->EditLinkBox == 1) {
                                    ?>
                                    <th id="th" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->EditLinkBox == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteLinkBox == 1) {
                                    ?>
                                    <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($linkboxes as $l) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $l->LinkBoxId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $l->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $l->LinkboxTitle->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $l->Link . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $l->User->Name . " " . $l->User->Family . "</div></td>";
                                if ($role->InsertLinkBox == 1 || $role->EditLinkBox == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Set Content'><a href='LinkContent.php?id=" . $l->LinkBoxId . "'>" . "افزودن محتوا" . "</a></div></td>";
                                }
                                if ($role->EditLinkBox == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='LinkBox.php?id=" . $l->LinkBoxId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteLinkBox == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateLinkBox.php?id=" . $l->LinkBoxId . "'>" . "حذف" . "</a></button></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
<!--                            <tfoot style="direction: ltr">-->
<!--                            <tr>-->
<!--                                <td colspan="5">-->
<!--                                    <ul class="pagination pull-right"></ul>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                            </tfoot>-->
                        </table>
                    </div>
                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- FooTable -->
<script src="Admin/Template/Scripts/plugins/footable/footable.all.min.js"></script>
<?php
include_once 'Template/bottom.php';
    