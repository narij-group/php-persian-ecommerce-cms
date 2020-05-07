<script>
    $(document).ready(function () {
        $(".page-link").click(function () {
            $("#wait").fadeIn(0);
            $.ajax({
                url: 'AjaxSearch/CommentPager.php',
                type: 'POST',
                data: {
                    page: $(this).attr('id'), product: <?php echo $_POST['product']; ?>
                },
                success: function (result) {
                    $("#wait").fadeOut(0);
                    $("#comments5").html(result);
                },
                error: function (result) {
                    alert("لطفا دوباره امتحان کنید!");
                }
            });
        });
    });
</script>
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';

$cmds = new CommentDataSource();
$cmds->open();
$comment = new Comment();
$comment->ProductId = $_POST['product'];
$comments = $cmds->CFill($comment);
$cmds->close();

$i = 0;
$j = 30;
foreach ($comments as $p1) {
    $i++;
}
$pages = ceil($i / $j);
$pp2 = 1;
session_start();
if (isset($_POST['page'])) {
    $_SESSION[SESSION_INT_CURRENT_PAGE] = $_POST['page'];
}
?>
<div class="db-cover5" id="wait">
    <span class="loading-title"></span>
    <img class="loading-gif" src="../Template/Images/loading.gif" alt=""/>
</div>
<?php
$t = 0;
foreach ($comments as $c) {
    if (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == TRUE && ($_SESSION[SESSION_INT_CURRENT_PAGE] * 30) - (30 - 1) <= $pp2 && $pp2 <= $_SESSION[SESSION_INT_CURRENT_PAGE] * 30) {
        if ($c->ReplyId == 0) {
            $_SESSION[SESSION_INT_COMMENTS_COUNTER]++;
            ?>
            <div class="faq-panel">
                <div class="heading">
                                <span class="header-title">
                                    <span class="question-ico"></span>
                                    پرسش
                                </span>
                    <time class="time">
                        <?php echo $c->Date; ?>
                    </time>
                    <span class="auther">
                                    <?php echo $c->Customer->Name . ' ' . $c->Customer->Family; ?>
                                </span>
                </div>
                <div class="question-body rounr-corner">
                    <?php echo $c->Value; ?>
                </div>
                <?php
                $commentR = new Comment();
                $commentRs = $commentR->FindOneCommentReplies($c->CommentId);
                if ($commentRs != null) {
                    foreach ($commentRs as $cr) {
                        ?>
                        <div class="answer-body rounr-corner">
                            <i class="user-comment-ico"></i>
                            <div class="user-replay-header">
                                <div class="auther">
                                    <h5>
                                        <?php echo $cr->Customer->Name . ' ' . $cr->Customer->Family; ?>
                                    </h5>
                                    <time>
                                        <?php echo $cr->Date; ?>
                                    </time>
                                </div>
                            </div>

                            <div class="horizontal-line"></div>
                            <div class="user-replay-content">
                                <label>
                                    پاسخ :
                                </label>
                                <p>
                                    <?php
                                    echo $cr->Value;
                                    ?>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
            <div class="answer-op">
                <a onclick="<?php
                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {

                } else {
                    echo 'loginFirst()';
                }
                ?>" href="
                               <?php
                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                    echo "Answer.php?commentId=$c->CommentId&productId=$product->ProductId";
                } else {
                    echo '#';
                }
                ?>">
                                <span class="arrow-left">
                                </span>
                    به این پرسش پاسخ دهید
                </a>
            </div>

            <?php
            $t++;
        }
    } elseif (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == false && 1 <= $pp2 && $pp2 <= 30) {
        if ($c->ReplyId == 0) {
            $_SESSION[SESSION_INT_COMMENTS_COUNTER]++;
            ?>
            <div class="faq-panel">
                <div class="heading">
                                <span class="header-title">
                                    <span class="question-ico"></span>
                                    پرسش
                                </span>
                    <time class="time">
                        <?php echo $c->Date; ?>
                    </time>
                    <span class="auther">
                                    <?php echo $c->Customer->Name . ' ' . $c->Customer->Family; ?>
                                </span>
                </div>
                <div class="question-body rounr-corner">
                    <?php echo $c->Value; ?>
                </div>
                <?php
                $commentR = new Comment();
                $commentRs = $commentR->FindOneCommentReplies($c->CommentId);
                if ($commentRs != null) {
                    foreach ($commentRs as $cr) {
                        ?>
                        <div class="answer-body rounr-corner">
                            <i class="user-comment-ico"></i>
                            <div class="user-replay-header">
                                <div class="auther">
                                    <h5>
                                        <?php echo $cr->Customer->Name . ' ' . $cr->Customer->Family; ?>
                                    </h5>
                                    <time>
                                        <?php echo $cr->Date; ?>
                                    </time>
                                </div>
                            </div>

                            <div class="horizontal-line"></div>
                            <div class="user-replay-content">
                                <label>
                                    پاسخ :
                                </label>
                                <p>
                                    <?php
                                    echo $cr->Value;
                                    ?>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
            <div class="answer-op">
                <a onclick="<?php
                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {

                } else {
                    echo 'loginFirst()';
                }
                ?>" href="
                               <?php
                if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) == TRUE && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
                    echo "Answer.php?commentId=$c->CommentId&productId=$product->ProductId";
                } else {
                    echo '#';
                }
                ?>">
                                <span class="arrow-left">
                                </span>
                    به این پرسش پاسخ دهید
                </a>
            </div>

            <?php
            $t++;
        }
    }
    $pp2++;
}

if ($t == 0) {
    echo '<div class="CommentText">';
    echo "پرسشی ثبت نشده است .";
    echo '</div>';
}
?>
<?php
if ($pages != 1 && $comments != null) { ?>
    <div class="Pager2">
        <a class="page-link" id="1" href="#faq">صفحه اول</a>
        <?php
        $s = 1;
        if ($_SESSION[SESSION_INT_CURRENT_PAGE] > 3) {
            for ($j = $_SESSION[SESSION_INT_CURRENT_PAGE] - 30; $j <= $pages; $j++) {
                if ($j <= $_SESSION[SESSION_INT_CURRENT_PAGE] + 30) {
                    echo ' <a href="#faq" id="' . $j . '"  class="page-link  ';
                    if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE]) {
                        echo ' Selected "';
                    } else {
                        echo '"';
                    }
                    echo 'page=' . $j . ' " >' . $j . '</a>';
                } else {

                }
                if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE] + 3) {
                    echo ' <span >...</span>';
                }
            }
        } else {
            for ($j = 1; $j <= $pages; $j++) {
                if ($j <= 5) {
                    echo ' <a id="' . $j . '"  class="page-link  ';
                    if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE]) {
                        echo ' Selected "';
                    } else {
                        echo '"';
                    }
                    echo ' href="#faq">' . $j . '</a>';
                }
                if ($j == 5) {
                    echo ' <span >...</span>';
                }
            }
        }
        ?>
        <a id="<?php echo $pages; ?>" class="page-link" href="#faq">آخرین صفحه</a>
    </div>
    <?php
}
?>
