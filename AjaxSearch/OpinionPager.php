<script>
    $(document).ready(function () {
        $(".page-link2").click(function () {
            $("#wait").fadeIn(0);
            $.ajax({
                url: 'AjaxSearch/OpinionPager.php',
                type: 'POST',
                data: {
                    page: $(this).attr('id'), product: <?php echo $_POST['product']; ?>
                },
                success: function (result) {
                    $("#wait").fadeOut(0);
                    $("#opinions5").html(result);
                },
                error: function (result) {
                    alert("لطفا دوباره امتحان کنید!");
                }
            });
        });
    });
</script>
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';

$opinion = new OpinionDataSource();
$opinion->open();
$opinions = $opinion->CFill($_POST['product']);
$opinion->close();
$i = 0;
$j = 30;
foreach ($opinions as $p1) {
    $i++;
}
$pages = ceil($i / $j);
$pp2 = 1;
session_start();
if (isset($_POST['page'])) {
    $_SESSION[SESSION_INT_CURRENT_PAGE_2] = $_POST['page'];
}
?>
<div class="db-cover5" id="wait">
    <span class="loading-title"></span>
    <img class="loading-gif" src="../Template/Images/loading.gif" alt=""/>
</div>
<?php
$t = 0;
foreach ($opinions as $c) {
    if (isset($_SESSION[SESSION_INT_CURRENT_PAGE_2]) == TRUE && ($_SESSION[SESSION_INT_CURRENT_PAGE_2] * 30) - (30 - 1) <= $pp2 && $pp2 <= $_SESSION[SESSION_INT_CURRENT_PAGE_2] * 30) {
        ?>
        <div class="comment-box">
            <div class="db-cover6" id="wait2">
                <span class="loading-title8">لطفا چند لحظه صبر کنید...</span>
                <img class="loading-gif8" src="Admin/Template/Images/gifs/loading.gif" alt=""/>
            </div>
            <div class="heading">
                <span class="comment-box-ico"></span>
                <div class="auther">
                    <h5><?php echo $c->Customer->Name . " " . $c->Customer->Family; ?></h5>
                    <time>
                        <?php
                        echo $c->Date;
                        ?>
                    </time>
                </div>
                <div class="like-container">
                    <select id="rate<?php echo $c->OpinionId; ?>">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $('#rate<?php echo $c->OpinionId; ?>').barrating({
                            theme: 'fontawesome-stars',
                            readonly: true
                        });
                        $('#rate<?php echo $c->OpinionId; ?>').barrating('set', <?php echo $c->Rate; ?>);
                    });
                </script>
            </div>
            <div class="horizontal-line"></div>
            <div class="comment-content">
                <p>
                    <?php echo $c->Value; ?>
                </p>
            </div>

        </div>
        <?php
        $t++;
        if ($t == 0) {
            echo '<div class="CommentText">';
            echo "نظری ثبت نشده است .";
            echo '</div>';
        }
        ?>
        </div>
        <?php
    } elseif (isset($_SESSION[SESSION_INT_CURRENT_PAGE_2]) == false && 1 <= $pp2 && $pp2 <= 30) {
        ?>
        <div class="comment-box">
            <div class="db-cover6" id="wait2">
                <span class="loading-title8">لطفا چند لحظه صبر کنید...</span>
                <img class="loading-gif8" src="Admin/Template/Images/gifs/loading.gif" alt=""/>
            </div>
            <div class="heading">
                <span class="comment-box-ico"></span>
                <div class="auther">
                    <h5><?php echo $c->Customer->Name . " " . $c->Customer->Family; ?></h5>
                    <time>
                        <?php
                        echo $c->Date;
                        ?>
                    </time>
                </div>
                <div class="like-container">
                    <select id="rate<?php echo $c->OpinionId; ?>">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $('#rate<?php echo $c->OpinionId; ?>').barrating({
                            theme: 'fontawesome-stars',
                            readonly: true
                        });
                        $('#rate<?php echo $c->OpinionId; ?>').barrating('set', <?php echo $c->Rate; ?>);
                    });
                </script>
            </div>
            <div class="horizontal-line"></div>
            <div class="comment-content">
                <p>
                    <?php echo $c->Value; ?>
                </p>
            </div>

        </div>
        <?php
        $t++;
    }
    $pp2++;
}
if ($t == 0) {
    echo '<div class="CommentText">';
    echo "نظری ثبت نشده است .";
    echo '</div>';
}
?>
</div>
<?php
if ($pages != 1 && $opinions != null) { ?>
    <div class="Pager2">
        <a class="page-link2" id="1" href="#comments">صفحه اول</a>
        <?php
        $s = 1;
        if ($_SESSION[SESSION_INT_CURRENT_PAGE_2] > 3) {
            for ($j = $_SESSION[SESSION_INT_CURRENT_PAGE_2] - 30; $j <= $pages; $j++) {
                if ($j <= $_SESSION[SESSION_INT_CURRENT_PAGE_2] + 30) {
                    echo ' <a href="#comments" id="' . $j . '"  class="page-link2  ';
                    if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE_2]) {
                        echo ' Selected "';
                    } else {
                        echo '"';
                    }
                    echo 'page=' . $j . ' " >' . $j . '</a>';
                } else {

                }
                if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE_2] + 3) {
                    echo ' <span >...</span>';
                }
            }
        } else {
            for ($j = 1; $j <= $pages; $j++) {
                if ($j <= 5) {
                    echo ' <a id="' . $j . '"  class="page-link2  ';
                    if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE_2]) {
                        echo ' Selected "';
                    } else {
                        echo '"';
                    }
                    echo ' href="#comments">' . $j . '</a>';
                }
                if ($j == 5) {
                    echo ' <span >...</span>';
                }
            }
        }
        ?>
        <a id="<?php echo $pages; ?>" class="page-link2" href="#comments">آخرین صفحه</a>
    </div>
    <?php
}
?>
