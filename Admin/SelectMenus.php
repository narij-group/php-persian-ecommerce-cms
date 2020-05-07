<!DOCTYPE html>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>منو های سایت</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Menus</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>منو های سایت</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <a href="MenuTitles.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-buysellads"></i>
                            عنوان ها
                        </button>
                    </a>
                    <a onclick='return menuAndGroupSync()' href="MenuAndGroupSynchronize.php">
                        <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-sliders"></i>
                            یکپارچه سازی دسته بندی با منو
                        </button>
                    </a>
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-circle"></i>بخش مورد نظر را انتخاب کنید.
                    </div>
                    <div class="menu-selection">
                        <table border="0">
                            <tr>
                                <td>
                                    <a href="MainMenus.php" class="menu-first-level"></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="SubMenus.php" class="menu-second-level"></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="SupperMenus.php"  class="menu-third-level third-tier"></a>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
    