<?php
require_once __DIR__ .DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/CustomerDataSource.inc';
$c = new CustomerDataSource();
$c ->open();
$error = false;
if (isset($_POST['email'])) {
    if ($c->IsEmailAllowed($_POST['email']) == 1 && trim($_POST['email']) != "" && strpos($_POST['email'], '@') != false) {
        echo '<img src="Template/Images/Plugins/available.png" alt=""/>';
    } elseif (trim($_POST['email']) == "") {
        echo '';
    } else {
        $error = true;
        echo '<img src="Template/Images/Plugins/unavailable.png" alt=""/>';
    }
} elseif (isset($_POST['username2'])) {
    if (trim($_POST['username2']) == 'admin') {
        $error = true;
        echo '<img src="Template/Images/Plugins/unavailable.png" alt=""/>';
    } elseif ($c->IsUsernameAllowed($_POST['username2']) == 1 && trim($_POST['username2']) != "") {
        echo '<img src="Template/Images/Plugins/available.png" alt=""/>';
    } elseif (trim($_POST['username2']) == "") {
        echo '';
    } else {
        $error = true;
        echo '<img src="Template/Images/Plugins/unavailable.png" alt=""/>';
    }
} elseif (isset($_POST['ncode'])) {
    if ($c->IsNCodeAllowed($_POST['ncode']) == 1 && trim($_POST['ncode']) != "" && strlen($_POST['ncode']) == 10) {
        echo '<img src="Template/Images/Plugins/available.png" alt=""/>';
    } elseif (trim($_POST['ncode']) == "") {
        echo '';
    } else {
        $error = true;
        echo '<img src="Template/Images/Plugins/unavailable.png" alt=""/>';
    }
}
?>
<script>
    $(document).ready(function () {
        <?php
        if($error){
        ?>
//        $('#register-button').attr('disabled', '');
        <?php
        }
        ?>


        <?php
        if(!$error){
        ?>
//        $('#register-button').removeAttr('disabled');
        <?php
        }
        ?>
    });
</script>
