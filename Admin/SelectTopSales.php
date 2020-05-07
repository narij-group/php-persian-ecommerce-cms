<!DOCTYPE html>
<?php
include_once 'Template/top.php';
?>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';

$discount = new DiscountDataSource();
$discount->open();
$discounts = $discount->Fill();
$discount->close();
?>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<script>

    $(document).ready(function () {
        $('.acheck').change(function () {
            var discountId = $(this).attr("value");
            $("#wait").fadeIn(0);
            $.ajax({
                url: 'SetSpecialOffers.php',
                type: 'POST',
                data: {discountId: discountId},
                success: function () {
                    $("#wait").fadeOut(0);
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        positionClass: 'toast-top-left',
                        timeOut: 700
                    };
                    toastr.success('تغییر با موفقیت انجام شد', 'پیغام');
//                    $("#success-msg").fadeIn(250);
                    setTimeout(function () {
//                        $("#success-msg").fadeOut(250);
                    }, 2000);
                }
            });
        });
    });

</script>
<style>
    .checkboxFour input, .checkboxFour2 input {
        font-size: 0;
    }

    .checkboxFour, .checkboxFour2 {
        z-index: 1;
        width: 30px;
        height: 30px;

        background: #ddd;
        border-radius: 100%;

        margin: 5px;
        position: relative;
        left: -15px;
    }

    .checkboxFour label, .checkboxFour2 label {
        display: block;
        width: 26px;
        height: 26px;
        border-radius: 100px;

        transition: all .5s ease;
        cursor: pointer;
        position: absolute;
        top: 2px;
        left: 2px;
        z-index: 999;

        background: #333;
    }

    .checkboxFour input[type=checkbox]:checked + label, .checkboxFour2 input[type=checkbox]:checked + label {
        background: #26ca28;
    }
</style>

<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>پیشنهادات ویژه</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Special Offers</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست قیمت ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="<?php
                    if (isset($_GET['id'])) {
                        echo "Discount.php";
                    } else {
                        echo "#";
                    }
                    ?>">
                        <button class="<?php
                        if (isset($_GET['id'])) {
                            echo 'btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
افزودن تخفیف جدید';
                        } else {
                            echo 'btn btn-outline btn-danger btn-w-m" type="button"><i class="fa fa-remove"></i>
نمیتوانید تخفیف جدید اضافه نمایید';
                        }
                        ?>"
                        </button>
                    </a>

                    <form action="SetSpecialOffers.php" method="POST">
                        <div class="Database">
                            <div class="db-cover" id="wait">
                    <span class="loading-title <?php
                    if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                        echo " SBackground'";
                    } else {
                        echo " GBackground'";
                    }
                    ?>">Loading...</span>
                                <img class="loading-gif" src="Template/Images/gifs/giphy (3).gif" alt=""/>
                            </div>
                            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                   placeholder="جستجو در لیست موجود در این صفحه">
                            <table class="footable table table-stripped" data-page-size="1000000000"
                                   data-filter=#filter>
                                <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th> محصول</th>
                                    <th> درصد تخفیف (%)</th>
                                    <th data-hide="phone,tablet">پیشنهاد ویژه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $postsCounter = 0;
                                foreach ($discounts as $p) {
                                    $postsCounter++;
                                    echo "<tr>";
                                    echo "<td><div class='DatabaseField' >" . $p->DiscountId . "</div></td>";
                                    echo "<td><div class='DatabaseField' >" . $p->Product->Name . "</div></td>";
                                    echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
                                    echo "<td><div class='DatabaseField' >";
                                    echo "<div class='checkbox checkbox-info checkbox-circle'><input type='checkbox'  value='" . $p->DiscountId . "' id='check" . $p->DiscountId . "' ";
                                    if ($p->SpecialOffer == 1) {
                                        echo ' checked ';
                                    }
                                    echo " name='check_list[]' class='acheck' /><label for='check" . $p->DiscountId . "'></label></div>";
                                    echo "</div></td>";
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
                    </form>
                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
    