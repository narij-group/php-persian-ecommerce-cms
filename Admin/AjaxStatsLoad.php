<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
$stat = new StatDataSource();
$stat->open();
?>
<thead>
</thead>
<tbody>
<tr>
    <td class='DatabaseField2'>
        افراد آنلاین :
    </td>
    <td class='DatabaseField2'>
        <?php
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OnlineDataSource.inc';

        $online = new OnlineDataSource();
        $online->open();
        $onlines = $online->Fill();
        $online->close();
        $onlineUsers = 0;
        foreach ($onlines as $o) {
            if (time() - $o->Time < 600) {
                $onlineUsers++;
            }
        }
        echo $onlineUsers . " نفر ";
        ?>
    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        بازدید کنندگان امروز :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo $stat->todayVisistors() . " نفر ";
        ?>
    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        بازدید امروز :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo $stat->todayVisists() . " بار ";
        ?>                    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        بازدید کنندگان دیروز :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo $stat->yesterdatVisistors() . " نفر ";
        ?>                    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        بازدید دیروز :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo $stat->yesterdatVisists() . " بار ";
        ?>                    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        بازدید کنندگان این ماه :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo $stat->monthVisitors() . " نفر ";
        ?>                    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        بازدید این ماه :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo $stat->monthVisists() . " بار ";
        ?>                    </td>
</tr>
<!--                <tr>
                        <td class='DatabaseField2'>
                            بازدید کنندگان  امسال :
                        </td>
                        <td class='DatabaseField2'>
                    <?php
//                        echo $stat->yearVisitors() . " نفر ";
?>
                        </td>
                    </tr>
                    <tr>
                        <td class='DatabaseField2'>
                            بازدید امسال :
                        </td>
                        <td class='DatabaseField2'>
                    <?php
//                        echo $stat->yearVisists();
?>
                        </td>
                    </tr>-->
<tr>
    <td class='DatabaseField2'>
        میانگین بازدید روزانه :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo round($stat->dailyVisists(), 2) . " بار ";
        ?>
    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        میانگین بازدید کنندگان روزانه :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo round($stat->dailyVisistors(), 2) . " نفر ";
        ?>
    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        پر بازدید ترین روز :
    </td>
    <td class='DatabaseField2' id="detail1">
<!--        --><?php
//        echo $stat->theMostVisitedDay() . " بار ";
//        ?>
        <img class="loadimg1" src="Template/Images/gifs/loading.gif" width="30"
             alt=""/>
    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        پر بیننده ترین روز :
    </td>
    <td class='DatabaseField2' id="detail2">
<!--        --><?php
//        echo $stat->theMostVisitorDay() . " نفر";
//        ?>
        <img class="loadimg2" src="Template/Images/gifs/loading.gif" width="30"
             alt=""/>
    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        بازدید کل :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo $stat->allVisits() . " بار ";
        ?>
    </td>
</tr>
<tr>
    <td class='DatabaseField2'>
        بازدید کنندگان کل :
    </td>
    <td class='DatabaseField2'>
        <?php
        echo $stat->allVisitors() . " نفر ";
        ?>
    </td>
</tr>
</tbody>
<!--                        <tfoot  style="direction: ltr">-->
<!--                        <tr>-->
<!--                            <td colspan="5">-->
<!--                                <ul class="pagination pull-right"></ul>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        </tfoot>-->
<?php
$stat->close();
?>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'AjaxStatsLoad2.php',
            type: 'post',
            success: function (res) {
                $(".loadimg1").fadeOut(750);
                $('#detail1').html(res);
            }
        })
    });
</script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'AjaxStatsLoad3.php',
            type: 'post',
            success: function (res) {
                $(".loadimg2").fadeOut(750);
                $('#detail2').html(res);
            }
        })
    });
</script>