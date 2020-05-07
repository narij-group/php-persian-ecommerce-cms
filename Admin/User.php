<!DOCTYPE html>
<?php
include_once 'Template/top.php';
$cm = "add";
include_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserDataSource.inc';


$role2 = new RoleDataSource();
$role2->open();
$roles = $role2->Fill();
$role2->close();
$user = new User();
if (isset($_GET['id'])) {
    if ($role->EditUser != 1 && $_GET['id'] != $user1->UserId) {
        header('Location:Index.php');
        die();
    }
    $cm = "edit";

    $uds = new UserDataSource();
    $uds->open();

    $user = $uds->FindOneUserBasedOnId($_GET['id']);
    $uds->close();

} else {
    if ($role->InsertUser != 1) {
        header('Location:Index.php');
        die();
    }
}
?>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<?php
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>کاربر</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>User</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Users.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست کاربر ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            کاربر
                        </div>
                        <div class="panel-body">

                            <div class="Inputs">
                                <form action="operateUser.php" method="post">
                                    <input type="hidden" id="id" name="id" value="<?php echo $user->UserId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name" name="name"
                                                       value="<?php echo $user->Name; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام خانوادگی :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="family" name="family"
                                                       value="<?php echo $user->Family; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                پست الکترونیک :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="email" name="email"
                                                       value="<?php echo $user->Email; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام کاربری :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="username" name="username"
                                                       value="<?php echo $user->Username; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                رمز عبور :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="password" class="form-control input-sm m-b-xs" id="password"
                                                       name="password"
                                                       value="<?php echo $user->Password; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group"
                                        <?php
                                        if ($role->EditUser != 1) {
                                            echo " style='display:none'; ";
                                        }
                                        ?>">
                                        <label class="col-sm-12 control-label">
                                            نقش کاربر
                                        </label>
                                        <div class="col-sm-12">
                                            <?php
                                            echo "<select  class='form-control m-b' name='role' id='role' >";
                                            foreach ($roles as $r) {
                                                echo "<option ";
                                                if ($r->RoleId == $user->Role) {
                                                    echo ' selected ';
                                                }
                                                echo " value='$r->RoleId'>$r->Name</option>";
                                            }
                                            echo "</select>";
                                            ?>
                                        </div>
                            </div>

                            <div class="form-group"
                                <?php
                                if ($role->EditUser != 1) {
                                    echo " style='display:none'; ";
                                }
                                ?>>
                                <label class="col-sm-12 control-label pull-right">

                                </label>
                                <div class="col-sm-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12 control-label">
                                    وضعیت :
                                </label>
                                <div class="col-sm-12">
                                    <div class="radio radio-danger">
                                        <input type="radio" <?php
                                        if ($user->Activate == 1) {
                                            echo ' checked ';
                                        }
                                        ?> id="s-option" name="activate" value="1">
                                        <label for="s-option">
                                            فعال
                                        </label>
                                    </div>

                                    <div class="radio radio-danger">
                                        <input type="radio" <?php
                                        if ($user->Activate == 0) {
                                            echo ' checked ';
                                        }
                                        ?> id="f-option" name="activate" value="0">
                                        <label for="f-option">
                                            غیرفعال
                                        </label>
                                    </div>
                                    <div class="clear-fix"></div>
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
