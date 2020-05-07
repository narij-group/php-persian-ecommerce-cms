<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';
$userCoupon = new UserCouponDataSource();
$userCoupon->open();
$userCoupons = $userCoupon->Fill();
$userCoupon->close();
?>
<?php
include_once 'Template/top.php';
if ($role->UserCoupons != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>کپن مشتری ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>User Coupons</h2>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>کپن مشتری</h5>
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
                        <a href="UserCoupon.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن کپن جدید
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
                                <th>شناسه</th>
                                <th> مشتری</th>
                                <th> مقدار</th>
                                <th data-hide="phone,tablet"> تاریخ</th>
                                <th data-hide="phone,tablet"> زمان</th>
                                <?php
                                if ($role->EditUserCoupon == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteUserCoupon == 1) {
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
                            foreach ($userCoupons as $u) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $u->UserCouponId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $u->Customer->Name . " " . $u->Customer->Family . "-" . $u->Customer->NationalityCode . " </div></td>";
                                echo "<td><div class='DatabaseField' >" . $u->Value . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $u->Date . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $u->Time . "</div></td>";
                                if ($role->EditUserCoupon == 1) {
                                    echo "<td><button class='btn-white btn btn-xs m-xs' title='Edit'><a href='UserCoupon.php?id=" . $u->UserCouponId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteUserCoupon == 1) {
                                    echo "<td><button class='btn-white btn btn-xs m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateUserCoupon.php?id=" . $u->UserCouponId . "'>" . "حذف" . "</a></button></td>";
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
    