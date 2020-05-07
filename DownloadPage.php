<?php
/**
 * Created by PhpStorm.
 * User: kami
 * Date: 3/16/2018
 * Time: 5:33 PM
 */
ob_start();
include_once 'Template/top.php';

if (!isset($_GET['pid']) && !isset($_GET['fid'])) {
    header('location:index.php');
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/FactorProductDataSource.inc';

$pds = new ProductDataSource();
$pds->open();
$product = $pds->FindOneProductBasedOnId($_GET['pid']);
$pds->close();

$fp = new FactorProductDataSource();
$fp->open();
$factorProduct = $fp->FindOneFactorProductBasedOnId($_GET['fid']);
$fp->close();

if ((!isset($_COOKIE [COOKIE_CUSTOMER_ID]) || $_COOKIE [COOKIE_CUSTOMER_ID] == 0) && (!isset($_COOKIE [COOKIE_USER_LOGGED_IN]) || $_COOKIE [COOKIE_USER_LOGGED_IN] == "NO")) {
    ?>
    <title>محتویات دانلود</title>
    <meta name="description" content="">
    <?php
    include_once 'Template/menu.php';
    ?>

    <div class="container">
        <div class="main-container">
            <!--Main Content-->
            <div class="download-view">
                <div class="download-info">
                    <header>
                        <h1><?php echo $product->Name; ?></h1>
                        <h3><?php echo $product->LatinName; ?></h3>
                    </header>
                    <div class="download-content">
                        <a onclick="loginFirst()" href="#">ابتدا وارد شوید</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once "Template/bottom.php";

} elseif ($factorProduct->Factor->Customer->CustomerId != $_COOKIE [COOKIE_CUSTOMER_ID]) {
    ?>
    <title>محتویات دانلود</title>
    <meta name="description" content="">
    <?php
    include_once 'Template/menu.php';
    ?>

    <div class="container">
        <div class="main-container">
            <!--Main Content-->
            <div class="download-view">
                <div class="download-info">
                    <header>
                        <h1><?php echo $product->Name; ?></h1>
                        <h3><?php echo $product->LatinName; ?></h3>
                    </header>
                    <div class="download-content">
                        <span class='endTime'>شما این فایل را خریداری نکرده اید</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once "Template/bottom.php";
} else {

    date_default_timezone_set("Asia/Tehran");
    $dateStart = date_create($factorProduct->Date . " " . $factorProduct->Time);
    $dateNow = date_create();
    $dateDiff = date_diff($dateStart, $dateNow);

    ?>
    <title>محتویات دانلود</title>
    <meta name="description" content="">
    <?php
    include_once 'Template/menu.php';
    ?>

    <div class="container">
        <div class="main-container">
            <!--Main Content-->
            <div class="download-view">
                <div class="download-info">
                    <header>
                        <h1><?php echo $product->Name; ?></h1>
                        <h3><?php echo $product->LatinName; ?></h3>
                    </header>
                    <div class="download-content">
                        <?php
                        if ($dateDiff->h >= 24) {
                            echo "<span class='endTime'>زمان شما به پایان رسیده است</span>";
                        } elseif ($dateDiff->h < 24) {
                            echo $product->getDownloadContent();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once "Template/bottom.php";
}