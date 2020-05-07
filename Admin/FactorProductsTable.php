<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';
?>
<meta http-equiv="refresh" content="1800">
<?php
if ($role->FactorProducts != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';

require_once '../Template/CustomeDate/jdatetime.class.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/BillDataSource.php';

$fpds = new FactorProductDataSource();
$fpds->open();
$items = 50;
$factorProducts = $fpds->LimitedFill($items);
$total = $fpds->Fill();
$total2 = $fpds->FullFill();
foreach ($total2 as $p) {
    if ($p->PaymentStatus == 2 || $p->PaymentStatus == 3 || $p->PaymentStatus == 0) {
        if (strpos($p->Time, 'PM') !== false) {
            $timer = trim(str_replace('PM', '', "$p->Time"));
            $timer = trim(str_replace("01", "13", $timer));
            $timer = trim(str_replace("02", "14", $timer));
            $timer = trim(str_replace("03", "15", $timer));
            $timer = trim(str_replace("04", "16", $timer));
            $timer = trim(str_replace("05", "17", $timer));
            $timer = trim(str_replace("06", "18", $timer));
            $timer = trim(str_replace("07", "19", $timer));
            $timer = trim(str_replace("08", "20", $timer));
            $timer = trim(str_replace("09", "21", $timer));
            $timer = trim(str_replace("10", "22", $timer));
            $timer = trim(str_replace("11", "23", $timer));
        } elseif (strpos($p->Time, 'AM') !== false) {
            $timer = trim(str_replace('AM', '', "$p->Time"));
            $timer = trim(str_replace("12", "00", $timer));
        }
        $timer2 = explode(':', $timer);
        $date2 = explode('/', $p->Date);
        $date = new jDateTime(true, true, 'Asia/Tehran');

        if ($p->PaymentStatus == 2 || $p->PaymentStatus == 3) {
            $time3 = $date->mktime($timer2[0], $timer2[1], 0, intval($date2[1]), intval($date2[2]) + 1, intval($date2[0]), false, 'America/New_York');
            if ($time3 < time()) {
                $var = new FactorProductDataSource();
                $var->open();
//                $var->TraceCode = $p->TraceCode;
                $vars = $var->FillByCode($p->TraceCode);
                foreach ($vars as $v) {
                    $var->Delete($v->FactorProductId);
                }
                $var->close();
            }
        } elseif ($p->PaymentStatus == 0) {
            $hours = intval($timer2[0]);
            $day = intval($date2[2]);
            if (intval($timer2[1]) > 25) {
                $mins = (intval($timer2[1]) + 35) - 60;
                $hours += 1;
                if (intval($timer2[0]) > 23) {
                    $hours = 00;
                    $day += 1;
                    $timer2[0] = $hours;
                } else {
                    $timer2[0] = $hours;
                }
                $timer2[1] = $mins;
            } else {
                $mins = intval($timer2[1]) + 35;
                $timer2[1] = $mins;
            }

            $time3 = mktime($timer2[0], $timer2[1], 00, $day, intval($date2[2]), intval($date2[0]));

            if ($time3 < time()) {
                $var = new FactorProduct();
                $var->TraceCode = $p->TraceCode;
                $vars = $var->FillByCode();
                foreach ($vars as $v) {
                    $productcolor = new ProductColor();
                    $productcolor = $productcolor->FindOneProductColor2($v->Color, $v->Product->ProductId);
                    $productcolor->Quantity = $productcolor->Quantity + $v->Count;
                    $productcolor->UpdateQuantity();
                    $v->Delete();
                }
            }
        }
    }
}

?>
<!--<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>-->
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="lib/persian-date.js" type="text/javascript"></script>
<script src="js/persian-datepicker-0.4.5.js" type="text/javascript"></script>
<link href="css/persian-datepicker-0.4.5.css" rel="stylesheet" type="text/css"/>

<style>
    .datepicker-plot-area {
        direction: ltr;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading print-hidden">
    <div class="col-lg-6">
        <h2>سفارشات</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Factors</h2>
    </div>
</div>

<div class="modalback print-hidden">
    <div class="loader5"><img src="Template/Images/gifs/loading.gif"/></div>
</div>
<div class="modalback print-hidden" id="modalback"></div>
<div class="product-info print-hidden" id="p-info"></div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row print-hidden">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title \\">
                    <h5>منو</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <link rel="stylesheet" href="Template/Styles/print-style.css" type="text/css" media="print"/>

                    <script>
                        function printFunction() {
//                            window.print();
                            $("body > table").addClass("print-hidden");
                            $(this).parents("table").last().removeClass("print-hidden");
                            if (window.print) {
                                window.print();
                            }
                        }
                    </script>

                    <form id="search_form" class="search_form">
                        <div class="alert alert-success">
                            جستجو براساس نام مشتری،کد ملی مشتری،کد پیگیری و شناسه
                        </div>
                        <div class="database-search2">
                            <input class="form-control" type="text" name="search_box" id="search_box" placeholder="جستجو..."
                                   title="جستجو براساس نام مشتری،کد ملی مشتری،کد پیگیری و شناسه" value=""/>
                        </div>
                        <div class="search-dates">
                            <div class="labels">
                                <div>تاریخ شروع</div>
                            </div>
                            <input type="text" id="end-date" readonly="" class="form-control" name="end-date"
                                   title="تاریخ پابان"/>
                            <div class="labels">
                                <div>تاریخ پایان</div>
                            </div>
                            <input type="text" id="start-date" readonly="" class="form-control" name="start-date"
                                   title="تاریخ شروع"/>
                        </div>
                        <!--            <div class="labels">-->
                        <!--                <div>تاریخ شروع</div>-->
                        <!--                <div>تاریخ پایان</div>-->
                        <!--            </div>-->
                    </form>
                    <div class="clear-fix"></div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title print-hidden">
                    <h5>لیست سفارشات</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <a href="FactorProducts.php">
                        <button class="btn btn-warning btn-w-m" type="button"><i class="fa fa-star"></i>
                            نمایش فاکتور ها
                        </button>
                    </a>
                    <a href="FactorProductInProgress.php">
                        <button class="btn btn-danger btn-w-m" type="button"><i class="fa fa-star-half-empty"></i>
                            پرداخت های ناموفق
                        </button>
                    </a>
                    <a class="hidden-xs">
                        <button class="btn btn-outline btn-success btn-w-m" type="button" onclick="printFunction()"><i
                                    class="fa fa-print"></i>
                            چاپ لیست
                        </button>
                    </a>

                    <div id="db">
                        <script>
                            $(document).ready(function () {
                                $('#loadmore').click(function () {
                                    $('.modalback').fadeIn(0);
                                    $.ajax({
                                        url: 'LoadMoreF.php',
                                        type: 'POST',
                                        data: {item: <?php echo $items; ?>},
                                        success: function (result) {
                                            $("#db").html(result);
                                            $('.modalback').fadeOut(0);
                                        },
                                        error: function (result) {
                                            alert("لطفا دوباره امتحان کنید!");
                                            $('.modalback').fadeOut(0);
                                        }
                                    });
                                });
                            });

                        </script>
                        <div class="Database">


                            <div class="db-cover print-hidden" id="wait">
                <span class="loading-title print-hidden <?php
                if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                    echo " SBackground'";
                } else {
                    echo " GBackground'";
                }
                ?>">Loading...</span>
                                <img class="loading-gif" src="Template/Images/gifs/giphy (3).gif" alt=""/>
                            </div>
                            <table class="footable table table-stripped" data-page-size="1000000000">
                                <thead>
                                <tr>
                                    <th>شناسه</th>
                                    <th> کد پیگیری</th>
                                    <th>وضعیت سفارش</th>
                                    <th data-hide="phone,tablet"> وضعیت پرداخت</th>
                                    <th data-hide="phone,tablet"> زمان</th>
                                    <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $postsCounter = 0;
                                $TraceCode = "";
                                $i = 0;
                                foreach ($factorProducts as $p) {
                                    if ($TraceCode != $p->TraceCode) {
                                        $date2 = explode('/', $p->Date);
                                        $date = new jDateTime(true, true, 'Asia/Tehran');
                                        $time2 = $date->mktime(0, 0, 0, intval($date2[1]), intval($date2[2]), intval($date2[0]), false, 'America/New_York');
                                        $postsCounter++;
                                        echo "<tr class='clickable-row' data-href='FactorProducts.php?code=$p->TraceCode' >";
                                        echo "<td style='padding : 5px 0 5px 0;' ><div class='DatabaseField' >";
                                        if ($p->PaymentStatus == 5) {
                                            echo '<div class="red-circle ';
                                            $bill = new BillDataSource();
                                            $bill->open();
                                            $b = $bill->FindByCode($p->TraceCode);
                                            $bill->close();
                                            if ($b != null) {
                                                if ($b->Status == 0) {
                                                    echo "red";
                                                } elseif ($b->Status == 1) {
                                                    echo "green notification2";
                                                } elseif ($b->Status == 2) {
                                                    echo "green";
                                                } elseif ($b->Status == 3) {
                                                    echo "red notification2";
                                                }
                                            } else {
                                                echo "red";
                                            }
                                            echo ' "></div>';
                                        } else {
                                            echo $p->FactorProductId;
                                        }
                                        echo "</div></td>";
                                        echo "<td><div class='DatabaseField' >" . $p->TraceCode . "</div></td>";
                                        echo "<td><div class='DatabaseField' >";
                                        if ($p->PaymentStatus != 3 && $p->PaymentStatus != 2 && $p->PaymentStatus != 0) {
                                            if ($p->Status == 0) {
                                                echo "در انتظار بررسی";
                                            } elseif ($p->Status == 1) {
                                                echo 'تایید شد و در پروسه انبار';
                                            } elseif ($p->Status == 2) {
                                                echo 'ارسال شد';
                                            } elseif ($p->Status == 3) {
                                                echo 'لغو شد';
                                            } elseif ($p->Status == 4) {
                                                echo 'توسط مشتری حذف شد';
                                            }
                                        } else {
                                            $monthNum = $date2[1];
                                            $dateObj = DateTime::createFromFormat('!m', $monthNum);
                                            $monthName = $dateObj->format('F'); // March
                                            if (strpos($p->Time, 'PM') !== false) {
                                                $timer = trim(str_replace('PM', '', "$p->Time"));
                                                $timer = trim(str_replace("01", "13", $timer));
                                                $timer = trim(str_replace("02", "14", $timer));
                                                $timer = trim(str_replace("03", "15", $timer));
                                                $timer = trim(str_replace("04", "16", $timer));
                                                $timer = trim(str_replace("05", "17", $timer));
                                                $timer = trim(str_replace("06", "18", $timer));
                                                $timer = trim(str_replace("07", "19", $timer));
                                                $timer = trim(str_replace("08", "20", $timer));
                                                $timer = trim(str_replace("09", "21", $timer));
                                                $timer = trim(str_replace("10", "22", $timer));
                                                $timer = trim(str_replace("11", "23", $timer));
                                            } elseif (strpos($p->Time, 'AM') !== false) {
                                                $timer = trim(str_replace('AM', '', "$p->Time"));
                                                $timer = trim(str_replace("12", "00", $timer));
                                            }
                                            if ($p->PaymentStatus == 3 || $p->PaymentStatus == 2) {
                                                $day = intval($date2[2]) + 1;
                                            } elseif ($p->PaymentStatus == 0) {
                                                $timer2 = explode(':', $timer);
                                                $hours = intval($timer2[0]);
                                                $day = intval($date2[2]);
                                                if (intval($timer2[1]) > 25) {
                                                    $mins = (intval($timer2[1]) + 35) - 60;
                                                    $day = intval($date2[2]);
                                                    if (intval($timer2[0]) > 23) {
                                                        $hours = 00;
                                                        $day += 1;
                                                        $timer2[0] = $hours;
                                                    } else {
                                                        $hours += 1;
                                                        $timer2[0] = $hours;
                                                    }
                                                    $timer2[1] = $mins;
                                                } else {
                                                    $mins = intval($timer2[1]) + 35;
                                                    $timer2[1] = $mins;
                                                }
                                                $timer = $hours . ':' . $mins;
                                            }

                                            ?>
                                            <a onclick="return deleteConfirm()"
                                               href="DeleteFactorProduct.php?code=<?php echo $p->TraceCode; ?>"
                                               class='DatabaseField Time2' title="زمان باقی مانده تا پاکسازی"
                                               id="Timer<?php echo $p->TraceCode; ?>"></a>

                                            <script>
                                                var countDownDate<?php echo $i; ?> = new Date("<?php echo $monthName . " " . $day . ", " . $date2[0] . " " . $timer . ":00";  ?>").getTime();
                                                var x<?php echo $i; ?> = setInterval(function () {
                                                    var now = new Date().getTime();
                                                    var distance = countDownDate<?php echo $i; ?> - now;
                                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                    document.getElementById("Timer<?php echo $p->TraceCode; ?>").innerHTML = hours + 'h '
                                                        + minutes + "m";
                                                    if (distance < 0) {
                                                        clearInterval(x<?php echo $i; ?>);
                                                        document.getElementById("Timer<?php echo $p->TraceCode; ?>").innerHTML = "EXPIRED";
                                                    }
                                                }, 1000);
                                            </script>
                                            <?php
                                            $i++;
                                        }
                                        echo "</div></td>";
                                        echo "<td><div class='DatabaseField' >";
                                        if ($p->PaymentStatus == 0) {
                                            echo 'در حال پرداخت...';
                                        } elseif ($p->PaymentStatus == 1) {
                                            echo 'پرداخت شد';
                                        } elseif ($p->PaymentStatus == 2) {
                                            echo 'شکست خورد';
                                        } elseif ($p->PaymentStatus == 3) {
                                            echo 'توسط کاربر لغو شد';
                                        } elseif ($p->PaymentStatus == 4) {
                                            echo 'پرداخت در محل';
                                        } elseif ($p->PaymentStatus == 5) {
                                            echo 'در انتظار دریافت فیش';
                                        } elseif ($p->PaymentStatus == 6) {
                                            echo 'پرداخت شد | نبود موجودی!';
                                            echo "<br/>";
                                            echo "لطفا وجه را به مشتری بازگردانید";
                                        }
                                        echo " </div ></td > ";
                                        echo "<td><div class='DatabaseField' >" . $date->date("l j F Y", $time2, true, true, 'Asia/Tehran') . "</div></td>";
                                        echo "<td><div class='DatabaseField Time' >" . $p->Time . "</div></td>";
                                        echo "</tr>";


                                    }
                                    $TraceCode = $p->TraceCode;
                                }
                                ?>
                                </tbody>
                                <!--                    <tfoot  style="direction: ltr">-->
                                <!--                    <tr>-->
                                <!--                        <td colspan="5">-->
                                <!--                            <ul class="pagination pull-right"></ul>-->
                                <!--                        </td>-->
                                <!--                    </tr>-->
                                <!--                    </tfoot>-->
                            </table>
                            <?php
                            $postsCounter = 0;
                            foreach ($total as $p) {
                                $postsCounter++;
                            }
                            ?>
                        </div>
                        <?php
                        if ($postsCounter > 50) {
                            ?>
                            <input id="loadmore" type="button" name="loadmore" class="load-more2"
                                   value="بارگذاری موارد بیشتر..."/>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /*
     Default Functionality
     */
    $(document).ready(function () {
        /*
         Default
         */
        window.pd = $("#inlineDatepicker").persianDatepicker({
            timePicker: {
                enabled: true
            },
            altField: '#inlineDatepickerAlt',
            altFormat: "YYYY MM DD HH:mm:ss",
//            minDate:1258675200000,
//            maxDate:1358675200000,
            checkDate: function (unix) {
                var output = true;
                var d = new persianDate(unix);
                if (d.date() == 20) {
                    output = false;
                }
                return output;
            },
            checkMonth: function (month) {
                var output = true;
                if (month == 1) {
                    output = false;
                }
                return output;

            }, checkYear: function (year) {
                var output = true;
                if (year == 1396) {
                    output = false;
                }
                return output;
            }

        }).data('datepicker');

        $("#inlineDatepicker").pDatepicker("setDate", [1391, 12, 1, 11, 14]);


        /**
         * Default
         * */
        $('#default').persianDatepicker({
            altField: '#defaultAlt'

        });


        /*
         observer
         */
        $("#observer").persianDatepicker({
            altField: '#observerAlt',
            altFormat: "YYYY MM DD HH:mm:ss",
            observer: true,
            format: 'YYYY/MM/DD'

        });
        $("#start-date").persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD'

        });
        $("#end-date").persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD'

        });

        /*
         timepicker
         */
        $("#timepicker").persianDatepicker({
            altField: '#timepickerAltField',
            altFormat: "YYYY MM DD HH:mm:ss",
            format: "HH:mm:ss a",
            onlyTimePicker: true

        });
        /*
         month
         */
        $("#monthpicker").persianDatepicker({
            format: " MMMM YYYY",
            altField: '#monthpickerAlt',
            altFormat: "YYYY MM DD HH:mm:ss",
            yearPicker: {
                enabled: false
            },
            monthPicker: {
                enabled: true
            },
            dayPicker: {
                enabled: false
            }
        });

        /*
         year
         */
        $("#yearpicker").persianDatepicker({
            format: "YYYY",
            altField: '#yearpickerAlt',
            altFormat: "YYYY MM DD HH:mm:ss",
            dayPicker: {
                enabled: false
            },
            monthPicker: {
                enabled: false
            },
            yearPicker: {
                enabled: true
            }
        });
        /*
         year and month
         */
        $("#yearAndMonthpicker").persianDatepicker({
            format: "YYYY MM",
            altFormat: "YYYY MM DD HH:mm:ss",
            altField: '#yearAndMonthpickerAlt',
            dayPicker: {
                enabled: false
            },
            monthPicker: {
                enabled: true
            },
            yearPicker: {
                enabled: true
            }
        });
        /**
         inline with minDate and maxDate
         */
        $("#inlineDatepickerWithMinMax").persianDatepicker({
            altField: '#inlineDatepickerWithMinMaxAlt',
            altFormat: "YYYY MM DD HH:mm:ss",
            minDate: 1416983467029,
            maxDate: 1419983467029
        });
        /**
         Custom Disable Date
         */
        $("#customDisabled").persianDatepicker({
            timePicker: {
                enabled: true
            },
            altField: '#customDisabledAlt',
            checkDate: function (unix) {
                var output = true;
                var d = new persianDate(unix);
                if (d.date() == 20 | d.date() == 21 | d.date() == 22) {
                    output = false;
                }
                return output;
            },
            checkMonth: function (month) {
                var output = true;
                if (month == 1) {
                    output = false;
                }
                return output;

            }, checkYear: function (year) {
                var output = true;
                if (year == 1396) {
                    output = false;
                }
                return output;
            }

        });

        /**
         persianDate
         */
        $("#persianDigit").persianDatepicker({
            altField: '#persianDigitAlt',
            altFormat: "YYYY MM DD HH:mm:ss",
            persianDigit: false
        });
    });
</script>
<script type="text/javascript">

    $(document).ready(function () {
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
        $(".product-id2").click(function () {
            var productId = $(this).text();
            $.ajax({
                url: 'ProductInfo.php',
                type: 'POST',
                data: {productId: productId},
                success: function (result) {
                    $("#p-info").html(result);
                    $("#p-info").fadeIn(250);
                    $("#modalback").fadeIn(250);
                }
            });
        });
        $('#search_box').keyup(function () {
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'AjaxFactorProducts.php',
                data: $('#search_form').serialize(),
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                }
            });
        });
        $('.form-control').change(function () {
            $("#wait").fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'AjaxFactorProducts.php',
                data: $('#search_form').serialize(),
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                }
            });
        });
        $("#modalback").click(function () {
            $("#p-info").fadeOut(250);
            $("#modalback").fadeOut(500);
        });
    });
</script>
<?php
include_once 'Template/bottom.php';

    