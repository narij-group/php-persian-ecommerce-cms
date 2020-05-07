<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
$product = new Product();
$fp = new FactorProductDataSource();
$fp->open();
$fps = $fp->Fill();
$TraceCode = "";
$i = 0;
foreach ($fps as $p) {
    if ($TraceCode != $p->TraceCode) {
        $TraceCode = $p->TraceCode;
        $factors[$i] = $p;
        $i++;
    }
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
        graph.valueField = "money_payed";
        graph.bullet = "round";
        graph.bulletBorderColor = "#FFFFFF";
        graph.bulletBorderThickness = 2;
        graph.bulletBorderAlpha = 1;
        graph.lineThickness = 2;
        graph.lineColor = "#009cff";
        graph.negativeLineColor = "#009cff";
        graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
        chart.addGraph(graph);
        chart.dataDateFormat = "YYYY/MM/DD";

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
        $fdates = $fp->getDates();
        $dates = array_unique($fdates);
        ?>
        firstDate.setDate();
        <?php

        foreach ($dates as $d) {

        $pays = $fp->FindAmountOfDate($d);

        if ($pays != 0) {
        ?>
        // we create date objects here. In your data, you can have date strings
        // and then set format of your dates using chart.dataDateFormat property thx bruh <3,
        // however when possible, use date objects, as this will speed up chart rendering.
        var newDate = new Date(firstDate);
        newDate.setDate(<?php echo $d; ?>);

        chartData.push({
            date: "<?php echo $d ?>",
            money_payed: "<?php echo $pays; ?>"
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
        <h2>نمودار فروش</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Finacial</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            نمودار فروش (تومان)
                        </div>
                        <div class="panel-body">

                            <div class="Stat">
                                <?php ?>
                                <div id="chartdiv" style="width: 100%; height: 500px;"></div>
                            </div>
                            <?php
                            if (isset($_GET['id']) && $_GET['id'] != 0) {

                            } else {
                            ?>
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    جزئیات
                                </div>
                                <div class="panel-body">
                                    <div class="financial-detail">
                                        <table class="footable table table-stripped" data-page-size="1000000000">
                                            <thead>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class='DatabaseField2'>
                                                    فروش امروز:
                                                </td>
                                                <td class='DatabaseField2'>
                                                    <?php
                                                    echo number_format($fp->FindAmountOfDate(date('Y/m/d'))) . " تومان";
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='DatabaseField2'>
                                                    پرفروش ترین روز:
                                                </td>
                                                <td class='DatabaseField2'>
                                                    <?php
                                                    $i = 0;
                                                    $price = array();
                                                    foreach ($dates as $d) {
                                                        $price[$i] = $fp->FindAmountOfDate($d);
                                                        $i++;
                                                    }
                                                    echo number_format(max($price)) . " تومان";
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='DatabaseField2'>
                                                    فروش این ماه:
                                                </td>
                                                <td class='DatabaseField2'>
                                                    <?php
                                                    echo number_format($fp->FindAmountOfThisDate(date('Y/m/'))) . " تومان";
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='DatabaseField2'>
                                                    فروش امسال:
                                                </td>
                                                <td class='DatabaseField2'>
                                                    <?php
                                                    echo number_format($fp->FindAmountOfThisDate(date('Y/'))) . " تومان";
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='DatabaseField2'>
                                                    درآمد روزانه:
                                                </td>
                                                <td class='DatabaseField2'>
                                                    <?php
                                                    $i = 0;
                                                    $period = new DatePeriod(
                                                        new DateTime(str_replace("/", "-", min($dates))),
                                                        new DateInterval('P1D'),
                                                        new DateTime(str_replace("/", "-", max($dates)))
                                                    );

                                                    foreach ($period as $date) {
                                                        $dates_range[] = $date->format("Y-m-d");
                                                    }

                                                    //ONLY SHOWING
                                                    $i = count($dates_range);

                                                    echo number_format($fp->FindAmounts() / $i) . " تومان";
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='DatabaseField2'>
                                                    درآمد کل:
                                                </td>
                                                <td class='DatabaseField2'>
                                                    <?php
                                                    echo number_format($fp->FindAmounts()) . " تومان";
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            if ($settings->Tax != 0) {
                                                ?>
                                                <tr title="بدون هزینه مالیات">
                                                    <td class='DatabaseField2'>
                                                        درآمد خالص:
                                                    </td>
                                                    <td class='DatabaseField2'>
                                                        <?php
                                                        $tax = $settings->Tax;
                                                        $nonTax = (100 - $tax) / 100;
                                                        echo number_format($fp->FindAmounts() * $nonTax) . " تومان";
                                                        ?>
                                                    </td>
                                                </tr>
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
                                </div>
                                <?php
                                }
                                ?>


                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
