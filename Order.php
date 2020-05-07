<?php
include_once 'Template/top.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/OrderDataSource.inc';

if (isset($_GET['id'])) {
    $order = new Order();
    $ods = new OrderDataSource();
    $ods->open();
    $order = $ods->FindOneOrderBasedOnId($_GET['id']);
    $ods->close();
    ?>
    <title>درخواست ها</title>
    <meta name="description" content="درخواست"/>

    <?php
    include_once 'Template/menu.php';
//echo date("Y/m/d");
    ?>
    <div class="container">
        <div class="main-container">
            <!--Main Content-->
            <div class="text-view">

                <header style="background: #fbf7e3;border-color: #f9ebcc;color: #66512c">
                    <?php
                    echo "درخواست : " . "<span style='color: #8a6d3b'>" .  "( " . $order->SupperGroup->Name . " )" . "</span>";
                    ?>
                </header>

                <?php
                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                    $cds = new CustomerDataSource();
                    $cds->open();
                    $customer = $cds->FindOneCustomerBasedOnId($_COOKIE[COOKIE_CUSTOMER_ID]);
                    $cds->close();
                    ?>

                    <div class="panel-form">
                        <form>
                            <span class="title">متن درخواست شما :</span>
                            <textarea readonly name="content" id="content"><?php echo $order->Content; ?></textarea>
                            <span class="title">پاسخ :</span>
                            <textarea readonly name="content" id="content"><?php echo $order->Replay; ?></textarea>
                            <a href="UserProfile.php"><input type="button" value="بازگشت"/></a>
                        </form>
                    </div>
                    <?php
                } else {
                    echo ' <div class="order-form">';
                    echo '<a onclick="loginFirst()" href="#">ابتدا وارد شوید</a>';
                    echo '</div>';
                }
                ?>

            </div>
        </div>
    </div>

    <?php
    include_once "Template/bottom.php";

} else {

    $gds = new GroupDataSource();
    $gds->open();
    $groups = $gds->Fill();
    $gds->close();

    $customer = new Customer();
    ?>
    <title>ثبت سفارش</title>
    <meta name="description" content="ثبت سفارش"/>

    <link href="Admin/select2/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="Admin/select2/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#group").change(function () {
                var group = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/RefreshSubgroups.php',
                    data: {group: group},
                    success: function (data) {
                        $('#subgroup-td').html(data);
                        $('#suppergroup').html('<option></option>');
                    }
                });
            });

            $("#subgroup").change(function () {
                var subgroup = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSearch/RefreshSuppergroups.php',
                    data: {group: $('#group').val(), subgroup: subgroup},
                    success: function (data) {
                        $('#suppergroup-td').html(data);
                    }
                });
            });

            $("#group").select2({
                placeholder: "مجموعه را انتخاب کنید...",
                dir: "rtl"
            });
            $("#subgroup").select2({
                placeholder: "زیر مجموعه را انتخاب کنید...",
                dir: "rtl"
            });
            $("#suppergroup").select2({
                placeholder: "زیر زیر مجموعه را انتخاب کنید...",
                dir: "rtl"
            });

        });

    </script>


    <?php
    include_once 'Template/menu.php';
//echo date("Y/m/d");
    ?>
    <div class="container">
        <div class="main-container">
            <!--Main Content-->
            <div class="text-view">
                <?php
                if (isset($_GET["status"]) && $_GET["status"] == "OK") {
                    echo '<div class="success-order">سفارش شما با موفقیت ثبت شد</div>';
                }
                ?>

                <header style="background: #fbf7e3;border-color: #f9ebcc;color: #66512c">
                    ثبت سفارش
                </header>

                <?php
                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                    $cds = new CustomerDataSource();
                    $cds->open();
                    $customer = $cds->FindOneCustomerBasedOnId($_COOKIE[COOKIE_CUSTOMER_ID]);
                    $cds->close();
                    ?>

                    <div class="order-form">
                        <form method="post" action="InsertOrder.php" enctype="multipart/form-data">
                            <!--                        <input type="text" name="title" id="title " placeholder="عنوان"/>-->
                            <div style="margin-bottom: 2px">
                                <select required id="group" name="group" style="width: 80%">
                                    <option></option>
                                    <?php
                                    foreach ($groups as $g) {
                                        echo "<option ";
                                        echo " value = '$g->GroupId'";
                                        echo ">( " . $g->Name . " ) " . $g->LatinName . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div id="subgroup-td" style="margin-bottom: 2px">
                                <select required class="js-example-basic-single" disabled id="subgroup" name="subgroup"
                                        style="width: 80%">
                                    <option></option>
                                </select>
                            </div>

                            <div id="suppergroup-td" style="margin-bottom: 2px">
                                <select required class="js-example-basic-single" disabled id="suppergroup"
                                        name="suppergroup" style="width: 80%">
                                    <option></option>
                                </select>
                            </div>
                            <div class="browse-file">
                                <span style="float: right;padding-left: 10px;display: inline-block;margin-top: 3px">انتخاب فایل : </span>
                                <input type="file" name="file" id="file"/>
                            </div>
                            <textarea name="content" id="content" placeholder="متن..."></textarea>

                            <input type="submit" value="ثبت"/>
                        </form>
                    </div>
                    <?php
                } else {
                    echo ' <div class="order-form">';
                    echo '<a onclick="loginFirst()" href="#">ابتدا وارد شوید</a>';
                    echo '</div>';
                }
                ?>

            </div>
        </div>
    </div>

    <?php
    include_once "Template/bottom.php";

}
