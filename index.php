<?php
include_once 'Template/top.php';
?>
    <title><?php echo $settings->SiteName; ?></title>
    <meta name="author" content="<?php echo $settings->MetaAuthor ?>">
    <meta name="description" content="<?php echo $settings->MetaDescription; ?>">
    <meta name="keywords" content="<?php echo $settings->MetaKeywords; ?>">
    <meta name="keywords" content="<?php echo $settings->MetaKeywords; ?>">

<?php
include_once 'Template/menu.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/UI/WidgetBuilder.php';
?>
    <div class="success-message" id="cart-success-msg">محصول با موفقیت به سبد خرید افزوده شد</div>
    <div class="success-message" style="background-color: #fff49e; color: black;" id="cart-warning-cart-msg">
        محصول قبلا به سبد خرید اضافه شده است
    </div>
    <div class="container">

        <div class="main-container">

            <!--            Category-->
            <?php
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GroupDataSource.inc';
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SubGroupDataSource.inc';
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SupperGroupDataSource.inc';
            $gds = new GroupDataSource();
            $gds->open();
            $groups = $gds->getPlaceAsMainCat();
            $gds->close();

            $sbds = new SubGroupDataSource();
            $sbds->open();
            $subgroups = $sbds->getPlaceAsMainCat();
            $sbds->close();

            $spds = new SupperGroupDataSource();
            $spds->open();
            $supgroups = $spds->getPlaceAsMainCat();
            $spds->close();

            echo '<div class="row top-category">';
            foreach ($groups as $g) {
                if ($g->PlaceAsMainCat == 1) {
                    echo '<a href="Products.php?group=' . $g->GroupId . '">';
                    echo '<div class="gallery_category col-lg-2 col-md-2 col-sm-2 col-xs-6 filter hdpe">';
                    echo '<img src="' . $g->Image . '" class="img-responsive">';
                    echo '<div class="desc">' . $g->Name . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            }
            foreach ($subgroups as $sbg) {
                if ($g->PlaceAsMainCat == 1) {
                    echo '<a href="Products.php?sbgroup=' . $sbg->SubGroupId . '">';
                    echo '<div class="gallery_category col-lg-2 col-md-2 col-sm-2 col-xs-6 filter hdpe">';
                    echo '<img src="' . $sbg->Image . '" class="img-responsive">';
                    echo '<div class="desc">' . $sbg->Name . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            }
            foreach ($supgroups as $spg) {
                if ($g->PlaceAsMainCat == 1) {
                    echo '<a href="Products.php?spgroup=' . $spg->SupperGroupId . '">';
                    echo '<div class="gallery_category col-lg-2 col-md-2 col-sm-2 col-xs-6 filter hdpe">';
                    echo '<img src="' . $spg->Image . '" class="img-responsive">';
                    echo '<div class="desc">' . $spg->Name . '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            }
            echo '</div>';
            ?>
            <!--            End Category-->

            <?php
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductDataSource.inc';
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PriceDataSource.inc';
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/DiscountDataSource.inc';
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SpecialOfferTitleDataSource.inc';
            $discount = new DiscountDataSource();
            $discount->open();

            $product = new ProductDataSource();
            $product->open();
            $price = new PriceDataSource();
            $price->open();
            $p = new Product();
            $products = $product->FillIfExists();
            $most_popular = $product->CFillLimit("Popularity", "DESC");
//            $best_sellers_products = $product->FillDependOnSells2();
            $random_products = $product->FillRandomProduct();
            //        $p = new ProtocolList();
            //        $protocollists = $p->Fill();
            $sotds = new SpecialOfferTitleDataSource();
            $sotds->open();
            $specialoffertitles = $sotds->FillByActive();
            $sotds->close();
            ?>

            <?php
            if (!$specialoffertitles == null) {
                $si = 1;
                foreach ($specialoffertitles as $sot) {
                    $specialoffers = null;
                    $specialoffers = $product->FillSpecialOfferProduct($sot->SpecialOfferTitleId);
                    if (!$specialoffers == null) {
                        ?>
                        <div class="goods-list-container col-md-12">
                            <div class="row title">
                                <span class="title-name"> پیشنهادات ویژه <?php echo "<span class='SpecialOffer-Title'> [ " . $sot->Title . " ] </span>"; ?></span>
                                <a href="Products.php?special_offers=<?php echo $sot->SpecialOfferTitleId; ?>"><span
                                            class="fa fa-plus"></span>ادامه لیست</a>
                            </div>
                            <div class="header-line2"></div>
                            <div class="wrapper-with-margin ltr">
                                <div id="hot-goods<?php echo $si ?>" class="owl-carousel">
                                    <?php
                                    foreach ($specialoffers as $p) {

                                        if ($settings->AskQuantityForAdding == 1) {
                                            WidgetBuilder::createProductThumbViewHomePageInstantPurchase($p, $tax);
                                        } else {
                                            WidgetBuilder::createProductThumbViewHomePage($p, $tax);
                                        }
//                                    $last_discount = $discount->GetLastDiscountForOneProduct($p->ProductId);
//                                    $last_price = $price->GetLastPriceForOneProduct($p->ProductId);

                                        ?>


                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>

                            <!---->
                            <!--            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">-->
                            <!--                <div class="item">-->
                            <!--                    <div class="image">-->
                            <!--                    <span>-->
                            <!--                        <a href="#" class="hover-image"><span class="fa fa-arrow-right"></span></a>-->
                            <!--                        <img src="Template/Images/test-product.jpg"/></span>-->
                            <!--                    </div>-->
                            <!--                    <a href="#">-->
                            <!--                        <div class="fa-name">نود 32 آنتی ویروس موبایل</div>-->
                            <!--                    </a>-->
                            <!--                    <a href="#">-->
                            <!--                        <div class="en-name">Node 2017 32 For Mobile</div>-->
                            <!--                    </a>-->
                            <!--                    <a href="#">-->
                            <!--                        <div class="cost-box">9700 تومان</div>-->
                            <!--                    </a>-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                        </div>
                        <?php
                    }
                    $si++;
                }
                ?>
                <?php
            }
            ?>


            <!--<div class="banner col-md-12">-->
            <!--</div>-->


            <div class="row content-box">
                <div class="content col-md-9">

                    <div class="slider-box">

                        <div id="slideshow">
                            <div id="jssor_1"
                                 style="visibility: hidden; position: relative; margin: 0 auto; width: 827px; height: 340px; overflow: hidden;">
                                <div data-u="slides"
                                     style="position: absolute; left: 0px; top: 0px; width: 827px; height: 340px; overflow: hidden;">
                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SlideDataSource.inc';
                                    $slds = new SlideDataSource();
                                    $slds->open();
                                    $slides = $slds->Fill();
                                    $slds->close();
                                    shuffle($slides);
                                    $i = 1;
                                    foreach ($slides as $slide) {
                                        if ($i <= 5) {
                                            echo '<div>';
                                            echo '<a href="' . $slide->Link . '"><img data-u = "image" src = "' . $slide->Image . '" /></a>';
                                            echo '<div data-u = "thumb">';
                                            echo '<div class = "title_back"></div>';
                                            echo '<div class = "title">';
                                            echo '<span class="caret-top2"></span>';
                                            echo $slide->Name;
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div >';
                                            $i++;
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- Thumbnail Navigator -->
                                <div data-u="thumbnavigator" class="jssort16"
                                     style="position:absolute;left:0px;bottom:0px;width:827px;height:50px;background-color: rgba(30,44,57,.5);"
                                     data-autocenter="1">
                                    <!-- Thumbnail Item Skin Begin -->
                                    <div data-u="slides" style="cursor: pointer;">
                                        <div data-u="prototype" class="p">
                                            <div data-u="thumbnailtemplate" class="t"></div>
                                        </div>
                                    </div>
                                    <!-- Thumbnail Item Skin End -->
                                </div>
                                <!-- Bullet Navigator -->
                            </div>
                        </div>

                        <script type="text/javascript">jssor_1_slider_init();</script>
                        <!--<img src="Template/Images/Slider/slider1.jpg">-->
                    </div>

                    <div class="clear-fix"></div>

                    <article class="list-container">
                        <div class="header">
                            <div class="full-list col-md-6">
                                <a href="Products.php"><span class="fa fa-plus"></span>ادامه لیست</a>
                            </div>
                            <div class="title col-md-6">
                                <span>جدیدترین کالا ها</span>
                            </div>
                        </div>
                        <div class="header-line"></div>

                        <div class="latest-products visible-xs">
                            <div class="wrapper-with-margin ltr">
                                <div id="latest-products" class="owl-carousel">
                                    <?php
                                    $ccounter = 0;
                                    foreach ($products as $p) {

//                                    echo $settings->AskQuantityForAdding;
                                        if ($settings->AskQuantityForAdding == 1) {
                                            WidgetBuilder::createProductThumbViewHomePageInstantPurchase($p, $tax);
                                        } else {
                                            WidgetBuilder::createProductThumbViewHomePage($p, $tax);
                                        }
//                                    $last_discount = $discount->GetLastDiscountForOneProduct($p->ProductId);
//                                    $last_price = $price->GetLastPriceForOneProduct($p->ProductId);
                                        ?>


                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="latest-products hidden-xs">
                            <?php
                            $ccounter = 0;
                            foreach ($products as $p) {
                                $last_discount = $discount->GetLastDiscountForOneProduct($p->ProductId);
                                $last_price = $price->GetLastPriceForOneProduct($p->ProductId);


//                        if ($ccounter == 0 || $ccounter == 3 || $ccounter == 6 || $ccounter == 9) {
//                                                    echo '<div class="row">';
//                        }
                                echo '<div class="col-lg-3 col-md-4 col-sm-4">';

                                if ($settings->AskQuantityForAdding == 1) {
                                    WidgetBuilder::createProductThumbViewHomePageInstantPurchase($p, $tax);
                                } else {
                                    WidgetBuilder::createProductThumbViewHomePage($p, $tax);
                                }


                                ?>

                                <?php
                                echo '</div>';
//                        if ($ccounter == 2 || $ccounter == 5 || $ccounter == 8) {
//                                                    echo '</div>';
//                        }
                                $ccounter++;

                            }
                            ?>

                            <div class="clear-fix"></div>
                        </div>
                    </article>


                    <?php

                    require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/SubGroupDataSource.inc";

                    $sbgds = new SubGroupDataSource();
                    $sbgds->open();
                    $subgroupid = $sbgds->GetRandomId();
                    $sbg = $sbgds->FindOneSubGroupBasedOnId($subgroupid);
                    $sbgds->close();


                    //TODO SHOULD BE OPTIMISED
                    $productIds = $product->FillBySG2($subgroupid);
                    $products2 = array();
                    $i = 0;
                    foreach ($productIds as $p) {
//                            $p2 = new Product();
//                            $p2->ProductId = $p;
                        $products2[$i] = $product->FindOneProductBasedOnId($p);
                        $i++;
                    }
                    $product->close();
                    if ($products2 != null) {

                        ?>
                        <!--Random Slider-->
                        <article class="list-container">
                            <div class="header">
                                <div class="full-list col-md-6">
                                    <a href="Products.php?sbgroup=<?php echo $sbg->SubGroupId; ?>"><span
                                                class="fa fa-plus"></span>ادامه لیست</a>
                                </div>
                                <div class="title col-md-6">
                                    <span><?php echo $sbg->Name; ?></span>
                                </div>
                            </div>
                            <div class="header-line"></div>
                            <div class="latest-products">
                                <div class="wrapper-with-margin ltr">
                                    <div id="random-goods" class="owl-carousel">
                                        <?php
                                        $ccounter = 0;
                                        foreach ($products2 as $p) {
                                            if ($settings->AskQuantityForAdding == 1) {
                                                WidgetBuilder::createProductThumbViewHomePageInstantPurchase($p, $tax);
                                            } else {
                                                WidgetBuilder::createProductThumbViewHomePage($p, $tax);
                                            }
//                                        $last_discount = $discount->GetLastDiscountForOneProduct($p->ProductId);
//                                        $last_price = $price->GetLastPriceForOneProduct($p->ProductId);
                                            ?>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php
                    }
                    ?>


                    <article class="list-container">
                        <div class="header">
                            <div class="full-list col-md-6">
                                <a href="Products.php?MostPopular"><span class="fa fa-plus"></span>ادامه لیست</a>
                            </div>
                            <div class="title col-md-6">
                                <span>محبوب ترین کالا ها</span>
                            </div>
                        </div>
                        <div class="header-line"></div>
                        <div class="latest-products">
                            <div class="wrapper-with-margin ltr">
                                <div id="latest-goods" class="owl-carousel">
                                    <?php
                                    $ccounter = 0;
                                    foreach ($most_popular as $p) {


                                        if ($settings->AskQuantityForAdding == 1) {
                                            WidgetBuilder::createProductThumbViewHomePageInstantPurchase($p, $tax);
                                        } else {
                                            WidgetBuilder::createProductThumbViewHomePage($p, $tax);
                                        }
//                                    $last_discount = $discount->GetLastDiscountForOneProduct($p->ProductId);
//                                    $last_price = $price->GetLastPriceForOneProduct($p->ProductId);

                                        ?>


                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="list-container">
                        <div class="header">
<!--                            <div class="full-list col-md-6">-->
<!--                                <a href="Products.php?BestSellers"><span class="fa fa-plus"></span>ادامه لیست</a>-->
<!--                            </div>-->
                            <div class="title col-md-6">
                                <span>کالاهای تصادفی</span>
                            </div>
                        </div>
                        <div class="header-line"></div>
                        <div class="latest-products">
                            <div class="wrapper-with-margin ltr">
                                <div id="best-selling-goods" class="owl-carousel">
                                    <?php
                                    foreach ($random_products as $p) {

                                        if ($settings->AskQuantityForAdding == 1) {
                                            WidgetBuilder::createProductThumbViewHomePageInstantPurchase($p, $tax);
                                        } else {
                                            WidgetBuilder::createProductThumbViewHomePage($p, $tax);
                                        }
//                                    $last_discount = $discount->GetLastDiscountForOneProduct($p->ProductId);
//                                    $last_price = $price->GetLastPriceForOneProduct($p->ProductId);

                                        ?>


                                        <?php
                                        $ccounter++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>


                </div>

                <div class="sidebar col-md-3 hidden-xs">
                    <?php
                    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ThumbDataSource.inc';
                    $thumb = new ThumbDataSource();
                    $thumb->open();
                    $thumbs = $thumb->Fill();
                    $thumb->close();

                    $a = 0;
                    $array_thumb = array();
                    foreach ($thumbs as $t) {
                        $array_thumb[$a] = $t->ThumbId;
                        $a++;
                    }
                    shuffle($array_thumb);
                    ?>

                    <div class="advertise-box">
                        <img src="Template/Images/advertise.jpg"/>
                        <!--                        <script>!function(e,t,a){"use strict";  var s=t.head||t.getElementsByTagName( "head" )[ 0 ], p=t.createElement( "script" ); e.iwmfBadge=a, p.async=true, p.src= "https://c.iwmf.ir/get-code/people-vote-2-1.js?v=10.1", s.appendChild(p) }(this,document,"o-bottom-right");</script>-->
                    </div>

                    <?php
                    $i = 1;
                    $i2 = 1;
                    foreach ($array_thumb as $j) {
                        if ($i <= 5) {
                            if (($i2 % 2) == 1) {
                                echo '<div class="row col-centered">';
                            }
                            $thumb2 = new ThumbDataSource();
                            $thumb2->open();
                            $ss = $thumb2->FindOneThumbBasedOnId($j);
                            $thumb2->close();
                            echo '<div class="side-box col-lg-12 col-md-12 col-sm-6 col-xs-12">';
                            echo "<a href='$ss->Link'>";
                            echo "<img src='$ss->Image' title='$ss->Name' />";
//                            echo "<img src='Template/Images/advertise.jpg' />";
                            echo "</a>";
                            echo "</div>";
                            if (($i2 % 2) == 0 || $i2 == count($array_thumb)) {
                                echo "</div>";
                            }
                            $i2++;
                        }
                    }
                    ?>


                    <div class="clear-fix"></div>

                    <!--Leates News-->
                    <?php
                    require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/NewsDataSource.inc";
                    $new = new NewsDataSource();
                    $new->open();
                    $news = $new->CFill();
                    $new->close();
                    if ($news != null) {
                        ?>
                        <div class="leates-news">
                            <div class="title col-md-12">جدید ترین خبر ها</div>
                            <div class="full-list col-md-12"><a href="News.php"><span class="fa fa-plus"></span>ادامه
                                    لیست</a>
                            </div>
                            <div class="clear-fix"></div>

                            <?php
                            require_once 'Template/CustomeDate/jdatetime.class.php';

                            $date = new jDateTime(true, true, 'Asia/Tehran');

                            foreach ($news as $n) {
                                $fdate = explode("/", $n->Date);
                                $time2 = $date->mktime(0, 0, 0, $fdate[1], $fdate[2], $fdate[0], false, 'America/New_York');
                                ?>

                                <div class="item">
                                    <div class="col-md-4 col-sm-2 col-xs-4 pull-right">
                                        <a href="News.php?news=<?php echo $n->NewsId; ?>" title=""><img alt="" title=""
                                                                                                        src="<?php echo $n->Image; ?>"/></a>
                                    </div>
                                    <div class="col-md-8 col-sm-10 col-xs-8">
                                        <div class="info">
                                            <a href="News.php?news=<?php echo $n->NewsId; ?>"
                                               class="title"><span><?php echo $n->Title; ?></span></a>
                                            <span class="news-date"><?php echo $date->date("l j F Y", $time2, false, true, 'Asia/Tehran'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                            ?>

                            <div class="clear-fix"></div>
                        </div>
                        <?php
                    }
                    if (trim($settings->ENamadLink) != "") {
                        ?>
                        <div class="leates-news">
                            <div class="title col-md-12">نماد الکترونیک</div>
                            <div class="horizontal-line"></div>
                            <div class="clear-fix"></div>
                            <div class="enamad">
                                <?php echo $settings->ENamadLink; ?>
                            </div>
                            <div class="clear-fix"></div>
                        </div>
                        <?php
                    }


                    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/LogoDataSource.inc';
                    $logo = new LogoDataSource();
                    $logo->open();
                    $logos = $logo->FillActives();
                    $logo->close();
                    ?>
                    <div class="row">
                        <div class="logos">
                            <table>
                                <?php
                                $c = -1;
                                $i = 2;
                                $c1 = 1;
                                foreach ($logos as $l) {
                                    $c++;
                                    ?>

                                    <?php
                                    if ($c == $i * $c1) {
                                        $c1++;
                                        echo "<tr>";
                                    }
                                    ?>
                                    <td>
                                        <a href="<?php echo "Products.php?brand=$l->LogoId"; ?>"><img
                                                    src="<?php echo $l->Image; ?>"
                                                    alt=""/></a>
                                    </td>
                                    <?php
                                    if ($c == $i * $c1) {
                                        $c1++;
                                        echo "</tr>";
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
<?php
include_once 'Template/bottom.php';