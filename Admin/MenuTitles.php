<!DOCTYPE html>
<?php
include_once 'Template/top.php';

if ($role->MenuSettings != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';
?>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';


$menutitle = new MenuTitleDataSource();
$menutitle->open();
$menutitles = $menutitle->Fill();
$menutitle->close();


?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>عنوان منو ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Menu Titles</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>عنوان منو</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="MenuTitle.php">
                        <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                            افزودن عنوان جدید
                        </button>
                    </a>
                    <a href="SelectMenus.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-plus"></i>
                            منوهای سایت
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
                                <th> زیر منو</th>
                                <th> عنوان</th>
                                <th data-hide="phone,tablet"> ستون</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($menutitles as $p) {
                                $postsCounter++;

                                $submenu = new SubMenuDataSource();
                                $submenu->open();
                                $sb = $submenu->FindOneSubMenuBasedOnId($p->SubMenu->SubMenuId);

                                $sbname = "";
                                if ($sb != null)
                                    $sbname = $sb->SubGroup->Name;

                                $submenu->close();
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->MenuTitleId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $sbname . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Column . "</div></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='MenuTitle.php?id=$p->MenuTitleId'>ویرایش</a></button></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateMenuTitle.php?id=$p->MenuTitleId'>حذف</a></button></td>";
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
    