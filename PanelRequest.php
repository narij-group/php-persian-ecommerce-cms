<?php
include_once 'Template/top.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PanelDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CustomerDataSource.inc';

$customer = new Customer();
if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
    $cds = new CustomerDataSource();
    $cds->open();
    $customer = $cds->FindOneCustomerBasedOnId($_COOKIE[COOKIE_CUSTOMER_ID]);
    $cds->close();
}
?>
    <title>درخوسات پنل فروش</title>
    <meta name="description" content="درخوسات پنل فروش"/>

<?php
include_once 'Template/menu.php';
//echo date("Y/m/d");
?>
    <div class="container">
        <div class="main-container">
            <!--Main Content-->
            <div class="text-view">
                <?php
                if (isset($_GET["status"]) && $_GET["status"] == "OK") {
                    echo '<div class="success-order">درخواست شما با موفقیت ثبت شد</div>';
                }
                ?>

                <header style="background: #d9edf6;border-color: #bce8f1;color: #245269">
                    درخوات پنل فروش
                </header>

                    <div class="panel-form">
                        <form method="post" action="InsertPanel.php">
                            <input required type="text" name="name" id="name " placeholder="نام و نام خانوادگی..."
                                   value="<?php if ($customer->Name != "") {
                                       echo $customer->Name . ' ' . $customer->Family;
                                   } ?>"/>
                            <input required type="text" name="email" id="email" placeholder="آدرس ایمیل..."
                                   value="<?php echo $customer->Email; ?>"/>
                            <input required type="text" name="mobile" id="mobile" value="<?php echo $customer->Mobile; ?>" placeholder="موبایل..."/>
                            <textarea required name="content" id="content" placeholder="متن..."></textarea>
                            <input type="submit" value="ارسال"/>
                        </form>
                    </div>

            </div>
        </div>
    </div>

<?php
include_once "Template/bottom.php";
