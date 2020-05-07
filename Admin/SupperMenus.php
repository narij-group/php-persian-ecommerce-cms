<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';
$suppermenu = new SupperMenuDataSource();
$suppermenu->open();
$suppermenus = $suppermenu->Fill();
$suppermenu->close();

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$submenu = new SubMenuDataSource();
$submenu->open();
$mainmenu = new MainMenuDataSource();
$mainmenu->open();

?>
<?php
include_once 'Template/top.php';
if ($role->MenuSettings != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>زیر زیرمنو ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Supper Menus</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست زیر زیرمنو ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <a href="SupperMenu.php">
                        <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                            افزودن زیر زیرمنوی جدید
                        </button>
                    </a>

                    <a href="SelectMenus.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            منوهای سایت
                        </button>
                    </a>

                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-circle"></i>منو ها را طوری اضافه کنید که باعث به هم ریختگی سایت نشود
                        ( از نظر تعداد زیر زیر منو ها )
                    </div>

                    <div class="Database">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>منو اصلی</th>
                                <th>زیر منو</th>
                                <th data-hide="phone,tablet">نام زیر زیر منو</th>
                                <th data-hide="phone,tablet">عنوان</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($suppermenus as $c) {
                                $postsCounter++;
//                    $mainmenu->MainMenuId = $c->MainMenu->MainMenuId;
                                $mainmnu = $mainmenu->FindOneMainMenuBasedOnId($c->MainMenu->MainMenuId);
//                    $submenu->SubMenuId = $c->SubMenu->SubMenuId;
//                    echo $c->SubMenu->SubMenuId;
                                $submnu = new SubMenu();
                                $submnu = $submenu->FindOneSubMenuBasedOnId($c->SubMenu->SubMenuId);

                                $sbname = "";
                                if ($submnu != null)
                                    $sbname = $submnu->SubGroup->Name;

                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $c->SupperMenuId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $mainmnu->Group->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $sbname . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->SupperGroup->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->Title->Name . "</div></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='SupperMenu.php?id=" . $c->SupperMenuId . "'>" . "ویرایش" . "</a></button></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateSupperMenu.php?id=" . $c->SupperMenuId . "'>" . "حذف" . "</a></button></td>";
                                echo "</tr>";
                            }
                            $mainmenu->close();
                            $submenu->close();
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
    