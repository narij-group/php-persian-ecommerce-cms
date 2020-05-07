<?php
include_once 'Template/top.php';
include_once 'Template/menu.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/BillDataSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/OrderDataSource.inc';
$fp = new FactorProductDataSource();
$fp->open();
$factorProducts = $fp->FindOneCustomerFactors($_COOKIE[COOKIE_CUSTOMER_ID]);
$fp->close();
$compelete = false;


$ods = new OrderDataSource();
$ods->open();
$orders = $ods->FindOneOrderBasedOnCustomer($_COOKIE[COOKIE_CUSTOMER_ID]);
$ods->close();
require_once 'Template/CustomeDate/jdatetime.class.php';
?>
    <link href="Admin/Template/Styles/plugins/footable/footable.core.css" rel="stylesheet">

    <title>صفحه کاربری</title>
    <script>

        function deleteConfirm() {
            return confirm("آیا میخواهید این سفارش را لغو کنید ؟");
        }

        $(document).ready(function () {
            $('.reciept-btn').click(function () {
                $.ajax({
                    type: 'post',
                    url: 'AjaxSearch/AjaxReceipt.php',
                    data: {
                        code: $(this).attr('id')
                    },
                    success: function (res) {
                        $('#receipt').html(res);
                        $('#receipt').fadeIn(500);
                        $('#modalback').fadeIn(250);
                    }
                })
            });
        });
    </script>
    <div class="container">
        <div class="main-container">
            <div class="profile-view">
                <div class="profile">
                    <div class="row">
                        <div class="title">اطلاعات شما</div>
                        <div class="col-md-2">
                            <img src="Template/Images/user.png"/>
                        </div>
                        <div class="col-md-10">
                            <div>
                                <span>نام و نام خانوادگی :  </span>
                                <span><?php
                                    echo $customer->Name;
                                    echo ' ';
                                    echo $customer->Family;
                                    ?></span>
                            </div>
                            <div>
                                <span>پست الکترونیک : </span>
                                <span><?php echo $customer->Email; ?></span>
                            </div>
                            <div>
                                <span>شماره تلفن : </span>
                                <span> <?php echo $customer->Mobile; ?> | <?php echo $customer->Phone; ?></span>
                            </div>
                            <div>
                                <span>کد ملی :</span>
                                <span> <?php echo $customer->NationalityCode; ?></span>
                            </div>
                            <?php
                            if ($customer->Estate != 0) {
                                $prds = new ProvinceDataSource();
                                $prds->open();
                                ?>
                                <div>
                                    <span>استان : </span>
                                    <span><?php echo $prds->GetName($customer->Estate); ?></span>
                                </div>
                                <?php
                                $prds->close();
                            } else {
                                $compelete = true;
                            }
                            ?>

                            <?php
                            if ($customer->City != 0) {
                                $ctds = new CityDataSource();
                                $ctds->open();
                                ?>
                                <div>
                                    <span>شهر : </span>
                                    <span><?php echo $ctds->GetName($customer->City); ?></span>
                                </div>
                                <?php
                                $ctds->close();
                            } else {
                                $compelete = true;
                            }
                            ?>

                            <div>
                                <?php
                                if (trim($customer->PostCode) != "") {
                                    ?>
                                    <div>
                                        <span>کد پستی  : </span>
                                        <div style="display: inline-block;"><?php echo $customer->PostCode; ?></div>
                                    </div>
                                    <?php
                                } else {
                                    $compelete = true;
                                }
                                ?>
                                <?php
                                if (trim($customer->Address) != "") {
                                    ?>
                                    <span>آدرس :</span>
                                    <span><?php echo $customer->Address; ?></span>
                                    <?php
                                } else {
                                    $compelete = true;
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            if ($compelete == true) {
                                ?>
                                <a href="#" id="editcustomer">تکمیل اطلاعات</a>
                                <?php
                            } else {
                                ?>
                                <a href="#" id="editcustomer">ویرایش اطلاعات</a>
                                <?php
                            }

                            ?>
                        </div>
                    </div>
                </div>

                <div class="purchases">
                    <div class="row">
                        <div class="title">لیست درخواست ها</div>
                        <div class="col-md-12">
                            <table class="footable table table-stripped" data-page-size="1000000000"
                                   data-filter=#filter>
                                <thead>
                                <tr>
                                    <th data-sort-ignore="true">زمان</th>
                                    <th data-sort-ignore="true">وضعیت درخواست</th>
                                    <th data-hide="phone,tablet" data-sort-ignore="true">مجموعه</th>
                                    <th data-hide="phone,tablet" data-sort-ignore="true">نمایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($orders as $o) {
                                    $date2 = explode('/', $o->Date);
                                    $date = new jDateTime(true, true, 'Asia/Tehran');
                                    $time2 = $date->mktime(0, 0, 0, intval($date2[1]), intval($date2[2]), intval($date2[0]), false, 'America/New_York');
                                    $date = new jDateTime("l j F Y", $o->Date, true, true, 'Asia/Tehran');
                                    echo "<tr>";
                                    echo "<td><div class='DatabaseField' >" . $date->date("l j F Y", $time2, true, true, 'Asia/Tehran') . "</div></td>";
                                    if ($o->Status == 0) {
                                        echo "<td><div class='DatabaseField' style='color: #f07582' >بررسی نشده</div></td>";
                                    } else {
                                        echo "<td><div class='DatabaseField' style='color: #1ab394'>بررسی شده</div></td>";
                                    }
                                    echo "<td><div class='DatabaseField' >" . $o->SupperGroup->Name . "</div></td>";
                                    echo "<td><div class='DatabaseField'><a href='Order.php?id=" . $o->OrderId . "'>" . "نمایش" . "</a></td></div>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="purchases">
                    <div class="row">
                        <div class="title">تاریخچه سفارشات</div>
                        <div class="col-md-12">
                            <table class="footable table table-stripped" data-page-size="1000000000"
                                   data-filter=#filter>
                                <thead>
                                <tr>
                                    <th data-sort-ignore="true"> کد پیگیری</th>
                                    <th data-sort-ignore="true">زمان</th>
                                    <th data-hide="phone,tablet" data-sort-ignore="true">وضعیت سفارش</th>
                                    <th data-hide="phone,tablet" data-sort-ignore="true">وضعیت پرداخت</th>
                                    <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $TraceCode = "";
                                require_once 'Template/CustomeDate/jdatetime.class.php';

                                $date = new jDateTime(true, true, 'Asia/Tehran');

                                foreach ($factorProducts as $p) {
                                    if ($TraceCode != $p->TraceCode) {
                                        $fdate = explode("/", $p->Date);
                                        $time2 = $date->mktime(0, 0, 0, $fdate[1], $fdate[2], $fdate[0], false, 'America/New_York');
                                        echo "<tr class='clickable-row' id='$p->FactorProductId' >";
                                        echo "<td><img src='Template/Images/Plugins/caret-bottom3.png' style=' width: 20px; height:20px; margin-top:10px; position:absolute; right:40px;' /><div class='DatabaseField'  style='width: 135px;  text-align: left'>" . $p->TraceCode . "</div>";
                                        echo "<td><div class='DatabaseField'>";
                                        echo "" . $date->date("l j F Y", $time2, false, true, 'Asia/Tehran') . "- <span style='display:inline-block; direction:ltr;' >" . $p->Time . "</span></td></div>";
                                        echo "<td><div class='DatabaseField'>";
                                        if ($p->PaymentMethod == 1 || $p->PaymentMethod == 2 || $p->PaymentStatus != 5) {
                                            if ($p->Status == 0) {
                                                echo "در انتظار بررسی";
                                            } elseif ($p->Status == 1) {
                                                echo 'تایید شد و در پروسه انبار';
                                            } elseif ($p->Status == 2) {
                                                echo 'ارسال شد';
                                            } elseif ($p->Status == 3) {
                                                echo 'لغو شد';
                                            }
                                        } else {
                                            if ($p->PaymentStatus == 5) {
                                                echo 'در انتظار ارائه و تایید فیش';
                                            }
                                        }
                                        echo "</td></div>";
                                        echo "<td><div class='DatabaseField'>";
                                        if ($p->PaymentStatus == 0) {
                                            echo 'در حال پرداخت...';
                                        } elseif ($p->PaymentStatus == 1) {
                                            echo 'پرداخت شد';
                                        } elseif ($p->PaymentStatus == 2) {
                                            echo 'شکست خورد';
                                        } elseif ($p->PaymentStatus == 3) {
                                            echo 'توسط کاربر لغو شد';
                                        } elseif ($p->PaymentStatus == 4) {
                                            echo 'پرداخت درب منزل';
                                        } elseif ($p->PaymentStatus == 5) {
                                            $bill = new BillDataSource();
                                            $bill->open();
                                            $b = $bill->FindByCode($p->TraceCode);
                                            $bill->close();
                                            if ($b != null) {
                                                if ($b->Status == 2) {
                                                    echo 'تایید شد';
                                                } elseif ($b->Status == 3) {
                                                    echo '<a href="#" id="btn' . $p->TraceCode . '" class="reciept-btn" >ارائه فیش بانکی</a>';
                                                    echo ' اطلاعات اشتباه است! ';
                                                } elseif ($b->Status == 1) {
                                                    echo '<a href="#" id="btn' . $p->TraceCode . '" class="reciept-btn" >ارائه فیش بانکی</a>';
                                                    echo '  در انتظار بررسی ';
                                                }
                                            } else {
                                                echo '<a href="#" id="btn' . $p->TraceCode . '" class="reciept-btn" >ارائه فیش بانکی</a>';
                                            }

                                        }
                                        echo "</td></div>";
                                        echo '<td><div class="DatabaseField">';
                                        if ($p->Status == 0 && $p->PaymentMethod != 1) {
                                            echo '<a onclick="return deleteConfirm()"  href="Internal Inserting/DeleteFactor.php?code=' . $p->TraceCode . '" class="delete-btn" >لغو سفارش</a>';
                                        }
                                        if (($p->PaymentMethod == 2 || $p->PaymentMethod == 3) && $p->PaymentStatus != 1 && $p->Status != 2) {
                                            echo '<a href="Pay.php?code=' . $p->TraceCode . '" class="pay-btn" > پرداخت آنلاین</a>';
                                        }
                                        echo '</td></div>';
                                        echo "</td>";
                                        echo "</tr>";

                                        echo "<tr>";
                                        echo "<td colspan='5'>";
                                        $factorProduct2 = new FactorProductDataSource();
                                        $factorProduct2->open();
                                        $factorProducts2 = $factorProduct2->FillByCode($p->TraceCode);
                                        $factorProduct2->close();
                                        ?>
                                        <script>
                                            $(document).ready(function () {
                                                $("#<?php echo $p->FactorProductId; ?>").click(function () {
                                                    $("#<?php echo $p->TraceCode; ?>").slideToggle(0);
                                                });
                                            });
                                        </script>
                                        <table class="footable table table-stripped" data-page-size="1000000000"
                                               data-filter=#filter  id="<?php echo $p->TraceCode; ?>">
                                            <thead>
                                            <tr>
                                                <th data-sort-ignore="true" data-sort-ignore="true">نام محصول</th>
                                                <th data-hide="phone,tablet"  data-sort-ignore="true">رنگ</th>
                                                <th data-hide="phone,tablet" data-sort-ignore="true">گارانتی</th>
                                                <th data-hide="phone,tablet" data-sort-ignore="true">تعداد</th>
                                                <th data-sort-ignore="true">تصویر</th>
                                                <th data-hide="phone,tablet" data-sort-ignore="true">محتویات دانلود</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            foreach ($factorProducts2 as $f) {
                                                echo "<tr>";
                                                echo "<td><div class='DatabaseField'>" . $f->Product->Name . "</td></div>";
                                                echo "<td><div class='DatabaseField'>" . $f->Color . "</td></div>";
                                                echo "<td><div class='DatabaseField'>" . $f->Guarantee . "</td></div>";
                                                echo "<td><div class='DatabaseField'>" . $f->Count . "</td></div>";
//                                echo "<td>پرداخت شده</td>";
                                                echo "<td><img src=" . $f->Product->Image . " /></td>";
                                                if ($f->Product->Downloadable == 1 && $f->PaymentStatus == 1) {
                                                    echo "<td><div class='DatabaseField'><a href='DownloadPage.php?pid=" . $f->Product->ProductId . "&fid=" . $f->FactorProductId . "'>دانلود</a></td></div>";
                                                } elseif ($f->PaymentStatus == 5) {
                                                    echo "<td><div class='DatabaseField'>پس از پرداخت فیش</td></div>";
                                                } else {
                                                    echo "<td><div class='DatabaseField'>ندارد</td></div>";
                                                }
                                                echo "</tr>";
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <?php

                                        echo "</tr>";
                                        echo "</td>";


                                    }
                                    $TraceCode = $p->TraceCode;
                                }
                                ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


            <?php

            ?>
            <div class="Register" id="receipt">

            </div>
        </div>
    </div>

    <!-- FooTable -->
    <script src="Admin/Template/Scripts/plugins/footable/footable.all.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.footable').footable();

        });

    </script>
<?php

require_once 'Template/bottom.php';
