<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';


$gds = new GroupDataSource();
$gds->open();
$groups = $gds->Fill();
$gds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->Groups != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>مجموعه ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Groups</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست مجموعه ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertGroup == 1) {
                        ?>
                        <a href="Group.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن مجموعه جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($role->Settings == 1) {
                        ?>
                        <a onclick='return menuAndGroupSync()'
                           href="MenuAndGroupSynchronize.php">
                            <button class="btn btn-warning btn-w-m" type="button">
                                یکپارچه سازی دسته بندی با منو
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <div class="alert alert-warning">
برای قرارگیری گزینه های موجود در صفحه اصلی در یک سطر ، نباید تعداد آن ها از 6 بیشتر شود.
                    </div>

                    <div class="Database">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>نام</th>
                                <th>نام لاتین</th>
                                <th data-hide="phone,tablet"> تصویر</th>
                                <th data-hide="phone,tablet"> صفحه اصلی</th>
                                <?php
                                if ($role->EditGroup == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteGroup == 1) {
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
                            foreach ($groups as $s) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $s->GroupId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->LatinName . "</div></td>";
                                echo "<td><div class='DatabaseField' ><img src = ../" . $s->Image . " /></div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if ($s->PlaceAsMainCat == 1) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</div></td>";
                                if ($role->EditGroup == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Group.php?id=" . $s->GroupId . "'>" . "ویرایش" . "</a></div></td>";
                                }
                                if ($role->DeleteGroup == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='DeleteConfirm.php?gpid=" . $s->GroupId . "'>" . "حذف" . "</a></div></td>";
                                }
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
    