</head>
<body class="rtls fixed-nav">
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="Template/Images/malecostume-128.png"/>
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong
                                            class="font-bold"><?php echo $user1->Username; ?></strong>
                             </span> <span
                                        class="text-muted text-xs block"><?php echo $user1->Name . " " . $user1->Family; ?>
                                    <b
                                            class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <?php
                            if ($role->EditUser != 1) {
                                ?>
                                <li><a href="User.php?id=<?php echo $user1->UserId; ?>">پروفایل</a></li>
                                <li class="divider"></li>
                                <?php
                            }
                            ?>
                            <!--                            <li><a href="#">تماس ها</a></li>-->
                            <!--                            <li><a href="#">صندوق پستی</a></li>-->
                            <li><a href="Logoff.php">خروج</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        <?php echo $settings->Owner; ?>
                    </div>
                </li>
                <li>
                    <a href="Index.php"><i class="fa fa-th-large"></i> <span
                                class="nav-label">صفحه اصلی</span></a>
                </li>
                <li class="active" <?php
                if ($role->Products != 1 && $role->ProductCoupons != 1 && $role->ProductProperties != 1 && $role->SpecialOffers != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-product-hunt"></i> <span class="nav-label">محصول</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active" <?php
                        if ($role->Products != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Products.php">محصولات</a></li>
                        <li <?php
                        if ($role->ProductCoupons != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="ProductCoupons.php">کپن محصولات</a></li>
                        <li <?php
                        if ($role->ProductProperties != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="ProductProperties.php">ویژگی های محصولات</a></li>
                        <li <?php
                        if ($role->SpecialOffers != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="SpecialOfferTitles.php">عنوان های پیشنهادات ویژه</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->Customers != 1 && $role->UserCoupons != 1 && $role->FactorProducts != 1 && $role->Orders != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-user-o"></i> <span class="nav-label">مشتری</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li <?php
                        if ($role->Customers != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Customers.php">مشتری ها</a></li>
                        <li <?php
                        if ($role->UserCoupons != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="UserCoupons.php">کپن مشتری ها</a></li>
                        <li <?php
                        if ($role->FactorProducts != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="FactorProductsTable.php">سفارشات</a></li>
                        <li <?php
                        if ($role->Orders != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Orders.php">درخواست های کالا</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->ShippingMethods != 1 && $role->Shippings != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-truck"></i> <span class="nav-label">حمل و نقل</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li <?php
                        if ($role->ShippingMethods != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="ShippingMethods.php">روش های حمل</a></li>
                        <li <?php
                        if ($role->Shippings != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Shippings.php">حمل و نقل ها</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->Comments != 1 && $role->Opinions != 1 && $role->Panels != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">صندوق پیام</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li <?php
                        if ($role->Comments != 1) {
                            echo ' style="display:none;" ';
                        } ?> ><a href="Comments.php">پرسش و پاسخ ها</a></li>
                        <li <?php
                        if ($role->Opinions != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Opinions.php">نظرات</a></li>
                        <li <?php
                        if ($role->Panels != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Panels.php">درخواست های پنل فروش</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->Users != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="Users.php"><i class="fa fa-user-circle"></i> <span class="nav-label">کاربر ها</span> </a>
                </li>
                <li <?php
                if ($role->Services != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="Services.php"><i class="fa fa-info-circle"></i> <span class="nav-label">خدمات</span></a>
                </li>
                <li <?php
                if ($role->Prices != 1 && $role->Discounts != 1 && $role->PaymentMethods != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">مالی</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li <?php
                        if ($role->Prices != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Prices.php">قیمت ها</a></li>
                        <li <?php
                        if ($role->Discounts != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Discounts.php">تخفیف ها</a></li>
                        <li <?php
                        if ($role->PaymentMethods != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="PaymentMethods.php">روش های پرداخت</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->Slides != 1 && $role->Thumbs != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-file-image-o"></i> <span class="nav-label">تصاویر</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li <?php
                        if ($role->Slides != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Slides.php">اسلاید ها</a></li>
                        <li <?php
                        if ($role->Thumbs != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Thumbs.php">ریزعکس ها</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->Groups != 1 && $role->SubGroups != 1 && $role->SupperGroups != 1 && $role->Brands != 1 && $role->Guarantees != 1 && $role->Colors != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">مجموعه ها</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li <?php
                        if ($role->Groups != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Groups.php">مجموعه ها</a></li>
                        <li <?php
                        if ($role->SubGroups != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="SubGroups.php">زیرمجموعه ها</a></li>
                        <li <?php
                        if ($role->SupperGroups != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="SupperGroups.php">زیر زیرمجموعه ها</a></li>
                        <li <?php
                        if ($role->Brands != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Logos.php">برند ها</a></li>
                        <li <?php
                        if ($role->Guarantees != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="GuaranteeLists.php">گارانتی ها</a></li>
                        <li <?php
                        if ($role->Colors != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="ColorLists.php">رنگ ها</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->LinkBoxes != 1 && $role->News != 1 && $role->Roles != 1 && $role->Feeds != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-star-half-o"></i> <span class="nav-label">متفرقه</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li <?php
                        if ($role->LinkBoxes != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="LinkBoxes.php">پیوند ها</a></li>
                        <li <?php
                        if ($role->News != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="News.php">اخبار</a></li>
                        <li <?php
                        if ($role->Roles != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Roles.php">نقش ها</a></li>
                        <li <?php
                        if ($role->Feeds != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Feeds.php">خبرنامه</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->Stats != 1 && $role->Stats != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="#"><i class="fa fa-area-chart"></i> <span class="nav-label">نمودار</span><span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li <?php
                        if ($role->Stats != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Financial.php">نمودار فروش</a></li>
                        <li <?php
                        if ($role->Stats != 1) {
                            echo ' style="display:none;" ';
                        } ?>><a href="Stats.php">نمودار بازدید</a></li>
                    </ul>
                </li>
                <li <?php
                if ($role->Settings != 1) {
                    echo ' style="display:none;" ';
                } ?>>
                    <a href="Settings.php"><i class="fa fa-cog"></i> <span
                                class="nav-label">تنظیمات</span></a>
                </li>
                <li class="landing_link">
                    <a href="../index.php"><i class="fa fa-home"></i> <span class="nav-label">خانه</span>
                    </a>
                </li>
                <li class="special_link">
                    <a href="Logoff.php"><i class="fa fa-power-off"></i> <span class="nav-label">خروج</span></a>
                </li>
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"
                                                                                               style="padding: 0;"></i></a>
                    <form role="search" class="navbar-form-custom" action="#">
                        <div class="form-group">
                            <input type="text" placeholder="جستجو" class="form-control"
                                   name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-left">
<!--                    <li>-->
<!--                    <span class="m-r-sm text-muted welcome-message"> به پنل کاربر --><?php //echo $settings->Owner; ?><!-- خوش آمدید </span>-->
<!--                    </li>-->


<!--                    <li class="dropdown">-->
<!--                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">-->
<!--                            <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu dropdown-messages">-->
<!--                            <li>-->
<!--                                <div class="dropdown-messages-box">-->
<!--                                    <a href="profile.html" class="pull-right">-->
<!--                                        <img alt="image" class="img-circle" src="img/a7.jpg">-->
<!--                                    </a>-->
<!--                                    <div class="media-body">-->
<!--                                        <small class="pull-left">-->
<!--                                            46 ساعت-->
<!--                                        </small>-->
<!--                                        <strong>-->
<!--                                            حمید درند-->
<!--                                        </strong>-->
<!--                                        دنبال کننده ی-->
<!--                                        <strong>-->
<!--                                            فشکالی-->
<!--                                        </strong>-->
<!--                                        است.-->
<!--                                        <br>-->
<!--                                        <small class="text-muted">-->
<!--                                            2 روز قبل ساعت 12:30 عصر-->
<!--                                        </small>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <div class="dropdown-messages-box">-->
<!--                                    <a href="profile.html" class="pull-right">-->
<!--                                        <img alt="image" class="img-circle" src="img/a4.jpg">-->
<!--                                    </a>-->
<!--                                    <div class="media-body ">-->
<!--                                        <small class="pull-left text-navy">-->
<!--                                            46 ساعت-->
<!--                                        </small>-->
<!--                                        <strong>-->
<!--                                            حمید درند-->
<!--                                        </strong>-->
<!--                                        دنبال کننده ی-->
<!--                                        <strong>-->
<!--                                            فشکالی-->
<!--                                        </strong>-->
<!--                                        است.-->
<!--                                        <br>-->
<!--                                        <small class="text-muted">-->
<!--                                            2 روز قبل ساعت 12:30 عصر-->
<!--                                        </small>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <div class="dropdown-messages-box">-->
<!--                                    <a href="profile.html" class="pull-right">-->
<!--                                        <img alt="image" class="img-circle" src="img/profile.jpg">-->
<!--                                    </a>-->
<!--                                    <div class="media-body ">-->
<!--                                        <small class="pull-left">-->
<!--                                            46 ساعت-->
<!--                                        </small>-->
<!--                                        <strong>-->
<!--                                            حمید درند-->
<!--                                        </strong>-->
<!--                                        دنبال کننده ی-->
<!--                                        <strong>-->
<!--                                            فشکالی-->
<!--                                        </strong>-->
<!--                                        است.-->
<!--                                        <br>-->
<!--                                        <small class="text-muted">-->
<!--                                            2 روز قبل ساعت 12:30 عصر-->
<!--                                        </small>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <div class="text-center link-block">-->
<!--                                    <a href="mailbox.html">-->
<!--                                        <i class="fa fa-envelope"></i> <strong>-->
<!--                                            تمامی پیغام ها را بخوانید-->
<!--                                        </strong>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                    <li class="dropdown">-->
<!--                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">-->
<!--                            <i class="fa fa-bell"></i> <span class="label label-inverse">-->
<!--                            18-->
<!--                        </span>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu dropdown-alerts">-->
<!--                            <li>-->
<!--                                <a href="mailbox.html">-->
<!--                                    <div>-->
<!--                                        <i class="fa fa-envelope fa-fw"></i>-->
<!--                                        شما 16 پیغام دارید.-->
<!---->
<!--                                        <span class="pull-left text-muted small">-->
<!--                                            4 دقیقه قبل-->
<!--                                        </span>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <a href="profile.html">-->
<!--                                    <div>-->
<!--                                        <i class="fa fa-twitter fa-fw"></i>-->
<!--                                        3 دنبال کننده-->
<!---->
<!--                                        <span class="pull-left text-muted small">-->
<!--                                            12 ساعت قبل-->
<!--                                        </span>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <a href="grid_options.html">-->
<!--                                    <div>-->
<!--                                        <i class="fa fa-upload fa-fw"></i>-->
<!--                                        سرور دوباره راه اندازی شد.-->
<!--                                        <span class="pull-left text-muted small">-->
<!--                                            4 دقیقه قبل-->
<!--                                        </span>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <div class="text-center link-block">-->
<!--                                    <a href="notifications.html">-->
<!--                                        <strong>-->
<!--                                            نمایش تمامی پیغام ها-->
<!--                                        </strong>-->
<!--                                        <i class="fa fa-angle-right"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->


                    <li>
                        <a href="Logoff.php">
                            <i class="fa fa-sign-out"></i>
                            خروج
                        </a>
                    </li>
<!--                    <li>-->
<!--                        <a class="right-sidebar-toggle">-->
<!--                            <i class="fa fa-tasks"></i>-->
<!--                        </a>-->
<!--                    </li>-->
                </ul>

            </nav>
        </div>

        <!--        <div class="row  border-bottom white-bg dashboard-header">-->
        <!---->
        <!---->
        <!---->
        <!--        </div>-->

