<?php
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/NewsDataSource.inc";
$new = new NewsDataSource();
$new->open();

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}
if (isset($_GET['news'])) {
    require_once 'Template/CustomeDate/jdatetime.class.php';
    $date = new jDateTime(true, true, 'Asia/Tehran');
    $new = new NewsDataSource();
    $new->open();
    $singlenews = $new->FindOneNewsBasedOnId($_GET['news']);
}
?>
<?php
if (isset($_GET['news'])) {
    ?>
    <title><?php echo $singlenews->Title; ?></title>
    <meta name="description" content="<?php echo $singlenews->MetaDescription; ?>">
    <meta name="keywords" content="<?php echo $singlenews->Keywords; ?>">
    <meta name="author" content="<?php echo $singlenews->User->Name . " " . $singlenews->User->Family; ?>">
    <?php
} else {
    ?>
    <title>خبر ها</title>
    <?php
}
?>
<?php
include_once 'Template/menu.php';
?>
    <div class="container">
        <div class="main-container">
            <div class="row">
                <div class="col-md-8">
                    <?php
                    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SlideDataSource.inc';

                    $slide = new SlideDataSource();
                    $slide->open();
                    $slides = $slide->Fill();
                    $slide->close();

                    $a = 0;
                    $array_slide = array();
                    foreach ($slides as $s) {
                        $array_slide[$a] = $s->SlideId;
                        $a++;
                    }
                    shuffle($array_slide);
                    if (!isset($_GET['news'])) {
                        ?>
                        <div class="row news-container">
                            <div class="slider-box col-md-12" style="margin-top: 0;">
                                <div class="row">
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
                                </div>
                                <script type="text/javascript">jssor_1_slider_init();</script>
                                <!--<img src="Template/Images/Slider/slider1.jpg">-->
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="news_search_box">
                                        <form method="get">
                                            <input type="text" id="search_box"
                                                   value="<?php if (isset($_GET['search_box'])) {
                                                       echo $_GET['search_box'];
                                                   } ?>" name="search_box" placeholder="جستجوی خبر ها..."/>
                                            <input type="submit" value="جستجو"/>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <?php
                                    if ((!isset($_GET['search_box']) || trim($_GET['search_box']) == "")) {

                                        $news = $new->Fill2();
                                    } else {
                                        $news = $new->Search2($_GET['search_box']);
                                    }
                                    ?>
                                    <div class="news_title">
                                        <span>جدیدترین خبر ها</span>
                                    </div>
                                </div>
                            </div>

                            <div class="header-line"></div>

                            <div class="row">
                                <div class="news-box">
                                    <?php
                                    $counter = 0;

                                    require_once 'Template/CustomeDate/jdatetime.class.php';

                                    $date = new jDateTime(true, true, 'Asia/Tehran');

                                    $pp2 = 1;
                                    foreach ($news as $n) {
                                        if (isset($_GET['page']) == TRUE && ($_GET['page'] * 15) - (15 - 1) <= $pp2 && $pp2 <= $_GET['page'] * 15) {
                                            $fdate = explode("/", $n->Date);
                                            $time2 = $date->mktime(0, 0, 0, $fdate[1], $fdate[2], $fdate[0], false, 'America/New_York');
                                            ?>
                                            <div class="col-md-12 New-Hover" style="padding-top: 3px;">
                                                <a href="News.php?news=<?php echo $n->NewsId; ?>"
                                                   style="text-decoration: none; color: inherit;">
                                                    <div class="new">
                                                        <div class="Title">
                        <span>
                            <?php echo $n->Title; ?>
                        </span>
                                                            <div class="Date">
                                                                <?php echo $date->date("l j F Y", $time2, false, true, 'Asia/Tehran'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 pull-right">
                                                            <div class="image-box">
                                                                <img src="<?php echo $n->Image; ?>"/>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-10">
                                                            <div class="Content">
                                                                <?php echo $n->Summary . '...'; ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        $counter++;
                                        $pp2++;
                                    }
                                    if ($news == null) {
                                        echo '<div class="col-md-12">';
                                        echo '<div class="no-result">نتیجه ای پیدا نشد</div>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <?php
                            $j = 15;
                            $pages = ceil($counter / $j);
                            if ($pages != 1 && $news != null) { ?>
                                <div class="NewsPager">
                                    <a class="page-link" id="1" href="?page=1<?php if (isset($_GET['search_box'])) {
                                        echo "&search_box=" . $_GET['search_box'];
                                    } ?>">صفحه اول</a>
                                    <?php
                                    $s = 1;
                                    if ($_GET['page'] > 3) {
                                        for ($j = $_GET['page'] - 2; $j <= $pages; $j++) {
                                            if ($j == $_GET['page'] - 2) {
                                                echo ' <span >...</span>';
                                            }
                                            if ($j <= $_GET['page'] + 2) {
                                                echo ' <a href="?page=' . $j;
                                                if (isset($_GET['search_box'])) {
                                                    echo "&search_box=" . $_GET['search_box'];
                                                }
                                                echo '" id="' . $j . '"  class="page-link  ';
                                                if ($j == $_GET['page']) {
                                                    echo ' Selected "';
                                                } else {
                                                    echo '"';
                                                }
                                                echo 'page=' . $j . ' " >' . $j . '</a>';
                                            }
                                            if ($j == $_GET['page'] + 3) {
                                                echo ' <span >...</span>';
                                            }
                                        }
                                    } else {
                                        for ($j = 1; $j <= $pages; $j++) {
                                            if ($j <= 5) {
                                                echo ' <a class="page-link ';
                                                if ($j == $_GET['page']) {
                                                    echo ' Selected ';
                                                }
                                                echo '" id="' . $j . '" ';
                                                echo ' href="?page=' . $j;
                                                if (isset($_GET['search_box'])) {
                                                    echo "&search_box=" . $_GET['search_box'];
                                                }
                                                echo '">' . $j . '</a>';
                                            }
                                            if ($j == 5) {
                                                echo ' <span >...</span>';
                                            }
                                        }
                                    }
                                    ?>
                                    <a id=" <?php echo $pages; ?> " class="page-link" href="?page=<?php
                                    echo $pages;
                                    if (isset($_GET['search_box'])) {
                                        echo "&search_box=" . $_GET['search_box'];
                                    }
                                    ?>">آخرین صفحه</a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="row news-container">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="news_search_box" style="margin-top: 0;">
                                        <form method="get">
                                            <input type="text" id="search_box"
                                                   value="<?php if (isset($_GET['search_box'])) {
                                                       echo $_GET['search_box'];
                                                   } ?>" name="search_box" placeholder="جستجوی خبر ها..."/>
                                            <input type="submit" value="جستجو"/>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="news_title" style="margin-top: 0;">
                    <span><?php
                        $fdate = explode("/", $singlenews->Date);
                        $time2 = $date->mktime(0, 0, 0, $fdate[1], $fdate[2], $fdate[0], false, 'America/New_York');
                        echo $date->date("l j F Y", $time2, false, true, 'Asia/Tehran');
                        ?></span>
                                        <a class="newshome-btn" href="News.php"><img
                                                    src="Template/Images/newshome.png"/></a>
                                    </div>
                                </div>
                            </div>

                            <div class="header-line"></div>

                            <div class="col-md-12">
                                <div class="news-box2">
                                    <div class="Title"><?php echo $singlenews->Title; ?></div>
                                    <div class="text">
                                        <?php
                                        echo $singlenews->Content;
                                        ?>
                                    </div>
                                    <div class="labels">
                                        <?php
                                        $labels = explode(',', $singlenews->Keywords);
                                        foreach ($labels as $l) {
                                            ?>
                                            <a href="News.php?search_box=<?php echo $l; ?>"
                                               style="text-decoration: none; color: inherit;"><span
                                                        class="label"><?php echo $l; ?></span></a>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="bottom-bar">
                                        نویسنده <?php echo $singlenews->User->Name . ' ' . $singlenews->User->Family; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="sidebar col-md-4 hidden-xs">
                    <!--SideBar-->
                    <!--Leates News-->
                    <?php
                    $news = $new->RandomFill();
                    if ($news != null) {
                        ?>
                        <div class="leates-news" style="margin-top: 0;">
                            <div class="title2 col-md-12">خبر های تصادفی</div>
                            <div class="header-line2"></div>
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
                    ?>
                    <?php
                    if (!isset($_GET['news'])) {
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

                        <?php
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
                                echo "</a>";
                                echo "</div>";
                                if (($i2 % 2) == 0 || $i2 == count($array_thumb)) {
                                    echo "</div>";
                                }
                                $i2++;
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
include_once "Template/bottom.php";
