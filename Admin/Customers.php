<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProvinceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';

$province = new Province();
$city = new City();
$cds = new CustomerDataSource();
$cds->open();
$customers = $cds->Fill();
$cds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->Customers != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>
<script language="JavaScript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script>
    $(document).ready(function () {
        <?php
        if(isset($_SESSION[SESSION_BOOL_EMAIL_SENT]) && $_SESSION[SESSION_BOOL_EMAIL_SENT] != false){
        ?>
//        $("#email-success").fadeIn(250);
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            positionClass: 'toast-top-left',
            preventDuplicates: true,
            timeOut: 5000
        };
        toastr.success('ارسال ایمیل موفقیت آمیز بود!', 'ایمیل');
        setTimeout(function () {
            $("#email-success").fadeOut(250);
        }, 5000);
        <?php
        $_SESSION[SESSION_BOOL_EMAIL_SENT] = false;
        }
        ?>

    });
</script>
<!--<div class="success-message" id="email-success">ارسال ایمیل موفقیت آمیز بود!</div>-->

<div class="modal inmodal fade" id="emailModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title"><i class="fa fa-envelope text-primary m-xs"></i>ارسال اس ام اس
                </h4>
            </div>
            <div class="modal-body">
                <div class="inputs">
                    <textarea class="form-control input-sm m-b-xs" required placeholder="متن اس ام اس..." id="txt" name="txt"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                </button>
                <button type="button" id="SendSMS" class="btn btn-primary"
                        data-dismiss="modal">ارسال اس ام اس
                </button>
            </div>
        </div>
    </div>
</div>

<!--<div class="success-message" id="success-msg">اس ام اس ها با موفقیت ارسال شدند!</div>-->

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>مشتری ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Customers</h2>
    </div>
</div>

<div class="modal inmodal fade" id="customerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">


        </div>
    </div>
</div>

<div class="modalback" id="modalback"></div>
<div class="product-info" id="p-info"></div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست مشتری ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertCustomer == 1) {
                        ?>
                        <a href="Customer.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن مشتری جدید
                            </button>
                        </a>
                        <?php
                    }

                    if ($role->SendSMS == 1) {
                        ?>
                        <a href="CustomerEmail.php">
                            <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-at"></i>
                                ارسال ایمیل دلخواه
                            </button>
                        </a>
                        <a id="smsbtn" data-toggle='modal' data-target='#emailModal' href="#">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-envelope"></i>
                                ارسال اس ام اس دلخواه
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
                                <th>نام</th>
                                <!--                    <th>نام کاربری</th>-->
                                <th>پست الکترونیک</th>
                                <!--                    <th> استان</th>
                                                    <th>شهر </th>
                                                    <th> کد ملی</th>
                                                    <th> آدرس</th>-->
                                <th data-hide="phone,tablet"> شماره تماس</th>
                                <!--<th> تلفن همراه</th>-->
                                <!--<th> کد پستی</th>-->
                                <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                <?php
                                if ($role->EditCustomer == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteCustomer == 1) {
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
                            foreach ($customers as $c) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $c->CustomerId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->Name . " " . $c->Family . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $c->Email . "</div></td>";
//                    echo "<td><div class='DatabaseField' >" . $c->Email . "</div></td>";
//                    echo "<td><div class='DatabaseField' >" . $c->Estate . "</div></td>";
//                    echo "<td><div class='DatabaseField' >" . $c->City . "</div></td>";
//                    echo "<td><div class='DatabaseField' >" . $c->NationalityCode . "</div></td>";
//                    echo "<td><div class='DatabaseField' >" . $c->Address . "</div></td>";
                                echo "<td><div class='DatabaseField' >";
                                echo $c->Mobile . "</div></td>";
//                    echo "<td><div class='DatabaseField' >" . $c->PostCode . "</div></td>"
                                echo "<td><div class='p-btn info btn btn-primary btn-rounded' ><a style='color: white' title='More Information' data-toggle='modal' data-target='#customerModal' >" . "$c->CustomerId" . "</a></div></td>";
                                if ($role->EditCustomer == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Customer.php?id=" . $c->CustomerId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteCustomer == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='DeleteConfirm.php?customerid=" . $c->CustomerId . "'>" . "حذف" . "</a></button></td>";
                                }
                                echo "</tr>";
                            }


                            foreach ($customers as $c) {
                                ?>
                                <script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $(".info").click(function () {
                                            $.ajax({
                                                url: 'AjaxCustomerInfo.php',
                                                type: 'POST',
                                                data: {customerId: $(this).text()},
                                                success: function (result) {
                                                    $("#modal-content").html(result);
                                                }
                                            });
                                        });
                                        $("#modalback").click(function () {
                                            $("#p-info").fadeOut(250);
                                            $("#email-modal").fadeOut(250);
                                            $("#modalback").fadeOut(500);
                                        });
                                        $("#smsbtn").click(function () {
                                            $("#email-modal").fadeIn(500);
                                            $("#modalback").fadeIn(250);
                                        });
                                        $("#SendSMS").click(function () {
                                            $.ajax({
                                                url: "AjaxSendSMS.php",
                                                type: "POST",
                                                data: {value: $("#txt").val()},
                                                success: function () {
                                                    $("#email-modal").fadeOut(250);
                                                    $("#modalback").fadeOut(500);

                                                    toastr.options = {
                                                        closeButton: true,
                                                        progressBar: true,
                                                        showMethod: 'slideDown',
                                                        positionClass: 'toast-top-left',
                                                        preventDuplicates: true,
                                                        timeOut: 5000
                                                    };
                                                    toastr.success('اس ام اس ها با موفقیت ارسال شدند!', 'اس ام اس');

                                                    setTimeout(function () {
                                                        $("#success-msg").fadeOut(250);
                                                    }, 7000);
                                                }
                                            });
                                        });
                                    });
                                </script>
                                <?php
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
    