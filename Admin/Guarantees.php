<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
if (isset($_GET['id'])) {
    $product = new ProductDataSource();
    $product->open();
    $guarantees = $product->GetGuarantees($_GET['id']);
    $product->close();
    $_SESSION[SESSION_INT_PRODUCT_ID] = $_GET['id'];
} else {
    $guarantee = new GuaranteeDataSource();
    $guarantee->open();
    $guarantees = $guarantee->Fill();
    $guarantee->close();
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>گارانتی ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Guarantees</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>گارانتی</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="<?php
                    if (isset($_GET['id'])) {
                        echo "Guarantee.php";
                    } else {
                        echo "#";
                    }
                    ?>">
                        <button class="<?php
                        if (isset($_GET['id'])) {
                            echo 'btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
افزودن گارانتی جدید';
                        } else {
                            echo 'btn btn-outline btn-danger btn-w-m" type="button"><i class="fa fa-remove"></i>
نمیتوانید گارانتی جدید اضافه نمایید';
                        }
                        ?>
                        </button>
                                </a>

                        <div class=" Database
                        ">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> محصول</th>
                                <th> نام گارانتی</th>
                                <th data-hide="phone,tablet">مدت زمان انقضا</th>
                                <th data-hide="phone,tablet"> قیمت</th>
                                <th data-hide="phone,tablet"> تاریخ</th>
                                <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($guarantees as $p) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $p->GuaranteeId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Product . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Guarantee->Name . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Guarantee->Duration . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . number_format($p->Guarantee->Price) . " تومان</div></td>";
                                echo "<td><div class='DatabaseField' >" . $p->Date . "</div></td>";
                                echo "<td><button class='btn-white btn btn-xs m-xs' title='Edit'><a href='Guarantee.php?";
                                if (isset($_GET['id']) == TRUE) {
                                    echo "pid=$p->Product&";
                                }
                                echo "id=$p->GuaranteeId'>ویرایش</a></button></td>";
                                echo "<td><button class='btn-white btn btn-xs m-xs' title='Delete'><a onclick='return deleteConfirm()' href='DeleteGuarantee.php?";
                                if (isset($_GET['id']) == TRUE) {
                                    echo "pid=$p->Product&";
                                }
                                echo "id=$p->GuaranteeId'>حذف</a></button></td>";
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
    