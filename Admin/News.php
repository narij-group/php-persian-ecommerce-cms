<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/NewsDataSource.inc';
require_once '../Template/CustomeDate/jdatetime.class.php';
$date = new jDateTime(true, true, 'Asia/Tehran');

$nds = new NewsDataSource();
$nds->open();
$news = $nds->Fill();
$nds->close();
//-------------------------Cookies---------------
session_start();
$_SESSION[SESSION_STRING_SEARCH_KEY_CK] = "";
$_SESSION[SESSION_INT_CURRENT_PAGE] = 1;

if (isset($_SESSION[SESSION_YES_NO_USER_LOGGED_IN]) == FALSE) {
    $_SESSION[SESSION_YES_NO_USER_LOGGED_IN] = "NO";
}
if ($_SESSION[SESSION_YES_NO_USER_LOGGED_IN] == "NO" || !isset($_COOKIE[COOKIE_MY_USER_ID])) {
    header('location:../Index.php');
}
?>
<?php
include_once 'Template/top3.php';
if ($role->News != 1) {
    header('Location:Index.php');
    die();
}
?>
<?php
include_once 'Template/menu.php';
?>
<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<script>
    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();
    $(document).ready(function () {
        $(".page-link").click(function (e) {
            $("#wait").fadeIn(0);
            e.preventDefault();
            $.ajax({
                url: 'ajaxNewsSearch.php',
                type: 'POST',
                data: {
                    page: $(this).attr('id')
                },
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").fadeOut(0);
                },
                error: function (result) {
                    alert("لطفا دوباره امتحان کنید!");
                }
            });
        });
        $('#search_box').keyup(function () {
            $("#wait").fadeIn(0);
            delay(function () {
                $.ajax({
                    type: 'POST',
                    url: 'ajaxNewsSearch.php',
                    data: $('#search_form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                    }
                });
            }, 1000);
        });
    });
</script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>اخبار</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>News</h2>
    </div>
</div>

<div class="modalback" id="modalback"></div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست اخبار</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    <form id="search_form">
                        <div class="alert alert-success text-center">
                            جستجو بر اساس عنوان،کلمات کلیدی،توضیحات متا،نویسنده و تاریخ(میلادی)
                        </div>
                        <div class="database-search"
                             style="margin-right: auto; margin-left: auto; margin-bottom: 10px;">
                            <input class="form-control input-sm m-b-xs" type="text" name="search_box" id="search_box" placeholder="جستجو..."
                                   title="جستجو بر اساس عنوان،کلمات کلیدی،توضیحات متا،نویسنده و تاریخ(میلادی)"
                                   value=""/>
                            <!--<input type="submit" id="search_btn" value="جستجو" />-->
                        </div>
                    </form>

                    <?php
                    if ($role->InsertNews == 1) {
                        ?>
                        <a href="NewsForm.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن خبر جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <div id="db" name="db">
                        <div class="Database">
                            <div class="db-cover" id="wait">
                    <span class="loading-title <?php
                    if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                        echo " SBackground'";
                    } else {
                        echo " GBackground'";
                    }
                    ?>">Loading...</span>
                                <img class="loading-gif" src="Template/Images/gifs/giphy (3).gif" alt=""/>
                            </div>
                            <table class="footable table table-stripped" data-page-size="1000000000"
                                   data-filter=#filter>
                                <thead>
                                <tr>
                                    <th data-sort-ignore="true"></th>
                                    <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <th> عنوان</th>
                                    <th data-hide="phone,tablet">نویسنده</th>
                                    <th>تاریخ</th>
                                    <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                    if ($role->DeleteNews == 1 || $role->EditNews == 1) {
                                        ?>
                                        <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                </thead>
                                <tbody>
                                <script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
                                <?php
                                $i = 0;
                                $j = 30;
                                foreach ($news as $p1) {
                                    $i++;
                                }
                                $pages = ceil($i / $j);
                                $pp2 = 1;
                                $postsCounter = 0;
                                $counter2 = 0;
                                foreach ($news as $p) {
                                    if ((1 * 30) - (30 - 1) <= $pp2 && $pp2 <= 1 * 30) {
                                        $postsCounter++;
                                        echo "<tr>";
                                        echo "<td><div class='DatabaseField' >";
                                        echo "<div class='product-status'>";
                                        if ($p->Status == 1) {
                                            echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                        } else {
                                            echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                        }
                                        echo "</div></td>";

                                        echo "<td><div class='DatabaseField2' >";
                                        echo "<div class='news-image'>";
                                        echo "<img title='تصویر' src = '../" . $p->Image . "' />";
                                        echo "</div></td>";

                                        echo "<td><div class='DatabaseField LineHeight' >";
                                        echo '<div class="new-title"><b>';
                                        if (strlen($p->Title) > 65) {
                                            $str = substr($p->Title, 0, 65) . '...';
                                            echo $str;
                                        } else {
                                            echo $p->Title;
                                        }
                                        echo "</b></div>";
                                        echo "</div></td>";

                                        echo "<td><div class='DatabaseField LineHeight' >";
                                        echo '<div class="new-title">';
                                        echo $p->User->Name . ' ' . $p->User->Family;
                                        echo "</div>";
                                        echo "</div></td>";

                                        $fdate = explode("/", $p->Date);
                                        $time2 = $date->mktime(0, 0, 0, $fdate[1], $fdate[2], $fdate[0], false, 'America/New_York');
                                        echo "<td><div class='DatabaseField' >";
                                        echo "" . $date->date("l j F Y", $time2, false, true, 'Asia/Tehran') . "</div>";
                                        echo "</div></td>";

                                        echo "<td><div class='DatabaseField options-container' style='width:20px;' >";
                                        echo '<div class="product-meta ';
                                        if (strlen($p->MetaDescription) / 1.5 < 80) {
                                            echo 'meta-red';
                                        } elseif (strlen($p->MetaDescription) / 1.5 > 79 && strlen($p->MetaDescription) / 1.5 < 135) {
                                            echo 'meta-yellow';
                                        } elseif (strlen($p->MetaDescription) / 1.5 > 134 && strlen($p->MetaDescription) / 1.5 < 180) {
                                            echo 'meta-green';
                                        } else {
                                            echo 'meta-yellow';
                                        }
                                        echo '" title="وضعیت متا (توضیحات متا)">';
                                        echo "</div>";

                                        $word = explode(",", $p->Keywords);
                                        $words = 0;
                                        foreach ($word as $w) {
                                            $words++;
                                        }
                                        echo '<div class="product-meta ';
                                        if ($words < 5) {
                                            echo 'meta-red';
                                        } elseif ($words >= 5 && $words < 15) {
                                            echo 'meta-yellow';
                                        } else {
                                            echo 'meta-green';
                                        }
                                        echo '" title="وضعیت متا (کلمات کلیدی)">';
                                        echo "</div>";
                                        echo "</div></td><td>";

                                        echo "<button class='btn-white btn btn-sm m-xs' title='View'><a target='_blank' href='../News.php?news=$p->NewsId'>" . "نمایش" . "</a></button></td>";
                                        if ($role->EditNews == 1 || $role->DeleteNews == 1) {
                                            echo '<td>';
                                        }
                                        if ($role->EditNews == 1) {
                                            echo "<button class='btn-white btn btn-sm m-xs' title='Edit'><a  title='Edit' href='NewsForm.php?id=" . $p->NewsId . "'>" . "ویرایش" . "</a></button>";
                                        }
                                        if ($role->DeleteNews == 1) {
                                            echo "<button class='btn-white btn btn-sm m-xs' title='Delete'><a  title='Delete' onclick='return deleteConfirm()' href='operateNews.php?id=" . $p->NewsId . "'>" . "حذف" . "</a></button>";
                                        }
                                        if ($role->EditNews == 1 || $role->DeleteNews == 1) {
                                            echo '</td>';
                                        }
                                        echo "</tr>";
                                    }
                                    $pp2++;
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
                        <?php if ($pages != 1) { ?>
                            <div class="Pager">
                                <a class="page-link btn btn-success" id="1" href="">صفحه اول</a>
                                <?php
                                $s = 1;
                                for ($j = 1;
                                     $j <= $pages;
                                     $j++) {
                                    if ($j <= 5) {
                                        echo ' btn btn-warning ';
                                        if ($j == 1) {
                                            echo ' btn btn-success ';
                                        }
                                        echo '" id="' . $j . '" ';
                                        echo ' href="">' . $j . '</a>';
                                    }
                                    if ($j == 5) {
                                        echo ' <a href="">...</a>';
                                    }
                                }
                                ?>
                                <a id="<?php echo $pages; ?>" class="page-link btn btn-success" href="">آخرین صفحه</a>
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
<?php
include_once 'Template/bottom.php';
