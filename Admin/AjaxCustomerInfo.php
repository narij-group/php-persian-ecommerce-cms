<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProvinceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';
$province = new ProvinceDataSource();
$province->open();
$city = new CityDataSource();
$city->open();

$customer = new CustomerDataSource();
$customer->open();
$c = $customer->FindOneCustomerBasedOnId($_POST['customerId']);
$customer->close();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                class="sr-only">Close</span></button>
    <span class="label label-primary">Customer INFO</span>
    <div class="clear-fix"></div>

    <img class="c-image" src="../Template/Images/user.png" alt=""/>

    <span class="p-id label label-warning"
          style="font-size: 17px;height: 30px;line-height: 22px"><?php echo $c->CustomerId; ?></span>
    <div class="p-name"><?php echo $c->Name . " " . $c->Family; ?></div>
    <div class="p-tell"><?php echo $c->Phone . " | " . $c->Mobile; ?></div>
</div>
<div class="modal-body">
    <div class="p-user"><span class="p-span label-success">نام کاربری : </span><span
                class="p-span-2 label-info"><?php echo $c->Username; ?></span>
    </div>
    <div class="p-brand"><span class="p-span label-success">رمزعبور : </span><span
                class="p-span-2 label-info"><?php echo $c->Password; ?></div>
    <div class="p-user"><span class="p-span label-success">کد ملی  : </span><span
                class="p-span-2 label-info"><?php echo $c->NationalityCode; ?></span></div>
    <div class="p-user"><span class="p-span label-success">آدرس ایمیل :</span><span
                class="p-span-2 label-info"><?php echo $c->Email; ?></span></div>
    <div class="p-user"><span class="p-span label-success">استان : </span><span
                class="p-span-2 label-info"><?php echo $province->GetName($c->Estate); ?></span></div>
    <div class="p-user"><span class="p-span label-success">شهر : </span><span
                class="p-span-2 label-info"><?php echo $city->GetName($c->City); ?></span></div>
    <div class="p-user"><span class="p-span label-success">کد پستی : </span><span
                class="p-span-2 label-info"><?php echo $c->PostCode; ?></span>
    </div>
    <div class="p-cat"><span class="p-span label-success">آدرس : </span><span
                class="p-span-2 label-info"><?php echo $c->Address ?></span></div>
    <div class="p-cat"><span class="p-span label-success">آخرین آی پی : </span><span
                class="p-span-2 label-info"><?php echo $c->IP ?></span></div>

</div>
<div class="info-buttons" style="float: left; margin-left: 50px;">
    <?php
    echo "<div class='p-btn Delete' style='float: left;'><a  title='Delete' onclick='return deleteConfirm()' href='DeleteCustomer.php?id=" . $c->CustomerId . "'>" . "" . "</a></div>";
    echo "<div class='p-btn Edit'  style='float: left;' ><a  title='Edit' href='Customer.php?id=" . $c->CustomerId . "'>" . "" . "</a></div>";
    ?>
</div>

<div class="modal-footer">
    <div class="info-buttons">
        <?php
        echo "<a  title='Delete' class='btn btn-danger btn-w-m' onclick='return deleteConfirm()' href='DeleteCustomer.php?id=" . $c->CustomerId . "'>" . "حذف" . "</a>";
        echo "<a  title='Edit' class='btn btn-warning btn-w-m' href='Customer.php?id=" . $c->CustomerId . "'>" . "ویرایش" . "</a>";
        ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">بستن</button>
</div>

