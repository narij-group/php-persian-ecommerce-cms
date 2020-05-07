<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';


if (isset($_GET['id']) && $_GET['id'] != 0) {
    $product = new ProductDataSource();
    $product->open();
    $stats2 = $product->GetStats($_GET['id']);
    $product->close();
    $_SESSION[SESSION_INT_PRODUCT_ID] = $_GET['id'];
} else {
    $stds = new StatDataSource();
    $stds->open();
    $stats = $stds->Fill();
    $stats2 = $stds->LimitedFill();
    $stds->close();
}
?>
<?php
include_once 'Template/top.php';
if ($role->Stats != 1) {
    header('Location:Index.php');
    die();
}

?>
<!--<link rel="stylesheet" href="Template/Stats/samples/style.css" type="text/css">-->
<script src="Template/Stats/amcharts/amcharts.js" type="text/javascript"></script>
<script src="Template/Stats/amcharts/serial.js" type="text/javascript"></script>
<script>
    var chart;
    var chartData = [];
    var chartCursor;


    AmCharts.ready(function () {
        // generate some data first
        generateChartData();

        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();

        chart.dataProvider = chartData;
        chart.categoryField = "date";
        chart.balloon.bulletSize = 5;

        // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
        chart.addListener("dataUpdated", zoomChart);

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        categoryAxis.dashLength = 1;
        categoryAxis.minorGridEnabled = true;
        categoryAxis.twoLineMode = true;
        categoryAxis.dateFormats = [{
            period: 'fff',
            format: 'JJ:NN:SS'
        }, {
            period: 'ss',
            format: 'JJ:NN:SS'
        }, {
            period: 'mm',
            format: 'JJ:NN'
        }, {
            period: 'hh',
            format: 'JJ:NN'
        }, {
            period: 'DD',
            format: 'DD'
        }, {
            period: 'WW',
            format: 'DD'
        }, {
            period: 'MM',
            format: 'MMM'
        }, {
            period: 'YYYY',
            format: 'YYYY'
        }];

        categoryAxis.axisColor = "#DADADA";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisAlpha = 0;
        valueAxis.dashLength = 1;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.title = "red line";
        graph.valueField = "visits";
        graph.bullet = "round";
        graph.bulletBorderColor = "#FFFFFF";
        graph.bulletBorderThickness = 2;
        graph.bulletBorderAlpha = 1;
        graph.lineThickness = 2;
        graph.lineColor = "#009cff";
        graph.negativeLineColor = "#009cff";
        graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
        chart.addGraph(graph);
        chart.dataDateFormat = "YYYY-MM-DD";

        // CURSOR
        chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorPosition = "mouse";
        chartCursor.pan = true; // set it to fals if you want the cursor to work in "select" mode
        chart.addChartCursor(chartCursor);

        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart.addChartScrollbar(chartScrollbar);

        chart.creditsPosition = "bottom-right";

        // WRITE
        chart.write("chartdiv");
    });

    // generate some random data, quite different range
    function generateChartData() {
        var firstDate = new Date();
        <?php
        $stat = new StatDataSource();
        $stat->open();
        $stat2 = $stat->getFirstDate();
        if (isset($_GET['id']) && $_GET['id'] != 0) {
            $stat3 = $stat->getDatesForProduct($_GET['id']);
            $dates = array_unique($stat3);
        } else {
            $stat3 = $stat->getDates();
            $dates = array_unique($stat3);
        }
        $stat->close();
        ?>
        firstDate.setDate();
        <?php
        foreach ($dates as $d) {
        $stat = new StatDataSource();
        $stat->open();
        if (isset($_GET['id']) && $_GET['id'] != 0) {
            $stat->Product = $_GET['id'];
            $visits = $stat->findVisitsOfProduct($_GET['id'], $d);
        } else {
            $visits = $stat->findVisitsOfDate($d);
        }


        if ($visits != 0) {
        ?>
        // we create date objects here. In your data, you can have date strings
        // and then set format of your dates using chart.dataDateFormat property thx bruh <3,
        // however when possible, use date objects, as this will speed up chart rendering.
        var newDate = new Date(firstDate);
        newDate.setDate(<?php echo $d; ?>);

        chartData.push({
            date: "<?php echo $d ?>",
            visits: "<?php echo $visits; ?>"
        });
        <?php
        }
        }
        ?>
    }


    // this method is called when chart is first inited as we listen for "dataUpdated" event
    function zoomChart() {
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart.zoomToIndexes(chartData.length - 30, chartData.length - 1);
    }

    // changes cursor mode from pan to select
    function setPanSelect() {
        if (document.getElementById("rb1").checked) {
            chartCursor.pan = false;
            chartCursor.zoomable = true;
        } else {
            chartCursor.pan = true;
        }
        chart.validateNow();
    }

</script>
<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>نمودار بازدید</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Statistics</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1"> نمودار بازدید ها</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2">آمار</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3"> جزئیات</a></li>

                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">

                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <?php
                                    if (isset($_GET['id']) && $_GET['id'] != 0) {
                                        ?>
                                        Product Visits Chart
                                        <?php
                                    } else {
                                        ?>
                                        نمودار بازدید ها
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="panel-body">

                                    <div class="Stat">
                                        <div id="chartdiv" style="width: 100%; height: 500px;"></div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">

                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    آمار
                                </div>
                                <div class="panel-body">
                                    <?php
                                    if (isset($_GET['id']) && $_GET['id'] != 0) {

                                    } else {
                                        ?>
                                        <div class="stat-detail">
                                            <div class="db-cover3" id="wait" style="display: block;">
                                                <img class="loading-gif5" src="Template/Images/gifs/loading.gif"
                                                     alt=""/>
                                            </div>
                                            <table id="details" class="footable table table-stripped"
                                                   data-page-size="1000000000">
                                                <thead>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        افراد آنلاین :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        بازدید کنندگان امروز :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        بازدید امروز :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        بازدید کنندگان دیروز :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        بازدید دیروز :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        بازدید کنندگان این ماه :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        بازدید این ماه :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        میانگین بازدید روزانه :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        میانگین بازدید کنندگان روزانه :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        پر بازدید ترین روز :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        پر بیننده ترین روز :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        بازدید کل :
                                                    </td>
                                                    <td class='DatabaseField2'>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='DatabaseField2'>
                                                        بازدید کنندگان کل :
                                                    </td>
                                                    <td class='DatabaseField2'>

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
                                            </table>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body">

                            <?php
                            date_default_timezone_set("Asia/Tehran");
                            ?>
                            <div class="MainTitle alert-info"><span
                                        style="float: right; font-size: 9pt; font-weight: bold; margin-right: 10px;"><?php echo date("H:i:s", time()); ?></span>50
                                بازدید آخر <a href="AllStats.php" class="btn btn-primary">Show All</a></div>
                            <div class="Database">
                                <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                       placeholder="جستجو در لیست موجود در این صفحه">
                                <table class="footable table table-stripped" data-page-size="1000000000"
                                       data-filter=#filter>
                                    <thead>
                                    <tr>
                                        <th>صفحه</th>
                                        <!--                    <th>تعداد بازدید</th>-->
                                        <th>IP</th>
                                        <th>محصول</th>
                                        <th data-hide="phone,tablet">زمان</th>
                                        <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                        <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $i = 0;
                                    foreach ($stats2 as $s) {
                                        echo "<tr>";
                                        echo "<td class='DatabaseField2'><div class='DatabaseField breakwords' >" . $s->Page . "</div></td>";
//                    echo "<td class='DatabaseField2'><div class='DatabaseField' >" . $s->Visit . "</div></td>";
                                        echo "<td class='DatabaseField2'><div class='DatabaseField' >" . $s->UserIP . "</div></td>";
                                        echo "<td class='DatabaseField2'><div class='DatabaseField' >" . $s->Product . "</div></td>";
                                        echo "<td class='DatabaseField2'><div class='DatabaseField' >" . $s->Date . "</div></td>";
                                        echo "<td class='DatabaseField2'><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Stat.php?";
                                        if (isset($_GET['id']) == TRUE) {
                                            echo "pid=$s->Product&";
                                        }
                                        echo "id=$s->StatId'>ویرایش</a></button></td>";
                                        echo "<td class='DatabaseField2'><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='DeleteStat.php?";
                                        if (isset($_GET['id']) == TRUE) {
                                            echo "pid=$s->Product&";
                                        }
                                        echo "id=$s->StatId'>حذف</a></button></td>";
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


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'AjaxStatsLoad.php',
            type: 'post',
            success: function (res) {
                $(".db-cover3").fadeOut(750);
                $('#details').html(res);
            }
        })
    });
</script>
<?php
include_once 'Template/bottom.php';
    