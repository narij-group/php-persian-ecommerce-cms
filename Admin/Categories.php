<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CategoryDataSource.inc';
$category = new CategoryDataSource();
$category->open();
$categories = $category->Fill();
$category->close();
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>دسته بندی ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Categories</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>دسته بندی</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertUserCoupon == 1) {
                        ?>
                        <a href="Category.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن دسته بندی جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>
                    <div class="Database">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                            <tr>
                                <th>شناسه</th>
                                <th> نام</th>
                                <th> شاخص</th>
                                <th data-hide="phone,tablet" data-sort-ignore="true"> توضیحات</th>
                                <th data-hide="phone,tablet"> کاربر</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($categories as $c) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $c->CategoryId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->Parent . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->Description . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->User->Name . " " . $c->User->Family . "</div></td>";
                                echo "<td><div class='Edit' ><a href='Category.php?id=" . $c->CategoryId . "'>" . "" . "</a></div></td>";
                                echo "<td><div class='Delete' onclick='return deleteConfirm()'><a href='operateCategory.php?id=" . $c->CategoryId . "'>" . "" . "</a></div></td>";
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
    