<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once '../Template/CustomeDate/jdatetime.class.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/BillDataSource.php';

$factorProduct = new FactorProductDataSource();
$factorProduct->open();
$items = $_POST['item'] + 50;
$factorProducts = $factorProduct->LimitedFill($items);
$total = $factorProduct->Fill();
$factorProduct->close();

$postsCounter = 0;
?>
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
<?php
$postsCounter = 0;
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
                    $bill->close();
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
                        $day = intval($date2[2]);
                        $temptimer = explode(':', $timer);
                        if (intval($temptimer[0]) > 11) {
                            $hours = (intval($temptimer[0]) + 12) - 24;
                            $day += 1;
                            $timer = $hours . ':' . $temptimer[1];
                        } else {
                            $hours = intval($temptimer[0]) + 12;
                            $timer = $hours . ':' . $temptimer[1];
                        }
                    }

                    ?>
                    <div class='DatabaseField Time2' title="زمان باقی مانده تا پاکسازی"
                         id="Timer<?php echo $p->TraceCode; ?>"></div>

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
                    echo 'هنوز پرداخت نشده';
                } elseif ($p->PaymentStatus == 5) {
                    echo 'در انتظار دریافت فیش';
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
</div>
<?php
$postsCounter = 0;
foreach ($total as $p) {
    $postsCounter++;
}

if ($postsCounter > $items) {
    ?>
    <input id="loadmore" type="button" name="loadmore" class="load-more2" value="بارگذاری موارد بیشتر..."/>
    <?php
}
?>
</div>