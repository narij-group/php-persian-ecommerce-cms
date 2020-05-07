</head>
<body class="drawer drawer--right" onload="<?php
if (isset($_SESSION[SESSION_STRING_MESSAGE]) == TRUE && (!isset($_COOKIE[COOKIE_USER_LOGGED_IN]) || $_COOKIE[COOKIE_USER_LOGGED_IN] == "NO") && (!isset($_COOKIE[COOKIE_CUSTOMER_LOGGED_IN]) || $_COOKIE[COOKIE_CUSTOMER_LOGGED_IN] == "NO")) {
    echo $_SESSION[SESSION_STRING_MESSAGE];
}
?>">
<?php
$_SESSION[SESSION_STRING_MESSAGE] = "";
?>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PurchaseBasketDataSource.inc';
$c = new PurchaseBasket();
?>

<!--Header-->
<header class="header-line">
</header>
<div class="accback" id="accback"></div>
<div class="account-box" id="accbox">
    <?php
    if ((!isset($_COOKIE [COOKIE_CUSTOMER_ID]) || $_COOKIE [COOKIE_CUSTOMER_ID] == 0) && (!isset($_COOKIE [COOKIE_USER_LOGGED_IN]) || $_COOKIE [COOKIE_USER_LOGGED_IN] == "NO")) {
        ?>
        <a href="#" id="logil2"><i class="fa fa-unlock-alt"></i>ورود</a>
        <div class="header-line"></div>
        <a href="#" id="regil2"><i class="fa fa-user-plus"></i>ثبت نام</a>
        <?php
    }

    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';

    $u2 = new UserCouponDataSource();
    $u2->open();
    $coupons = $u2->Fill();
    foreach ($coupons as $cc2) {
        if ($cc2->Time < (time() - (86400 * $settings->CouponExpire))) {
            $u2->Delete($cc2->UserCouponId);
        }
    }

    $c2 = new CustomerDataSource();
    $c2->open();
    if (isset($_COOKIE[COOKIE_USER_LOGGED_IN])) {
        $customer = new Customer();
        $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "YES";
        if ($_COOKIE[COOKIE_USER_LOGGED_IN] == "YES") {
            if (isset($_SESSION[SESSION_STRING_MESSAGE]) == TRUE) {
                unset($_SESSION[SESSION_STRING_MESSAGE]);
            }
            echo '<a href="Admin/Index.php"><i class="fa fa-user-circle"></i>ورود به پنل ادمین</a>';
            if (isset($_GET['id'])) {
                echo '<div class="header-line"></div>';
                echo '<a href="Admin/Product.php?id=' . $_GET["id"] . '"><i class="fa fa-edit"></i>ویرایش این پست</a>';
            }
            echo '<div class="header-line"></div>';
            echo '<a href="logoff.php"><i class="fa fa-power-off"></i>خروج</a>';

        }
    } else if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
        $c2->CustomerId = $_COOKIE [COOKIE_CUSTOMER_ID];
        $customer = $c2->FindOneCustomerBasedOnId($_COOKIE [COOKIE_CUSTOMER_ID]);
        $c2->close();
        echo "<a href='UserProfile.php'><i class='fa fa-user-circle'></i>";
        echo $customer->Name;
        echo " ";
        echo $customer->Family;
        echo "</a>";
        if ($u2->SomeoneCouponsSome($customer->CustomerId) != 0) {
            echo '<div class="header-line"></div>';
            echo '<a href="#"><i class="fa fa-money"></i>'
                . $u2->SomeoneCouponsSome($customer->CustomerId) . ' کپن';
        }
        echo "</a>";
        echo '<div class="header-line"></div>';
        echo "<a href='logoff.php'><i class='fa fa-power-off''></i>خروج</a>";
    } else {
        $customer = new Customer();
    }
    $u2->close();
    ?>

</div>

<div class="mob-wrapper visible-xs">
    <div class="col-xs-12" id="preloader"></div>
    <div class="col-xs-1 text-center pull-right" style="width: 10%;">
        <button class="fa fa-bars drawer-toggle"></button>
        <!--        <a href="#" class="fa fa-bars drawer-toggle"></a>-->
    </div>
    <div class="col-xs-1 text-center pull-right" style="width: 10%;">
        <a href="index.php" class="fa fa-home"></a>
    </div>
    <div class="col-xs-6 text-center pull-right" style="width: 49%;">
        <a href="index.php" class="Logo-top-mobile">
            <img src="<?php echo $settings->PLogo; ?>"/>
        </a>
    </div>
    <div class="col-xs-1 text-center pull-right" style="width: 10%;">
        <div class="cart-mob">
            <a href="Purchase.php" class="fa fa-shopping-cart cart-link-mob"></a>
            <a href="Purchase.php"><input type="button" id="total_items2" value="" class="cart-amount-mob"/></a>
        </div>
    </div>
    <div class="col-xs-1 text-center pull-right" style="width: 10%;">
        <a href="Compare.php" title="لیست مقایسه"
           class="fa fa-files-o <?php if (isset($_SESSION[SESSION_INT_PRODUCT_1]) && isset($_SESSION[SESSION_INT_PRODUCT_2]) && $_SESSION[SESSION_INT_PRODUCT_1] != 0 && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
               echo 'compare-animation-mobile';
           } ?>"></a>
    </div>
    <div class="col-xs-1 text-center pull-right" style="width: 10%;">
        <?php
        if ((!isset($_COOKIE [COOKIE_CUSTOMER_ID]) || $_COOKIE [COOKIE_CUSTOMER_ID] == 0) && (!isset($_COOKIE [COOKIE_USER_LOGGED_IN]) || $_COOKIE [COOKIE_USER_LOGGED_IN] == "NO")) {
            ?>
            <button class="fa fa-user login logout" id="usermobile"></button>
            <!--            <a href="#" class="fa fa-user login logout" id="usermobile"></a>-->
            <?php
        } else {
            echo '<button class="fa fa-user login" id="usermobile"></button>';
//            echo '<a href="#" class="fa fa-user login" id="usermobile"></a>';
        }
        ?>
    </div>
    <div class="clear-fix"></div>

</div>

<div class="mob-wrapper2 visible-xs">
    <div class="col-xs-12" style="margin-top: 10px; margin-bottom: 5px">
        <form method="GET" action="Products.php">
            <div class="input-group">
                <input type="text" class="form-control" id="search_box_mob" name="search_box_mob" placeholder="جستجو"/>
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php
    if ((!isset($_COOKIE [COOKIE_CUSTOMER_ID]) || $_COOKIE [COOKIE_CUSTOMER_ID] == 0) && (!isset($_COOKIE [COOKIE_USER_LOGGED_IN]) || $_COOKIE [COOKIE_USER_LOGGED_IN] == "NO")) {
        ?>
        <div class="col-xs-6 pull-right" style="margin-top: 10px; margin-bottom: 5px">
            <div class="register-btn2">
                <a href="#" id="regil3">ثبت نام</a>
            </div>
        </div>
        <div class="col-xs-6" style="margin-top: 10px; margin-bottom: 5px">
            <div class="login-btn2">
                <a href="#" id="logil3">ورود</a>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="clear-fix"></div>
</div>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->CFill();
$mainmenu->close();
?>

<header class="header-wrapper container-fluid hidden-xs">

    <div class="menu-header">
        <div class="row">
            <div class="col-md-2 col-sm-2 pull-right">
                <a href="index.php" class="Logo"><img src="<?php echo $settings->PLogo; ?>"/></a>
            </div>

            <div class="col-md-10 col-sm-10" style="height: 37px">
                <nav class="navigation">
                    <ul>
                        <li><a href="index.php">خانه</a></li>
                        <li><a href="Order.php">درخواست کالا</a></li>
                        <?php
                        if ((!isset($_COOKIE [COOKIE_CUSTOMER_ID]) || $_COOKIE [COOKIE_CUSTOMER_ID] == 0) && (!isset($_COOKIE [COOKIE_USER_LOGGED_IN]) || $_COOKIE [COOKIE_USER_LOGGED_IN] == "NO")) {
                            ?>
                            <li><a href="#" id="logil">ورود</a></li>
                            <li><a href="#" id="regil">ثبت نام</a></li>
                            <?php
                        }

                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
                        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserCouponDataSource.inc';

                        $u2 = new UserCouponDataSource();
                        $u2->open();
                        $coupons = $u2->Fill();
                        foreach ($coupons as $cc2) {
                            if ($cc2->Time < (time() - (86400 * $settings->CouponExpire))) {
                                $u2->Delete($cc2->UserCouponId);
                            }
                        }

                        $c2 = new CustomerDataSource();
                        $c2->open();
                        if (isset($_COOKIE[COOKIE_USER_LOGGED_IN])) {
                            $customer = new Customer();
                            $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "YES";
                            if ($_COOKIE[COOKIE_USER_LOGGED_IN] == "YES") {
                                if (isset($_SESSION[SESSION_STRING_MESSAGE]) == TRUE) {
                                    unset($_SESSION[SESSION_STRING_MESSAGE]);
                                }
                                echo "<div class='Profile-Details'>";
                                echo "<div class='welcome-box'>";
                                echo " درود ! ";
                                echo "</div>";
                                echo "</div>";
                                echo '<li><a class="account" href="Admin/Index.php">ورود به پنل ادمین</a></li>';
                                if (isset($_GET['id'])) {
                                    echo "<li><a class='account' target='blank' href='Admin/Product.php?id=" . $_GET['id'] . "'>ویرایش این پست</a></li>";
                                }
                                echo '<li><a class="logoff" href="logoff.php">خروج</a></li>';

                            }
                        } else if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {

                            echo "<div class='Profile-Details'>";
                            $c2->CustomerId = $_COOKIE [COOKIE_CUSTOMER_ID];
                            $customer = $c2->FindOneCustomerBasedOnId($_COOKIE [COOKIE_CUSTOMER_ID]);
                            $c2->close();
                            echo "<div class='welcome-box'>";
                            echo "سلام ، ";
                            echo "<a class='name'>";
                            echo $customer->Name;
                            echo " ";
                            echo $customer->Family;
                            echo "</a>";
                            echo " خوش آمدید   ! ";
                            echo "</div>";
                            if ($u2->SomeoneCouponsSome($customer->CustomerId) != 0) {
                                echo '<li><a class="coupon" href="#">';
                                echo $u2->SomeoneCouponsSome($customer->CustomerId) . ' کپن';
                            }
                            echo "</a></li>";
                            echo "</div>";
                            echo '<li><a class="account" href="UserProfile.php">حساب کاربری</a></li>';
                            echo '<li><a class="logoff" href="logoff.php">خروج</a></li>';
                        } else {
                            $customer = new Customer();
                        }

                        $u2->close();
                        ?>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row" style="margin-bottom: 0">
            <div class="col-md-3 cart-box">
                <a href="Purchase.php" title="">
                    <div class="shopping-cart">
                        <span class="fa fa-shopping-cart logo"></span>
                        <span class="title">
                        سبد خرید
                    </span>
                        <input type="button" id="total_items" value="0" class="amount"/>
                    </div>
                </a>

                <a href="Compare.php" title="">
                    <div id="compare-box"
                         class="compare-box  <?php if (isset($_SESSION[SESSION_INT_PRODUCT_1]) && isset($_SESSION[SESSION_INT_PRODUCT_2]) && $_SESSION[SESSION_INT_PRODUCT_1] != 0 && $_SESSION[SESSION_INT_PRODUCT_2] != 0) {
                             echo 'compare-animation';
                         } ?>">
                        <span class="fa fa-list-ol logo"></span>
                        <span class="title">
                        لیست مقایسه
                    </span>
                    </div>
                </a>
            </div>

            <div class="col-md-7">
                <div class="search-box col-md-12">
                    <form method="GET" action="Products.php">
                        <div class="input-group">

                            <input type="text" class="text-control" id="search_box" name="search_box"
                                   placeholder="محصول مورد نظرتان را جستجو کنید ..." autocomplete="off">
                            <div id="searchres" class="searchres"></div>
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-2">
            </div>

        </div>
    </div>

    <div class="nav-wraper hidden-xs" id="menus">
        <nav class="navigation" style="position: relative;">
            <img src="Admin/Template/Images/gifs/loading.gif" width="30px" height="30px"
                 style="position: absolute; right: 0; top: 8px;"/>
            <ul class="root" id="menu">
                <?php
                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
                $sbmds = new SubMenuDataSource();
                $sbmds->open();

                foreach ($mainmenus as $mm) {
                    if ($sbmds->ExistSubMenuForMainMenu($mm->MainMenuId) == true) {
                        ?>
                        <li>
                            <a href="#"><span class="fa fa-chevron-down"></span><?php echo $mm->Group->Name; ?></a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li>
                            <a href="#"><?php echo $mm->Group->Name; ?></a>
                        </li>
                        <?php
                    }
                }

                $sbmds->close();
                ?>
            </ul>

            <?php
            if ($settings->MenuCustomButtonName != "") {
                ?>
                <a href="<?php echo $settings->MenuCustomButtonLink; ?>" class="m-custom-btn">
                    <img src="<?php echo $settings->MenuCustomButtonImage; ?>">
                    <span>
        <?php
        echo $settings->MenuCustomButtonName;
        ?>
            </span>
                </a>
                <?php
            }
            ?>
        </nav>
    </div>

</header>

<div class="modalback" id="modalback"></div>
<div class="register-alert" id="regi2">
    <div class="alert">
        <?php
        if (isset($_SESSION[SESSION_STRING_REGISTER_ERROR])) {
            echo $_SESSION[SESSION_STRING_REGISTER_ERROR];
        }
        if (isset($_SESSION[SESSION_STRING_REGISTER_ERROR_2])) {
            echo '</br>';
            echo $_SESSION[SESSION_STRING_REGISTER_ERROR_2];
        }
        ?>
    </div>
</div>
<div class="container">
    <div class="Login" id="logi">
        <span class="Title">ورود به حساب</span>
        <form action="CheckLogin.php" method="post">
            <input type="hidden"
                   value="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"
                   name="link" id="link"/>
            <table>
                <tr>
                    <td><input type="text" id="username" name="username" placeholder="Email"/></td>
                </tr>
                <tr>
                    <td><input type="password" id="password" name="password" placeholder="Password"/></td>
                </tr>
            </table>
            <div style="position:relative; text-align: center;">
                <input type="submit" id="loginbutton" value="ورود"/>
                <img class="modal-loader" id="loginloader" src="Admin/Template/Images/gifs/loading.gif"/>
            </div>
        </form>
        <div class="Forget-Pass"><a href="#" id="forget-pass">رمز عبور را فراموش کردم</a></div>
        <div class="Register-Link"><a href="#" id="register-btn5">ثبت نام</a></div>
    </div>
</div>

<div class="error-message" id="error-msg">نام کاربری یا رمزعبور اشتباه است!</div>
<div class="success-message" id="feed-success-msg">شما با موفقیت به لیست خبرنامه اضافه شدید!</div>
<div class="error-message" id="error-msg1">رمز عبور با تکرار رمز عبور برابر نیست !</div>
<div class="error-message" id="error-msg2">پست الکترونیک شما قبلا ثبت شده است!</div>
<div class="error-message" id="error-msg8">این نام کاربری قبلا ثبت شده است!</div>
<div class="error-message" id="recovery-error-msg">رمزعبور با تکرارش برابر نیست!</div>
<div class="error-message" id="recovery-error-msg2">فرصت استفاده از این لینک تمام شده است!</div>
<div class="success-message" id="recovery-success-msg2">رمزعبور شما با موفقیت تغییر کرد!</div>
<div class="success-message" id="rsuccess-msg">ثبت نام با موفقیت انجام شد!</div>
<div class="success-message" id="recovery-success-msg">ایمیل بازگردانی با موفقیت برای شما ارسال شد!</div>
<div class="success-message" id="contact-success-msg">ایمیل شما با موفقیت ارسال شد!</div>
<div id="rpass"></div>
<div class="Login" id="fpass">
    <span class="Title">بازگردانی رمزعبور</span>

    <input type="hidden"
           value="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"
           name="link" id="link"/>
    <table>
        <tr>
            <td><input type="text" id="email2" style="padding-left: 15px; padding-right: 0;"
                       name="email2" placeholder="آدرس ایمیل خود را وارد کنید..."/></td>
        </tr>
    </table>

    <div style="position:relative; text-align: center;">
        <input type="submit" id="btn-forgetpass" value="ثبت"/>
        <img class="modal-loader" id="fpassloader" src="Admin/Template/Images/gifs/loading.gif"/>
    </div>
</div>

<div class="Login" id="fpass2">
    <form id="recoverypass-form">
        <input type="hidden" name="key" id="key" value="<?php echo $_GET['key']; ?>"/>
        <span class="Title">بازگردانی رمزعبور</span>
        <table>
            <tr>
                <td><input type="password" title="حداقل 8 رقم" minlength="8" id="newpass"
                           style="direction: rtl; padding-left: 0; padding-right: 15px;"
                           name="newpass" placeholder="رمزعبور جدید خود را وارد کنید..."/></td>
            </tr>
            <tr>
                <td>
                    <div class="status" id="pw-status"></div>
                    <input type="password" id="newpassrepeat"
                           style="direction: rtl; padding-left: 0; padding-right: 15px;"
                           name="newpassrepeat" placeholder="تکرار رمزعبور..."/></td>
            </tr>
        </table>
    </form>
    <div style="position:relative; text-align: center;">
        <input type="submit" id="btn-forgetpass2" disabled value="تغییر رمزعبور"/>
        <img class="modal-loader" id="fpass2loader" src="Admin/Template/Images/gifs/loading.gif"/>
    </div>
</div>


<!--
    <div class = "success-message" id = "rsuccess-msg2">نظر شما با موفقیت افزوده شد، منتظر تایید سایت باشید.</div>
    <div class = "success-message" id = "rsuccess-msg3">پرسش یا پاسخ شما با موفقیت افزوده شد، منتظر تایید سایت باشید.</div>
    <div class = "error-message" id = "error-msg3">شما قبلا برای این محصول نظر داده اید.</div>-->


<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

$emptyCustomer = new Customer();
?>

<div class="Register" id="regi">
    <span class="Title">حساب خود را بسازید</span>
    <?php
    $cm = "add";

    $dis = "";
    $css = "";
    if ($emptyCustomer == $customer) {


    ?>

    <!--<form action="Internal Inserting/InsertCustomer.php" method="post">-->
    <form id="ks-register-form" action="InsertCustomer.php" method="post">

        <p id="ks-report"></p>
        <input type="hidden"
               value="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"
               name="link" id="link"/>
        <table>
            <tr>
                <td>
                    <input class="double-input margin-left" placeholder="نام" id="name" name="name"
                           value="<?php echo $customer->Name; ?>"/>
                    <input class="double-input" placeholder="نام خانوادگی" type="text"
                           value="<?php echo $customer->Family; ?>" id="family" name="family"/><br/></td>
            </tr>
            <tr>
                <td>
                    <div class="status" id="email-status"></div>
                    <input class="single-input2" placeholder="ایمیل" required id="email"
                           name="email" <?php echo $dis; ?>
                        <?php echo $css; ?>
                           value="<?php echo $customer->Email; ?>"/><br/></td>
            </tr>
            <tr>
                <td><input class="double-input margin-left" minlength="8" placeholder="رمز عبور" required
                           id="password"
                           name="password"
                           value="<?php echo $customer->Password; ?>" minlength="8" type="password"/>


                    <input required class="double-input" placeholder="تکرار رمز عبور"
                           value="<?php echo $customer->Password; ?>" type="password" id="repeatpass"
                           name="repeatpass"/>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="status" id="ncode-status"></div>
                    <input class="single-input2" required placeholder="کد ملی" maxlength="10" minlength="10"
                           type="text" id="nationalitycode"
                           value="<?php echo $customer->NationalityCode; ?>" name="nationalitycode"/><br/></td>
            </tr>
        </table>
        <?php
        } else {

        $dis = "readonly";
        $css = "style= 'background-color : #bbb'";

        ?>
        <form id="ks-edit-form" action="Internal Inserting/UpdateCustomer.php" method="post">

            <p id="ks-report"></p>
            <input type="hidden"
                   value="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"
                   name="link" id="link"/>
            <input type="hidden" id="id" name="id" value="<?php echo $_COOKIE[COOKIE_CUSTOMER_ID]; ?>"/>
            <input type="hidden" id="username2"
                   name="username" <?php echo $dis; ?>
                <?php echo $css; ?>
                   value="<?php echo $customer->Username; ?>"/>
            <table>
                <tr>
                    <td>
                        <input class="double-input margin-left" placeholder="نام" id="name" name="name"
                               value="<?php echo $customer->Name; ?>"/>
                        <input class="double-input" placeholder="نام خانوادگی" type="text"
                               value="<?php echo $customer->Family; ?>" id="family" name="family"/><br/></td>
                </tr>
                <tr>
                    <td>
                        <div class="status" id="email-status"></div>
                        <input class="single-input2" placeholder="ایمیل" required id="email"
                               name="email" <?php echo $dis; ?>
                            <?php echo $css; ?>
                               value="<?php echo $customer->Email; ?>"/><br/></td>
                </tr>
                <tr>
                    <td><input class="double-input margin-left" minlength="8" placeholder="رمز عبور" required
                               id="password"
                               name="password"
                               value="<?php echo $customer->Password; ?>" minlength="8" type="password"/>


                        <input required class="double-input" placeholder="تکرار رمز عبور"
                               value="<?php echo $customer->Password; ?>" type="password" id="repeatpass"
                               name="repeatpass"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="status" id="ncode-status"></div>
                        <input class="single-input2" required placeholder="کد ملی" maxlength="10" minlength="10"
                               type="text" id="nationalitycode"
                               value="<?php echo $customer->NationalityCode; ?>" name="nationalitycode"/><br/></td>
                </tr>
                <tr>
                    <td><input class="double-input margin-left" maxlength="11" placeholder="شماره موبایل" required
                               type="text"
                               id="mobile"
                               name="mobile" value="<?php echo $customer->Mobile; ?>"/>
                        <input class="double-input" placeholder="تلفن ثابت" maxlength="14" type="text" required
                               id="phone" name="phone"
                               value="<?php echo $customer->Phone; ?>"/><br/></td>
                </tr>
                <?php
                if ($customer->NationalityCode == 0) {
                    ?>
                    <tr>
                        <td><span class="optional">اختیاری</span> <img class="optional-arrow"
                                                                       src="Template/Images/Plugins/caret-bottom2.png"/>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><select class="double-input margin-left16px" id="estate" name="estate">
                            <option value="0">انتخاب استان...</option>
                            <?php
                            require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProvinceDataSource.inc';
                            $province = new ProvinceDataSource();
                            $province->open();
                            $provinces = $province->Fill();
                            $province->close();
                            foreach ($provinces as $pr) {
                                echo "<option value='$pr->ProvinceId' ";
                                if ($customer->Estate == $pr->ProvinceId) {
                                    echo ' selected ';
                                }
                                echo ">";
                                echo $pr->Name;
                                echo '</option>';
                            }

                            ?>
                        </select>
                        <select class="double-input" id="city" name="city">
                            <option value="0">انتخاب شهر...</option>
                            <?php
                            require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';
                            $city = new CityDataSource();
                            $city->open();
                            if (isset($customer->Estate) && trim($customer->Estate) != "") {
                                $cities = $city->GetOneProvinceCities($customer->Estate);
                            } else {
                                $cities = $city->GetOneProvinceCities(1);
                            }
                            if ($customer->Estate != 0) {
                                foreach ($cities as $ct) {
                                    echo "<option value='$ct->CityId'";
                                    if ($customer->City == $ct->CityId) {
                                        echo ' selected ';
                                    }
                                    echo ">";
                                    echo $ct->Name;
                                    echo '</option>';
                                }
                            }
                            $city->close();
                            ?>
                        </select><br/></td>
                </tr>
                <tr>
                    <td><input class="single-input" placeholder="کد پستی" type="text" id="postcode" name="postcode"
                               value="<?php echo $customer->PostCode; ?>"/><br/></td>
                </tr>
                <tr>
                    <td><input class="single-input" placeholder="آدرس" type="text" id="address" name="address"
                               value="<?php echo $customer->Address; ?>"/><br/></td>
                </tr>

            </table>
            <?php
            }
            ?>
            <?php
            if ($emptyCustomer == $customer) {
                ?>
                <div style="position:relative; text-align: center;">
                    <input type="submit" id="register-button" value="ساخت حساب"/>
                    <img class="modal-loader" id="registerloader" src="Admin/Template/Images/gifs/loading.gif"/>
                </div>
                <?php
            } else {
                ?>
                <div style="position:relative; text-align: center;">
                    <input type="submit" id="editregisterbutton" value="ویرایش اطلاعات"/>
                    <img class="modal-loader" id="editregisterloader" src="Admin/Template/Images/gifs/loading.gif"/>
                </div>
                <?php
            }
            ?>

            <!--<input type="submit" value="ویرایش اطلاعات"/>-->


        </form>
</div>

<!--Sina-->
<div id="darklayer" hidden
     style="z-index:50; margin-bottom: 10px;  background-color:rgba(0,0,0,0.4); position:fixed;top:0; left:0; right:0; bottom:0;height: 100%;">


</div>


<div class="Sidebar" id="div">

    <div class="logo" id="logo">
        <a href="../index.php"> </a>
    </div>

    <div id="nav">
        <ul>
            <!--            <li id="Category1_P">-->
            <!--                <h4 id="Category1">Category 1-->
            <!--                    <svg></svg>-->
            <!--                </h4>-->
            <!--                <ul>-->
            <!--                    <li><a id="1" href="#">Option 1</a></li>-->
            <!--                    <li><a id="1" href="#">Option 2</a></li>-->
            <!--                    <li><a id="1" href="#">Option 3</a></li>-->
            <!--                    <li><a id="1" href="#">Option 4</a></li>-->
            <!--                    <li><a id="1" href="#">Option 5</a></li>-->
            <!--                    <li><a id="1" href="#">Option 6</a></li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <?php
            $i = 1;
            //            if ($detect->isMobile() && !$detect->isTablet()) {
            require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
            $submenu = new SubMenuDataSource();
            $submenu->open();
            foreach ($mainmenus as $mm) {
                ?>
                <li id="Category<?php echo $i; ?>_P">
                    <h4 id="Category<?php echo $i; ?>"><?php echo $mm->Group->Name; ?>
                        <svg></svg>
                    </h4>
                    <ul>
                        <?php
                        //                        $submenu->MainMenu = $mm->MainMenuId;
                        $submenus = $submenu->getOneMainMenuSubMenus($mm->MainMenuId);
                        foreach ($submenus as $sm) {
                            ?>
                            <li>
                                <a href="Products.php?sbgroup=<?php echo $sm->SubGroup->SubGroupId; ?>"><?php echo $sm->SubGroup->Name; ?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
                $i++;
            }
            //    }
            ?>
        </ul>

    </div>

</div>


<div class="Topbar">
    <a id="navtoggle" href="javascript:void(0);">&#9776</a>

</div>


<nav class="drawer-nav" role="navigation">
    <div class="top">
        <a href="index.php" class="Logo">
            <img src="<?php echo $settings->PLogo; ?>"/>
        </a>
        <a href="#" class="drawer-toggle" title=""></a>
    </div>
    <div class="userpro">
        <div class="Name">
            <div class="Username">
                <?php
                if ((!isset($_COOKIE [COOKIE_CUSTOMER_ID]) || $_COOKIE [COOKIE_CUSTOMER_ID] == 0) && (!isset($_COOKIE [COOKIE_USER_LOGGED_IN]) || $_COOKIE [COOKIE_USER_LOGGED_IN] == "NO")) {
                    ?>
                    کاربر مهمان
                    <?php
                } else if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE [COOKIE_CUSTOMER_ID] != 0) {
                    echo $customer->Name;
                    echo " ";
                    echo $customer->Family;
                } else {
                    echo "ادمین";
                }
                ?>
            </div>
            <div class="Wel">خوش آمدید</div>
        </div>
        <div class="Photo"><img src="Template/Images/user-profile.png"></div>
    </div>
    <div class="clearfix"></div>
    </div>
    <div class="menu" id="outer-wrap">
        <?php
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';
        $submenu = new SubMenuDataSource();
        $submenu->open();
        $suppermenu = new SupperMenuDataSource();
        $suppermenu->open();
        $menutitle = new MenuTitleDataSource();
        $menutitle->open();

        ?>
        <nav class="mainNav" id="mainNav">
            <ul>
                <?php
                foreach ($mainmenus as $mm) {
                    //                        $submenu->MainMenu = $mm->MainMenuId;
                    $submenus = $submenu->getOneMainMenuSubMenus($mm->MainMenuId);
                    if (count($submenus) == 0) {
                        ?>
                        <li>
                            <a href="#"><?php echo $mm->Group->Name; ?></a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li>
                            <a href="#"><?php echo $mm->Group->Name; ?></a>
                            <ul class="submenu">
                                <?php
                                foreach ($submenus as $sm) {
                                    ?>
                                    <li><a href="#">
                                            <?php echo $sm->SubGroup->Name; ?>
                                        </a>
                                        <?php

                                        $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
                                        $menutitles = $menutitle->getOneSubMenuTitles($sm->SubMenuId);
                                        $suppermenu2 = new SupperMenuDataSource();
                                        $suppermenu2->open();
                                        foreach ($menutitles as $mt) {

//                                            $supmnus = $suppermenu2->getSupperMenusOfThisTitleC1($mt->MenuTitleId);
                                            $supmnus = $suppermenu2->getOneSubMenuSupperMenus($sm->SubMenuId);
                                            if ($supmnus != null) {
                                                ?>

                                                <ul class="submenu">
                                                    <?php
                                                    foreach ($supmnus as $spm) {
//                                                        $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
//                                                        $menutitles = $menutitle->getOneSubMenuTitlesC1($sm->SubMenuId);
//                                                        foreach ($menutitles as $mt) {
//                                                            $supmnus = $suppermenu2->getSupperMenusOfThisTitleC1($mt->MenuTitleId);
                                                            ?>
                                                            <li>
                                                                <a href="Products.php?spgroup=<?php echo $spm->SupperGroup->SupperGroupId; ?>"><?php echo $spm->SupperGroup->Name; ?></a>
                                                            </li>
                                                            <?php
//                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>

                        <?php
                    }
                }
                ?>
            </ul>


            <!--            <ul>-->
            <!---->
            <!--                --><?php
            //                foreach ($mainmenus as $mm) {
            //                    //                        $submenu->MainMenu = $mm->MainMenuId;
            //                    $submenus = $submenu->getOneMainMenuSubMenus($mm->MainMenuId);
            //                    if (count($submenus) == 0) {
            //                        ?>
            <!--                        <li>-->
            <!--                            <a href="#">--><?php //echo $mm->Group->Name; ?><!--</a>-->
            <!--                        </li>-->
            <!--                        --><?php
            //                    } else {
            //                        ?>
            <!--                        <li>-->
            <!--                            <a href="#">--><?php //echo $mm->Group->Name; ?><!--</a>-->
            <!--                            <ul>-->
            <!--                                --><?php
            //                                foreach ($submenus as $sm) {
            //                                    ?>
            <!--                                    <li><a href="Products.php?sbgroup=-->
            <?php //echo $sm->SubGroup->SubGroupId; ?><!--">-->
            <!--                                            --><?php //echo $sm->SubGroup->Name; ?>
            <!--                                        </a>-->
            <!--                                        --><?php
            //
            //                                        $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
            //                                        $menutitles = $menutitle->getOneSubMenuTitles($sm->SubMenuId);
            //                                        $suppermenu2 = new SupperMenuDataSource();
            //                                        $suppermenu2->open();
            //                                        foreach ($menutitles as $mt) {
            //
            //                                            $supmnus = $suppermenu2->getSupperMenusOfThisTitleC1($mt->MenuTitleId);
            //                                            if ($supmnus != null) {
            //                                                ?>
            <!---->
            <!--                                                <ul>-->
            <!--                                                    --><?php
            //                                                    foreach ($supmnus as $spm) {
            //                                                        $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
            //                                                        $menutitles = $menutitle->getOneSubMenuTitlesC1($sm->SubMenuId);
            //                                                        foreach ($menutitles as $mt) {
            //                                                            $supmnus = $suppermenu2->getSupperMenusOfThisTitleC1($mt->MenuTitleId);
            //                                                            ?>
            <!--                                                            <li>-->
            <!--                                                                <a href="Products.php?spgroup=-->
            <?php //echo $spm->SupperGroup->SupperGroupId; ?><!--">-->
            <?php //echo $spm->SupperGroup->Name; ?><!--</a>-->
            <!--                                                            </li>-->
            <!--                                                            --><?php
            //                                                        }
            //                                                    }
            //                                                    ?>
            <!--                                                </ul>-->
            <!--                                                --><?php
            //                                            }
            //                                        }
            //                                        ?>
            <!--                                    </li>-->
            <!--                                --><?php //} ?>
            <!--                            </ul>-->
            <!--                        </li>-->
            <!---->
            <!--                        --><?php
            //                    }
            //                }
            //                ?>
            <!--            </ul>-->
        </nav>
    </div>
</nav>


<div class="visible-xs">
    <div id="Go-Up" class="fa fa-arrow-up" title="رفتن به بالا"></div>
</div>
<footer class="navbar-default navbar-fixed-bottom visible-xs">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-3 text-center"><a href="Products.php"><i class="fa fa-product-hunt"></i><br>محصولات</a>
            </div>
            <div class="col-xs-3 text-center"><a href="Purchase.php"><i
                            class="fa fa-shopping-basket"></i><br>سبد خرید</a></div>
            <div class="col-xs-3 text-center"><a href="UserProfile.php"><i class="fa fa-user"></i><br>حساب
                    کاربری</a></div>
            <div class="col-xs-3 text-center"><a href="index.php"><i class="fa fa-home"></i><br>صفحه
                    اصلی</a></div>
        </div>
    </div>
</footer>

<div class="horizontal-line"></div>