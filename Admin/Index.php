<?php

require_once 'Template/adminMainPageTop.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';


//require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';

if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
}
?>
    <!DOCTYPE html>
    <?php

    include_once 'Template/menu.php';
    ?>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-6">
            <h2>صفحه اصلی</h2>
        </div>
        <div class="col-lg-6" style="text-align: left;">
            <h2>Dashboard</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">

            <div class="col-lg-12" <?php
            if ($role->Settings != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Settings.php">
                    <div class="widget style1 btn-default">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-cog fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <h2 class="font-bold" style="color: #18a689">تنظیمات</h2>
                                <span class="text-danger">
                                    منوهای سایت ، نام و لوگوی سایت ، نماد الکترونیک ، اطلاعات سایت ( شماره تماس ، ایمیل ، شبکه
                                    های اجتماعی و ... )  و ...
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Products != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Products.php">
                    <div class="widget style1 yellow-bg btn-warning">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-product-hunt fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    محصولات
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->UserCoupons != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="UserCoupons.php">
                    <div class="widget style1 lazur-bg btn-info">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-drivers-license fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    کپن مشتری ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Users != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Users.php">
                    <div class="widget style1 navy-bg btn-primary">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-user-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    کاربر ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->ProductCoupons != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="ProductCoupons.php">
                    <div class="widget style1 red-bg btn-danger">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-list-alt fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    کپن محصولات
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Orders != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Orders.php">
                    <div class="widget style1 btn-success">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-file-text fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    درخواست های کالا
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->FactorProducts != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="FactorProductsTable.php">
                    <div class="widget style1 navy-bg btn-primary">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-file-text-o fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    سفارشات
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->ShippingMethods != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="ShippingMethods.php">
                    <div class="widget style1 red-bg btn-danger">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-truck fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    روش های حمل
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->LinkBoxes != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="LinkBoxes.php">
                    <div class="widget style1 yellow-bg btn-warning">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-link fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    پیوند ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Panels != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Panels.php">
                    <div class="widget style1 navy-bg btn-primary">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-clone fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    درخواست های پنل فروش
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Slides != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Slides.php">
                    <div class="widget style1 yellow-bg btn-warning">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-file-image-o fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    اسلاید ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Thumbs != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Thumbs.php">
                    <div class="widget style1 lazur-bg btn-info">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-photo fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    ریزعکس ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Prices != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Prices.php">
                    <div class="widget style1 btn-success">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-dollar fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    قیمت ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Shippings != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Shippings.php">
                    <div class="widget style1 red-bg btn-danger">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-bus fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    حمل و نقل ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Comments != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Comments.php">
                    <div class="widget style1 btn-primary">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-commenting fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    پرسش و پاسخ ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Discounts != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Discounts.php">
                    <div class="widget style1 red-bg btn-danger">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-money fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    تخفیف ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Brands != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Logos.php">
                    <div class="widget style1 yellow-bg btn-warning">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-apple fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    برند ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Customers != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Customers.php">
                    <div class="widget style1 navy-bg btn-primary">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-user-o fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    مشتری ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->ProductProperties != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="ProductProperties.php">
                    <div class="widget style1 lazur-bg btn-info">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-file-text fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    ویژگی های محصولات
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->PaymentMethods != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="PaymentMethods.php">
                    <div class="widget style1 btn-success">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-credit-card-alt fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    روش های پرداخت
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Opinions != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Opinions.php">
                    <div class="widget style1 red-bg btn-danger">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-wechat fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    نظرات
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Feeds != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Feeds.php">
                    <div class="widget style1 lazur-bg btn-info">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-feed fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    خبرنامه
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Guarantees != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="GuaranteeLists.php">
                    <div class="widget style1 red-bg btn-danger">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-diamond fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    گارانتی ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Colors != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="ColorLists.php">
                    <div class="widget style1 yellow-bg btn-warning">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-delicious fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    رنگ ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Services != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Services.php">
                    <div class="widget style1 navy-bg btn-primary">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-info-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    خدمات
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Groups != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Groups.php">
                    <div class="widget style1 yellow-bg btn-warning">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-th-list fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    مجموعه ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->SubGroups != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="SubGroups.php">
                    <div class="widget style1 btn-success">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-sitemap fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    زیرمجموعه ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->SupperGroups != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="SupperGroups.php">
                    <div class="widget style1 red-bg btn-danger">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-sitemap fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    زیر زیرمجموعه ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->Roles != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="Roles.php">
                    <div class="widget style1 lazur-bg btn-info">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-male fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    نقش ها
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->News != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="News.php">
                    <div class="widget style1 navy-bg btn-primary">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-newspaper-o fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    اخبار
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3" <?php
            if ($role->SpecialOffers != 1) {
                echo ' style="display:none;" ';
            } ?>>
                <a href="SpecialOfferTitles.php">
                    <div class="widget style1 lazur-bg btn-info">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-diamond fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-left">
                                <span>
                                    عنوان های پیشنهادات ویژه
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


        </div>
    </div>


<?php
include_once 'Template/bottom.php';
