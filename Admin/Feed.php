<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FeedDataSource.inc';
$feed = new Feed();
if (isset($_GET['id'])) {
    if ($role->EditFeed != 1) {
        header('Location:Index.php');
        die();
    }
    $fds = new FeedDataSource();
    $fds->open();
    $feed = $fds->FindOneFeedBasedOnId($_GET['id']);
    $fds->close();

} else {
    if ($role->InsertFeed != 1) {
        header('Location:Index.php');
        die();
    }
}


include_once 'Template/menu.php';
?>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-6">
            <h2>خبرنامه</h2>
        </div>
        <div class="col-lg-6 title-en">
            <h2>Feed</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <a href="Feeds.php">
                            <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                                لیست خبرنامه ها
                            </button>
                        </a>

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                خبرنامه
                            </div>
                            <div class="panel-body">

                                <div class="Inputs">

                                    <form action="operateFeed.php" method="post">
                                        <input type="hidden" id="id" name="id"
                                               value="<?php echo $feed->FeedId; ?>"/>
                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    ایمیل :
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="Text" class="form-control input-sm m-b-xs" id="email" name="email"
                                                           value="<?php echo $feed->Email; ?>"/>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                    class="fa fa-check"></i><strong>تایید</strong></button>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

<?php
include_once 'Template/bottom.php';
