<!--Footer-->
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkBoxDataSource.inc';

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

$stds = new StatDataSource();
$stds->open();

$stat = new Stat();

$path2 = explode('/', $_SERVER['REQUEST_URI']);
$path = end($path2);


$stat->Page = $path;
$stat->UserIP = $stds->get_client_ip();


//echo $stat->get_client_ip()  . "<br>";


$ip = $stds->get_client_ip();
if (!isset($_COOKIE[COOKIE_VIEWER_LAST_IP])) {
//    ob_start();
    setcookie(COOKIE_VIEWER_LAST_IP, $ip, time() + (10 * 365 * 24 * 60 * 60));

    ob_end_flush();
}

if ($stat->UserIP != $_COOKIE[COOKIE_VIEWER_LAST_IP]) {
    $stds->UpdateFreshIP($_COOKIE[COOKIE_VIEWER_LAST_IP], $stat->UserIP);
    setcookie(COOKIE_VIEWER_LAST_IP, $stat->UserIP, time() + (10 * 365 * 24 * 60 * 60));
}

$stats = $stds->isVisited($stat);


if (isset($_COOKIE [COOKIE_CUSTOMER_ID]) && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {

    $cds = new CustomerDataSource();
    $cds->open();

    $customerforip = new Customer();
    $customerforip->CustomerId = $_COOKIE[COOKIE_CUSTOMER_ID];
    $customerforip->IP = $cds->get_client_ip();
    $cds->UpdateIP($customerforip);

    $cds->close();
}


if ($stats == NULL) {
    $stat->Page = $path;
    if (!isset($_GET['id'])) {
        $stat->Product = 0;
    } else {
        $stat->Product = $_GET['id'];
    }
    $stat->UserIP = $stds->get_client_ip();
    $stat->Visit = 1;
    $stds->Insert($stat);
}
?>
<script>
    $(document).ready(function () {
        function validateEmail(email) {
            var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
            return re.test(email);
        }

        $.ajax({
            type: 'POST',
            url: 'Template/AjaxMenuLoading.php',
            success: function (res) {
                $('#menus').html(res);
            }
        });
        $('#insert-feed').click(function () {
            if (validateEmail($('#feed-email').val()) == true) {
                $('#feed-loader').fadeIn(0);
                $.ajax({
                    type: 'POST',
                    url: 'Internal Inserting/InsertFeed.php',
                    data: {
                        email: $('#feed-email').val()
                    },
                    success: function () {
                        $('#feed-success-msg').fadeIn(200);
                        $('#feed-loader').fadeOut(100);
                        setTimeout(function () {
                            $('#feed-success-msg').fadeOut(500);
                        }, 5000);
                    }
                });
            } else {
                alert("لطفا آدرس ایمیل را درست وارد نمایید!");
            }

        });
    });

</script>


<div class="footer">
    <div class="footer-wrapper1">
        <div class="text col-md-6">
            <span class="font fa fa-envelope-o"></span>
            <span class="title">از آخرین تخفیف ها و اطلاعیه ها در ایمیلتان با خبر شوید</span>
        </div>
        <div class="communications col-md-6">
            <div class="form">
                <div class="input-group">
                    <button type="submit" class="btn btn-default btn-circle" id="insert-feed"><i>ثبت</i></button>
                    <input type="text" class="text-control" name="feed-email" id="feed-email"
                           placeholder="ایمیل خود را وارد کنید"/>
                </div>
            </div>
        </div>
        <div class="clear-fix"></div>
    </div>

    <?php
    if (trim($settings->ENamadLink) != "") {
        ?>
        <div class="footer-namad visible-xs">
            <div class="col-xs-12 namad">
                <?php echo $settings->ENamadLink; ?>
            </div>
            <div class="clear-fix"></div>
        </div>
        <?php
    }
    ?>

    <div class="footer-mob-wrapper visible-xs">
        <div class="tel col-xs-6"><span class="tel-num"><?php echo $settings->Numbers; ?></span><span
                    class="font fa fa-phone"></span>
        </div>
        <div class="email col-xs-6"><span
                    class="email-ads"><?php echo $settings->Email; ?></span><span class="font fa fa-envelope"></span>
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="footer-wrapper2 hidden-xs">
        <div class="col-md-4 pull-right">
            <div class="logo"><img src="<?php echo $settings->PLogo; ?>"/></div>
            <div class="history">
                <?php echo $settings->AboutSite; ?>
            </div>
            <div class="tel col-md-5"><span class="tel-num"><?php echo $settings->Numbers; ?></span><span
                        class="font fa fa-phone"></span>
            </div>
            <div class="line col-md-2 visible-lg"><span class="font">|</span></div>
            <div class="email col-md-5"><span
                        class="email-ads"><?php echo $settings->Email; ?></span><span
                        class="font fa fa-envelope"></span></div>
        </div>

        <div class="col-md-8">
            <div class="FooterMainTitle">
                <?php
                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LinkboxTitleDataSource.inc';

                $linkboxtitle = new LinkboxTitleDataSource();
                $linkboxtitle->open();
                $linkboxtitles = $linkboxtitle->Fill();
                $linkboxtitle->close();
                $i = 1;
                foreach ($linkboxtitles as $lbt) {
                    if ($i <= 4) {

                        if (($i % 2) == 1) {
                            echo '<div class="col-md-6 pull-right">';
                            echo '<div class="row">';
                        }

                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pull-right">
                            <div class="FooterSubTitle">
                                <?php echo $lbt->Name; ?>

                                <div class="FooterMainContent">
                                    <div class="FooterSubContent">
                                        <ul>
                                            <?php
                                            $linkbox = new LinkBoxDataSource();
                                            $linkbox->open();
                                            $linkboxes = $linkbox->GetOneTitleLinks($lbt->LinkboxTitleId);
                                            $linkbox->close();
                                            foreach ($linkboxes as $lb) {
                                                echo "<li><a href='";
                                                if (trim($lb->Link) == "") {
                                                    echo "textpost.php?fid=$lb->LinkBoxId";
                                                } else {
                                                    echo $lb->Link;
                                                }
                                                echo "'><span class=\"fa fa-caret-left\"></span>";
                                                echo $lb->Name;
                                                echo '</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php
                        if (($i % 2) == 0) {
                            echo '</div>';
                            echo '</div>';
                        }
                        $i++;
                    }
                }
                ?>
            </div>
        </div>
        <div class="clear-fix"></div>
    </div>

    <div class="footer-wrapper3">
        <div class="social col-md-6">
            <a href="<?php echo $settings->Facebook; ?>" id="unPreload" title="Facebook"><span
                        class="fa fa-facebook"></span></a>
            <a href="<?php echo $settings->Twitter; ?>" id="unPreload" title="Twitter"><span
                        class="fa fa-twitter"></span></a>
            <a href="<?php echo $settings->Instagram; ?>" id="unPreload" title="Instagram"><span
                        class="fa fa-instagram"></span></a>
            <a href="<?php echo $settings->Telegram; ?>" id="unPreload" title="Telegram"><span
                        class="fa fa-telegram"></span></a>
        </div>
        <div class="copy-right col-md-6">
            <span class="col-md-6 fa">کلیه حقوق این سایت نزد صاحب آن محفوظ است</span>
            <!--            <span class="font">|</span>-->
            <span class="en col-md-6"><?php
                if ($settings->CreationDate == date('Y')) {
                    ?>
                    Copyright © <?php echo date('Y'); ?> <a href="#"></a>
                    <?php
                } else {
                    ?>
                    Copyright © <?php echo $settings->CreationDate . ' - ' . date('Y'); ?> <a href="#"></a>
                    <?php
                }
                ?></span>
        </div>
        <div class="clear-fix"></div>
        <div class="row Pad visible-xs"></div>
    </div>

    <div class="hidden-xs">
        <div id="Go-Up2" class="fa fa-arrow-up" title="رفتن به بالا"></div>
    </div>
</div>


<script src="Template/Scripts/owl.carousel.min.js"></script>
<script src="Template/Scripts/HoverIntent.min.js"></script>
<script src="Template/Scripts/scrolltofixed.min.js"></script>
<!--<script src="Template/Scripts/navAccordion.js"></script>-->

<script type="text/javascript">
    // get header height (without border)
    var getHeaderHeight = $('.header-wrapper').outerHeight();

    // border height value (make sure to be the same as in your css)
    var borderAmount = 2;

    // shadow radius number (make sure to be the same as in your css)
    var shadowAmount = 20;

    // init variable for last scroll position
    var lastScrollPosition = 0;

    // set negative top position to create the animated header effect
    $('.header-wrapper').css('top', '-' + (getHeaderHeight + shadowAmount + borderAmount) + 'px');

    $(window).scroll(function () {
        getHeaderHeight = -21;
        var currentScrollPosition = $(window).scrollTop();

        if ($(window).scrollTop() > 2 * (getHeaderHeight + shadowAmount + borderAmount)) {
            $('body').addClass('scrollActive').css('padding-top', getHeaderHeight);
            $('.header-wrapper').css('top', 0);

            if (currentScrollPosition < lastScrollPosition) {
                $('.header-wrapper').css('top', '-' + (getHeaderHeight + shadowAmount + borderAmount) + 'px');
            }
            lastScrollPosition = currentScrollPosition;

        } else {
            $('body').removeClass('scrollActive').css('padding-top', 0);
        }
    });
</script>

<script type="text/javascript">
    // get header height (without border)
    var getHeaderHeight = $('.mob-wrapper').outerHeight();

    // border height value (make sure to be the same as in your css)
    var borderAmount = 2;

    // shadow radius number (make sure to be the same as in your css)
    var shadowAmount = 20;

    // init variable for last scroll position
    var lastScrollPosition = 0;

    // set negative top position to create the animated header effect
    $('.mob-wrapper').css('top', '-' + (getHeaderHeight + shadowAmount + borderAmount) + 'px');

    $(window).scroll(function () {
        var currentScrollPosition = $(window).scrollTop();

        if ($(window).scrollTop() > 2 * (getHeaderHeight + shadowAmount + borderAmount)) {

            $('body').addClass('scrollActive2').css('padding-top', getHeaderHeight);
            $('.mob-wrapper').css('top', 0);

            if (currentScrollPosition < lastScrollPosition) {
                $('.mob-wrapper').css('top', '-' + (getHeaderHeight + shadowAmount + borderAmount) + 'px');
            }
            lastScrollPosition = currentScrollPosition;

        } else {
            $('body').removeClass('scrollActive2').css('padding-top', 0);
        }
    });
</script>

<script>
    document.getElementById('preloader').style.display = "none";
    // Navigation
    $(document).ready(function () {
        // Scroll To Fixed Tab
        $('.tab-header-wrapper').scrollToFixed();
        jQuery('.tabs .tab-header-wrapper ul li a').on('click', function (e) {
            var currentAttrValue = jQuery(this).attr('href');
            jQuery('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();
            jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
        });

        // Jump To Special Anchor
        $(function () {
            $('a[href*=#]:not([href=#])').click(function () {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top - 150
                        }, 400);
                        return false;
                    }
                }
                return false;
            });
        });


    });
</script>

<script>
    $(document).ready(function () {
        var latestGoods = $("#latest-goods");
        var bestSellingGoods = $("#best-selling-goods");
        var mostPopularGoods = $("#most-popular-goods");
        var protocolGoods = $("#protocol-goods");
        var hotGoods1 = $("#hot-goods1");
        var hotGoods2 = $("#hot-goods2");
        var hotGoods3 = $("#hot-goods3");
        var hotGoods4 = $("#hot-goods4");
        var hotGoods5 = $("#hot-goods5");
        var randomGoods = $("#random-goods");
        var latestproducts = $("#latest-products");

        latestGoods.owlCarousel({
            items: 3,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                //"<i class='icon-chevron-left icon-white'><</i>",
                //"<i class='icon-chevron-right icon-white'>></i>"
                "<i class='fa fa-chevron-left' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        bestSellingGoods.owlCarousel({
            items: 3,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            rtl: true,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        mostPopularGoods.owlCarousel({
            items: 3,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            rtl: true,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        protocolGoods.owlCarousel({
            rtl: true,
            items: 3,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: true,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: true,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        hotGoods1.owlCarousel({
            items: 5,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 3.2],
            itemsTabletSmall: false,
            itemsMobile: [479, 2.2],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left hidden-xs' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right hidden-xs'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        hotGoods2.owlCarousel({
            items: 5,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 3.2],
            itemsTabletSmall: false,
            itemsMobile: [479, 2.2],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left hidden-xs' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right hidden-xs'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        hotGoods3.owlCarousel({
            items: 5,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 3.2],
            itemsTabletSmall: false,
            itemsMobile: [479, 2.2],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left hidden-xs' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right hidden-xs'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        hotGoods4.owlCarousel({
            items: 5,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 3.2],
            itemsTabletSmall: false,
            itemsMobile: [479, 2.2],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left hidden-xs' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right hidden-xs'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        hotGoods5.owlCarousel({
            items: 5,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 3.2],
            itemsTabletSmall: false,
            itemsMobile: [479, 2.2],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left hidden-xs' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right hidden-xs'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        randomGoods.owlCarousel({
            items: 3,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });

        latestproducts.owlCarousel({
            items: 3,
            itemsDesktop: [829, 4],

            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            singleItem: false,

            itemsCustom: false,
            itemsScaleUp: false,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            paginationNumbers: false,
            navigation: true,
            navigationText: [
                "<i class='fa fa-chevron-left' style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
                "<i class='fa fa-chevron-right'style='font-size:20px; background-color: #90a5a8; height: 30px; width: 30px; border-radius: 50px; line-height: 30px; text-align: center;'></i>",
            ],
            rewindNav: false,
            scrollPerPage: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
        });


    });
</script>
<!--Sina-->

<script>
    $(document).ready(function () {
        var OSName = "Unknown OS";
        if (navigator.appVersion.indexOf("Win") != -1) OSName = "Windows";
        if (navigator.appVersion.indexOf("Mac") != -1) OSName = "MacOS";
        if (navigator.appVersion.indexOf("X11") != -1) OSName = "UNIX";
        if (navigator.appVersion.indexOf("Linux") != -1) OSName = "Linux";
        if (navigator.appVersion.indexOf("Android") != -1) OSName = "Android";
        if (navigator.appVersion.indexOf("iOS") != -1) OSName = "iOS";


        var Width = "270px";
        if (OSName == "Android" || OSName == "iOS") {

            if (screen.width <= 800 && screen.height <= 600) {
                document.getElementById("navtoggle").style.display = "block";
                document.getElementById('logo').style.backgroundSize = '120px';
                document.getElementById('logo').style.height = '36px';
                document.getElementById("div").style.fontSize = '8pt';
                document.getElementById('Test').className += ' Android'

                Width = "135px";
            }
            else {
                document.getElementById("navtoggle").style.display = "block";
                document.getElementById('logo').style.backgroundSize = '444px';
                document.getElementById('logo').style.height = '200px';
                document.getElementById("div").style.fontSize = '25pt';
                document.getElementById('Test').className += ' Androidbig';


                Width = "450px";
            }

        }
        $("#navtoggle").click(function () {


            document.getElementById("div").style.width = Width;

            $("#darklayer").show();


            var scrollPosition = [
                self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
                self.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
            ];
            var html = jQuery('html'); // it would make more sense to apply this to body, but IE7 won't have that
            html.data('scroll-position', scrollPosition);
            html.data('previous-overflow', html.css('overflow'));
            html.css('overflow', 'hidden');
            window.scrollTo(scrollPosition[0], scrollPosition[1]);
        });


        $("#darklayer").click(function () {
            document.getElementById("div").style.width = '0';

            $("#darklayer").hide();

            var html = jQuery('html');
            var scrollPosition = html.data('scroll-position');
            html.css('overflow', html.data('previous-overflow'));
            window.scrollTo(scrollPosition[0], scrollPosition[1])

        });


        //$("#nav li").click(function () {
        //    var contentPanelId = jQuery(this).attr("id");
        //    alert(yes);
        //    $("#" + contentPanelId + " ul").slideToggle(20);
        //}).children().click(function (e) {
        //    return false;
        //});
        $('#nav svg').addClass('Downarrow');


        var contentPanelId;

        $("#nav h4").click(function () {


            contentPanelId = jQuery(this).parent().attr("id");
//            alert(contentPanelId);
            $("#" + contentPanelId + " ul").slideToggle(200);
            //$('#nav svg').css('background-image' , 'url("Images/MobileSVG/up_arrow.svg")');
            contentPanelId2 = jQuery(this).attr("id");
            if ($('#' + contentPanelId2).hasClass('Dropshadow')) {
                $('#' + contentPanelId2).removeClass('Dropshadow');
            }
            else {
                $('#' + contentPanelId2).addClass('Dropshadow');
            }


            if ($('#' + contentPanelId2 + ' svg').hasClass('Downarrow')) {
                $('#' + contentPanelId2 + ' svg').removeClass('Downarrow');
                $('#' + contentPanelId2 + ' svg').addClass('Uparrow');
            }
            else {
                $('#' + contentPanelId2 + ' svg').removeClass('Uparrow');
                $('#' + contentPanelId2 + ' svg').addClass('Downarrow');

            }

        });


    });

</script>

<script>
    $(document).ready(function () {
        $('.dropdown-submenu a.test').on("click", function (e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
</script>

<!--Sina-->
<style>
    #most-popular-goods {
        direction: rtl;
    }

</style>
<script>
    $(document).ready(function () {
        $('.drawer').drawer();
    });
</script>
<script>
    $(document).ready(function () {

        //Accordion Nav
        $('.mainNav').navAccordion({
                expandButtonText: '<i class="fa fa-chevron-left"></i>',  //Text inside of buttons can be HTML
                collapseButtonText: '<i class="fa fa-chevron-down" style="color: #ff814a;"></i>'
            },
            function () {
                console.log('Callback')
            });

    });
</script>
</body>
</html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once 'Template/CustomeDate/jdatetime.class.php';
$factorProduct = new FactorProductDataSource();
$factorProduct->open();
$factorProducts = $factorProduct->FFill();
$factorProduct->close();
foreach ($factorProducts as $p) {
    if ($p->PaymentStatus == 0) {
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

        if ($p->PaymentStatus == 0) {
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

            $time3 = mktime($timer2[0], $timer2[1], 00, intval($date2[1]), $day, intval($date2[0]));

            if ($time3 < time()) {
                $var = new FactorProductDataSource();
                $var->open();
//                $var->TraceCode = $p->TraceCode;
                $vars = $var->FillByCode($p->TraceCode);
                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

                foreach ($vars as $v) {

                    $pcds = new ProductColorDataSource();
                    $pcds->open();
                    $productcolor = new ProductColor();
                    $productcolor = $pcds->FindOneProductColor2($v->Color, $v->Product->ProductId);
                    $productcolor->Quantity = $productcolor->Quantity + $v->Count;

                    $pcds->UpdateQuantity($productcolor);
                    $pcds->close();
                    $var->Delete($v->FactorProductId);
                }

                $var->close();
            }
        }
    }
}
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OnlineDataSource.inc';

$ods = new OnlineDataSource();
$ods->open();

$online = new Online();
$checkSession = $ods->checkSession(session_id());
$online->Session = session_id();
$online->Time = time();
if ($checkSession == NULL) {
    $ods->Insert($online);
} else {
    $online->OnlineId = $checkSession->OnlineId;
    $ods->Update($online);
}
$ods->close();