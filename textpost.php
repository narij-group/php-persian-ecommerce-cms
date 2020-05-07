<?php
include_once 'Template/top.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/LinkBoxDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/CustomerDataSource.inc';
$l = new LinkBoxDataSource();
$l->open();
$linkbox = $l->FindOneLinkBoxBasedOnId($_GET['fid']);
$l->close();
$customer = new Customer();
if (isset($_COOKIE[COOKIE_CUSTOMER_ID]) && $_COOKIE[COOKIE_CUSTOMER_ID] != 0) {
    $cds = new CustomerDataSource();
    $cds->open();
    $customer = $cds->FindOneCustomerBasedOnId($_COOKIE[COOKIE_CUSTOMER_ID]);
    $cds->close();
}

?>
    <title><?php echo $settings->SiteName . '-' . $linkbox->Name; ?></title>
    <meta name="description" content="<?php echo $linkbox->Name; ?>"/>
<?php
include_once 'Template/menu.php';
//echo date("Y/m/d");
?>
    <div class="container">
        <div class="main-container">
            <!--Main Content-->
            <div class="text-view">
                <?php
                echo $linkbox->Content;
                ?>

                <?php
                if ($linkbox->HaveForm == 1) {
                    ?>
                    <div class="contact-form">
                        <form method="post" action="Contact.php">
                            <input type="text" name="name" id="name " placeholder="نام و نام خانوادگی..."
                                   value="<?php if ($customer->Name != "") {
                                       echo $customer->Name . ' ' . $customer->Family;
                                   } ?>"/>
                            <input type="text" name="email" id="email" placeholder="آدرس ایمیل..."
                                   value="<?php echo $customer->Email; ?>"/>
                            <input type="text" name="subject" id="subject" placeholder="موضوع..."/>
                            <textarea name="value" id="value" placeholder="متن..."></textarea>
                            <input type="submit" value="ارسال"/>
                        </form>
                    </div>
                    <?php
                }

                ?>

            </div>
        </div>
    </div>
<?php
include_once "Template/bottom.php";
