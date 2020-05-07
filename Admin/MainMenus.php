<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->Fill();
$mainmenu->close();
?>
<?php
include_once 'Template/top.php';

if ($role->MenuSettings != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';
?>
<!--<script language="JavaScript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>-->
<script>
    $(document).ready(function () {
        $(".UP,.DOWN").click(function () {
            $('.th-loader').fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'AjaxMoveMenu.php',
                data: {value: $(this).text()},
                success: function (data) {
                    $('#td').html(data);
                    $('.th-loader').fadeOut(0);
                }
            });
        });
    });
</script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>منوی اصلی</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Main Menus</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست منو ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <a href="MainMenu.php">
                        <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                            افزودن منوی اصلی جدید
                        </button>
                    </a>

                    <a href="SelectMenus.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            منوهای سایت
                        </button>
                    </a>

                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-circle"></i>                        منو ها را طوری اضافه کنید که باعث به هم ریختگی سایت نشود ( از نظر تعداد منو های اصلی )
                    </div>

                    <div class="Database">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table id="td" class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th class="up-down" data-sort-ignore="true"><img class="th-loader" src="Template/Images/gifs/loading.gif"/></th>
                                <th>شناسه</th>
                                <th>نام منو</th>
                                <th data-hide="phone,tablet" data-sort-ignore="true">وضعیت</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($mainmenus as $c) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='UP' ><a class='btn btn-success btn-circle' ";
                                if ($c->Number == 1) {
                                    echo ' disabled ';
                                }
                                echo " ><i class='fa fa-arrow-up' style='font-size: 18px; padding-right: 5px'></i>mainmenu-up-$c->Number</a></div>";


                                echo "<div class='DOWN' ><a class='btn btn-success btn-circle' ";
                                $mmds = new MainMenuDataSource();
                                $mmds->open();
                                if ($c->Number == $mmds->MaxNumber()) {
                                    echo ' disabled ';
                                }
                                $mmds->close();
                                echo " ><i class='fa fa-arrow-down' style='font-size: 18px; padding-right: 5px'></i>mainmenu-down-$c->Number</a></div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->MainMenuId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->Group->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' ><a href='SwitchMainMenu.php?id=" . $c->MainMenuId . "'>";
                                if ($c->Disabled == 0) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</a></div></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='MainMenu.php?id=" . $c->MainMenuId . "'>" . "ویرایش" . "</a></button></td>";
                                echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateMainMenu.php?id=" . $c->MainMenuId . "'>" . "حذف" . "</a></button></td>";
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
    