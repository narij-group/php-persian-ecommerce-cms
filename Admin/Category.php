<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CategoryDataSource.inc';
$category = new Category();
if (isset($_GET['id'])) {
    $c = new CategoryDataSource();
    $c->open();
    $category = $c->FindOneCategoryBsedOnId($_GET['id']);
    $c->close();
}
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>دسته بندی</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Category</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Categories.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست دسته بندی ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            دسته بندی
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <form action="operateUserCoupon.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $userCoupon->UserCouponId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                نام :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="name"
                                                       name="name"
                                                       value="<?php echo $category->Name; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                شاخص :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="parent"
                                                       name="parent"
                                                       value="<?php echo $category->Parent; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                توضیحات :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="description"
                                                       name="description"
                                                       value="<?php echo $category->Description; ?>"/>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user"
                                               name="user"/>
                                    </fieldset>
                                    <!--                                        <input type="submit" class="Save" value=""/>-->
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
