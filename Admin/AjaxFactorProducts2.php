<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once '../Template/CustomeDate/jdatetime.class.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/BillDataSource.php';
$search_query = "";


if (isset($_POST['search_box']) && $_POST['search_box'] != "") {
    $key = $_POST['search_box'];
    $search_query .= " WHERE (factorproducts.TraceCode = '$key' || factorproducts.RefId = '$key' || factorproducts.FactorProductId = '$key' || customers.Name LIKE '%$key%' || customers.Family LIKE '%$key%' || customers.NationalityCode LIKE '%$key%') ";
}
$factorProduct = new FactorProductDataSource();
$factorProduct->open();
$factorProducts = $factorProduct->Search2($search_query);
$factorProduct->close();
?>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".clickable-row").click(function () {
                window.location = $(this).data("href");
            });
        });
    </script>
<?php
if ($factorProducts != NULL) {
    ?>
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
                           href="DeleteFactorProduct.php?code=<?php echo $p->TraceCode; ?>" class='DatabaseField Time2'
                           title="زمان باقی مانده تا پاکسازی"
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
        } else {
            echo '<div class="Database"><div class="no-result2">';
            echo "هیچ نتیجه ای  پیدا نشد";
            echo '</div>';
        }
        ?>
    </div>

<?php

function div($a, $b)
{
    return (int)($a / $b);
}

function gregorian_to_jalali($g_y, $g_m, $g_d, $str)
{
    $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);


    $gy = $g_y - 1600;
    $gm = $g_m - 1;
    $gd = $g_d - 1;

    $g_day_no = 365 * $gy + div($gy + 3, 4) - div($gy + 99, 100) + div($gy + 399, 400);

    for ($i = 0; $i < $gm; ++$i)
        $g_day_no += $g_days_in_month[$i];
    if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0)))
        /* leap and after Feb */
        $g_day_no++;
    $g_day_no += $gd;

    $j_day_no = $g_day_no - 79;

    $j_np = div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
    $j_day_no = $j_day_no % 12053;

    $jy = 979 + 33 * $j_np + 4 * div($j_day_no, 1461); /* 1461 = 365*4 + 4/4 */

    $j_day_no %= 1461;

    if ($j_day_no >= 366) {
        $jy += div($j_day_no - 1, 365);
        $j_day_no = ($j_day_no - 1) % 365;
    }

    for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
        $j_day_no -= $j_days_in_month[$i];
    $jm = $i + 1;
    $jd = $j_day_no + 1;
    if ($str)
        return $jy . '/' . $jm . '/' . $jd;
    return array($jy, $jm, $jd);
}

function jalali_to_gregorian($j_y, $j_m, $j_d, $str)
{
    $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);


    $jy = (int)($j_y) - 979;
    $jm = (int)($j_m) - 1;
    $jd = (int)($j_d) - 1;

    $j_day_no = 365 * $jy + div($jy, 33) * 8 + div($jy % 33 + 3, 4);

    for ($i = 0; $i < $jm; ++$i)
        $j_day_no += $j_days_in_month[$i];

    $j_day_no += $jd;

    $g_day_no = $j_day_no + 79;

    $gy = 1600 + 400 * div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
    $g_day_no = $g_day_no % 146097;

    $leap = true;
    if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */ {
        $g_day_no--;
        $gy += 100 * div($g_day_no, 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
        $g_day_no = $g_day_no % 36524;

        if ($g_day_no >= 365)
            $g_day_no++;
        else
            $leap = false;
    }

    $gy += 4 * div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
    $g_day_no %= 1461;

    if ($g_day_no >= 366) {
        $leap = false;

        $g_day_no--;
        $gy += div($g_day_no, 365);
        $g_day_no = $g_day_no % 365;
    }

    for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
        $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
    $gm = $i + 1;
    $gd = $g_day_no + 1;
    if ($str)
        return $gy . '/' . $gm . '/' . $gd;
    return array($gy, $gm, $gd);
}

function comparedate($_date_mix_jalaly, $_date_mix_gregorian)
{
    $_date_arr_jalaly = explode('/', $_date_mix_jalaly);
    $_date_arr_gregorian = explode('/', $_date_mix_gregorian);

    $arr_jtg = jalali_to_gregorian($_date_arr_jalaly[0], $_date_arr_jalaly[1], $_date_arr_jalaly[2]);

    if ($_date_arr_gregorian[0] > $arr_jtg[0]) {
        return false;
    } else if ($_date_arr_gregorian[0] == $arr_jtg[0] && $_date_arr_gregorian[1] > $arr_jtg[1]) {
        return false;
    } else if ($_date_arr_gregorian[0] == $arr_jtg[0] && $_date_arr_gregorian[1] == $arr_jtg[1] && $_date_arr_gregorian[2] > $arr_jtg[2]) {
        return false;
    }
    return true;
}
