<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FeedDataSource.inc';

$fds = new FeedDataSource();
$fds->open();
$feeds = $fds->Fill();
$fds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->Feeds != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';
?>

<!--<script language="JavaScript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>-->
<script>
    $(document).ready(function () {
        <?php
        if(isset($_SESSION[SESSION_BOOL_FEED_EMAIL_SENT]) && $_SESSION[SESSION_BOOL_FEED_EMAIL_SENT] != false){
        ?>
//        $("#email-success").fadeIn(250);
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            positionClass: 'toast-top-left',
            preventDuplicates: false,
            timeOut: 5000
        };
        toastr.success('ارسال ایمیل برای کاربران عضو خبرنامه موفقیت آمیز بود!', 'ایمیل');
        setTimeout(function () {
            $("#email-success").fadeOut(250);
        }, 5000);
        <?php
        $_SESSION[SESSION_BOOL_FEED_EMAIL_SENT] = false;
        }
        ?>

        <?php
        if(isset($_SESSION[SESSION_BOOL_CUSTOMER_EMAIL_SENT]) && $_SESSION[SESSION_BOOL_CUSTOMER_EMAIL_SENT] != false){
        ?>
//        $("#email-success").fadeIn(250);
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            positionClass: 'toast-top-left',
            preventDuplicates: false,
            timeOut: 5000
        };
        toastr.success('ارسال ایمیل برای مشتری ها موفقیت آمیز بود!', 'ایمیل');
        setTimeout(function () {
            $("#email-success").fadeOut(250);
        }, 5000);
        <?php
        $_SESSION[SESSION_BOOL_CUSTOMER_EMAIL_SENT] = false;
        }
        ?>

    });
</script>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>خبرنامه</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Feeds</h2>
    </div>
</div>

<!--<div class="success-message" id="email-success">ارسال ایمیل موفقیت آمیز بود!</div>-->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست خبرنامه</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertFeed == 1) {
                        ?>
                        <a href="Feed.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن خبرنامه جدید
                            </button>
                        </a>
                        <?php
                    }

                    if ($role->FeedSendEmail == 1) {
                        ?>
                        <a href="FeedEmail.php">
                            <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-at"></i>
                                ارسال ایمیل دلخواه
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <div class="Database">

                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                               placeholder="جستجو در لیست موجود در این صفحه">
                        <table class="footable table table-stripped" data-page-size="1000000000"
                               data-filter=#filter>
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th> پست الکترونیک</th>
                                <?php
                                if ($role->EditFeed == 1) {
                                    ?>
                                    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                if ($role->DeleteFeed == 1) {
                                    ?>
                                    <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                                    <?php
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $postsCounter = 0;
                            foreach ($feeds as $s) {
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >" . $s->FeedId . "</div></td>";
                                echo "<td><div class='DatabaseField' >" . $s->Email . "</div></td>";
                                if ($role->EditFeed == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='Feed.php?id=" . $s->FeedId . "'>" . "ویرایش" . "</a></button></td>";
                                }
                                if ($role->DeleteFeed == 1) {
                                    echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a  onclick='return deleteConfirm()' href='operateFeed.php?id=" . $s->FeedId . "'>" . "حذف" . "</a></button></td>";
                                }
                                echo "</tr>";
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
                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
    