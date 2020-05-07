<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/SlideDataSource.inc';
$slide = new SlideDataSource();
$slide ->open();
$slides = $slide->Fill();
$slide->close();
?>
<?php
include_once 'Template/top.php';
if ($role->Slides != 1) {
  header('Location:Index.php');
        die();
    }

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>اسلاید ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Slides</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست اسلاید ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

        <div class="Database">
            <?php
            if ($role->InsertSlide == 1) {
                ?>

                <a href="Slide.php">
                    <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                        افزودن اسلاید جدید
                    </button>
                </a>
                <?php
            }
            ?>
            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                   placeholder="جستجو در لیست موجود در این صفحه">
            <table class="footable table table-stripped" data-page-size="1000000000"
                   data-filter=#filter>
                <thead>
                <tr>
                    <th>شناسه </th>                    
                    <th> عنوان</th>
                    <th data-hide="phone,tablet"> لینک</th>
                    <th data-sort-ignore="true"> تصویر </th>
                   <?php
                    if ($role->EditSlide == 1) {
                        ?>
                        <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                        <?php
                    }
                    if ($role->DeleteSlide == 1) {
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
                foreach ($slides as $s) {
                    $postsCounter++;
                    echo "<tr>";
                    echo "<td><div class='DatabaseField' >" . $s->SlideId . "</div></td>";
                    echo "<td><div class='DatabaseField' >" . $s->Name . "</div></td>";
                    echo "<td><div class='DatabaseField' >" . $s->Link . "</div></td>";
                    echo "<td><div class='DatabaseField' ><img src='../" . $s->Image . "' /></div></td>";
                    if ($role->EditSlide == 1) {
                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Slide.php?id=" . $s->SlideId . "'>" . "ویرایش" . "</a></button></td>";
                    }
                    if ($role->DeleteSlide == 1) {
                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a  onclick='return deleteConfirm()' href='operateSlide.php?id=" . $s->SlideId . "'>" . "حذف" . "</a></button></td>";
                    }
                    echo "</tr>";
                }
                ?>
                </tbody>
<!--                <tfoot  style="direction: ltr">-->
<!--                <tr>-->
<!--                    <td colspan="5">-->
<!--                        <ul class="pagination pull-right"></ul>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                </tfoot>-->
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
