<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/BillDataSource.php';
$fp = new FactorProductDataSource();
$fp->open();
$fps = $fp->FillByCode($_POST['code']);
foreach ($fps as $f) {
    $factorproduct = $fp->FindOneFactorProductBasedOnId($f->FactorProductId);
}
$fp->close();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span
                aria-hidden="true">&times;</span><span
                class="sr-only">Close</span></button>
    <h4 class="modal-title"><i class="fa fa-file-text-o text-primary m-xs"></i>اطلاعات فیش بانکی
    </h4>
</div>
<div class="modal-body">
    <span class="p-span label label-warning" style="font-size: 17px;">
        <?php

        $bill = new BillDataSource();
        $bill->open();
        $b = $bill->FindByCode($_POST['code']);
        if ($b != null) {
            if ($b->Status == 0) {
                echo "در انتظار ارائه فیش";
            } elseif ($b->Status == 1) {
                echo "در انتظار بررسی";
            } elseif ($b->Status == 2) {
                echo "تایید شد";
            } elseif ($b->Status == 3) {
                echo "رد شده";
            }
        }
        ?>
    </span>
    <br>
    <br>

    <div class="customer-info">
        <div>
            <?php
            echo "<span class='p-span label label-warning' style='font-size: 18px;'>" . '<i class="fa fa-user text-primary m-xs" style="padding-right: 5px;padding-left: 5px;"></i>' . $factorproduct->Factor->Customer->Name . " " . $factorproduct->Factor->Customer->Family . "  " . $factorproduct->Factor->Customer->Mobile . "</span>";
            ?>
        </div>
    </div>
    <br>
    <div class="inputs">
        <fieldset class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" readonly placeholder="تاریخ..." class="form-control input-sm m-b-xs"
                           value="<?php echo $b->Date; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" readonly placeholder="شماره فیش..." class="form-control input-sm m-b-xs"
                           value="<?php echo $b->Code; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" readonly placeholder="بانک..." class="form-control input-sm m-b-xs"
                           value="<?php echo $b->Bank; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <textarea readonly placeholder="توضیحات..."
                              class="form-control input-sm m-b-xs"
                              style="height: 85px"><?php echo $b->Comment; ?></textarea>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="modal-footer">
    <a href="UpdateBill.php?code=<?php echo $_POST['code']; ?>&request=declined">
        <button type="button" class="btn btn-danger">رد کردن
        </button>
    </a>
    <a href="UpdateBill.php?code=<?php echo $_POST['code']; ?>&request=approved">
        <button type="button" id="delete-confirm-btn" class="btn btn-primary">تایید کردن
        </button>
    </a>
</div>
