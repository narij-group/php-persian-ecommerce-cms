<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
$discount = new Discount();
if (isset($_GET['id'])) {
    if ($role->EditDiscount != 1) {
        header('Location:Index.php');
        die();
    }
    $dds = new DiscountDataSource();
    $dds->open();
    $discount = $dds->FindOneDiscountBasedOnId($_GET['id']);
    $dds->close();
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>تخفیف</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Discount</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Discounts.php?id=<?php echo $_SESSION[SESSION_INT_PRODUCT_ID]; ?>">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست تخفیف ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            تخفیف
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-warning">
                                توجه : درصد تخفیف محصول را بدون علامت % وارد نمایید .
                            </div>
                            <div class="Inputs">
                                <form action="operateDiscount.php" method="post">
                                    <input type="hidden" id="id" name="id"
                                           value="<?php echo $discount->DiscountId; ?>"/>
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">
                                                درصد تخفیف :
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="Text" class="form-control input-sm m-b-xs" id="value"
                                                       name="value"
                                                       value="<?php echo $discount->Value; ?>"/>
                                            </div>
                                            <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user"
                                                   name="user"/>
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
