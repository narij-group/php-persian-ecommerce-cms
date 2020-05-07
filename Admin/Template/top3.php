<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Globals/Sessions.php';

if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
}

//$u1 = new User();
//$u1->UserId = $_COOKIE[COOKIE_MY_USER_ID];
//$user1 = $u1->FindOneUser();

include_once __DIR__ . DIRECTORY_SEPARATOR . '../../ClassesEx/datasource/UserDataSource.inc';
$uds = new UserDataSource();
$uds->open();
$user1 = $uds->FindOneUserBasedOnId($_COOKIE[COOKIE_MY_USER_ID]);
$uds->close();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../../ClassesEx/datasource/RoleDataSource.inc';
$r = new RoleDataSource();
$r->open();
//$r->RoleId = $user1->Role;
$role = $r->FindOneRoleBasedOnId($user1->Role);
$r->close();


require_once __DIR__ . DIRECTORY_SEPARATOR . '../../ClassesEx/datasource/SettingsDataSource.inc';
$setting = new SettingsDataSource();
$setting->open();
$settings = $setting->Fill();
$setting->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>پنل کاربری</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../<?php echo $settings->ILogo; ?>"/>


    <?php
//    require_once "../Template/MobileDetect/Mobile_Detect.php";
//    $detect = new Mobile_Detect();
//    if ($detect->isMobile() && !$detect->isTablet()) {
        //-------------MOBILES STYLE----------------------
        ?>
<!--        <link href="Template/Styles/MobileStyle.css" rel="stylesheet"/>-->
<!--        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>-->
        <?php
//    } else {
        //-------------PC STYLE----------------------
        ?>
        <!--            <link href="Template/Styles/MobileStyle.css" rel="stylesheet"/>-->

        <?php
//    }
    ?>

    <link href="Template/Styles/AdminStyle.css" rel="stylesheet" type="text/css"/>

    <meta charset="UTF-8"/>
    <script type="text/javascript">
        function deleteConfirm() {
            return confirm("آیا میخواهید این رکورد را حذف کنید ؟");
        }

        function deleteConfirmUser() {
            return confirm("آیا میخواهید این کاربر را حذف کنید ؟ اگر این کاربر را حذف کنید تمامی محصولات و ... که به سایت اضافه کرده است نیز حذف خواهند شد.");
        }
    </script>
    <script>
        function FormatCurrency(ctrl) {
            //Check if arrow keys are pressed - we want to allow navigation around textbox using arrow keys
            if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40) {
                return;
            }

            var val = ctrl.value;

            val = val.replace(/,/g, "")
            ctrl.value = "";
            val += '';
            x = val.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';

            var rgx = /(\d+)(\d{3})/;

            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }

            ctrl.value = x1 + x2;
        }

        function CheckNumeric() {
            return event.keyCode >= 48 && event.keyCode <= 57;
        }

    </script>
    <script src="Template/Scripts/jquery-1.9.1.min.js" type="text/javascript"></script>

    <script src="Scripts/jquery-2.2.0.js" type="text/javascript"></script>
    <script src="Template/Scripts/jquery-2.1.1.js"></script>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="Template/Styles/bootstrap.min.css" rel="stylesheet">
    <link href="Template/Styles/bootstrap-rtl.min.css" rel="stylesheet">
    <link href="Template/Styles/font-awesome.css" rel="stylesheet">

    <link href="Template/Styles/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="Template/Styles/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="Template/Styles/animate.css" rel="stylesheet">
    <link href="Template/Styles/style.css" rel="stylesheet">