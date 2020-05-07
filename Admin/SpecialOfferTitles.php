<!DOCTYPE html>
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SpecialOfferTitleDataSource.inc';
$stds = new SpecialOfferTitleDataSource();
$stds->open();
$specialoffertitles = $stds->Fill();
$stds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->SpecialOffers != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>عنوان های پیشنهادات ویژه</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Special Offers Titles</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست عنوان های پیشنهادات ویژه</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <div class="Database">
                        <?php
                        if ($role->InsertSpecialOffer == 1) {
                            ?>
                            <a href="SpecialOfferTitle.php">
                                <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                    افزودن عنوان پیشنهاد ویژه جدید
                                </button>
                            </a>
                            <?php
                        }
                        ?>

                        <div class="alert alert-warning">
                            توجه : جهت ایجاد لینک به صفحه محصولات برای هر یک از عنوان ها از کلمه special_offers و علامت
                            = و شناسه گزینه مورد نظر استفاده نمایید.
                            <br>
                            مثال برای شناسه ( 1 ) :
                            <br>
                            Products.php?special_offers=1
                        </div>

                        <div class="alert alert-danger">
                            هر کدام از گزینه ها را که فعال کنید در صفحه اصلی نمایش داده خواهد شد. (محدودیت تا 5 گزینه)
                        </div>

                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>عنوان</th>
                                <th>وضعیت</th>
                                <?php
                                if ($role->EditSpecialOffer == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteSpecialOffer == 1) {
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
                            foreach ($specialoffertitles as $st) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $st->SpecialOfferTitleId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $st->Title . "</div></td>";
                                echo "<td><div class='DatabaseField' >";
                                if ($role->EditSpecialOffer == 1) {
                                    echo "<a href = 'operateSpecialOfferTitle.php?offerid=" . $st->SpecialOfferTitleId . "' >";
                                }
                                if ($st->Activated == 1) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo "</a></div></td>";
                                if ($role->EditSpecialOffer == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='SpecialOfferTitle.php?id=" . $st->SpecialOfferTitleId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteSpecialOffer == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateSpecialOfferTitle.php?id=" . $st->SpecialOfferTitleId . "'>" . "حذف" . "</a></button></td>";
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

<?php
include_once 'Template/bottom.php';
    