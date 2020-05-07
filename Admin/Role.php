<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/RoleDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LogoDataSource.inc';
require_once 'Template/top.php';
$role2 = new Role();
$cm = "add";
if (isset($_GET['id'])) {
    if ($role->EditRole != 1) {
        header('Location:Index.php');
        die();
    }
    $cm = "edit";
    $s = new RoleDataSource();
    $s->open();
    $role2 = $s->FindOneRoleBasedOnId($_GET['id']);
    $s->close();
} else {
    if ($role->InsertRole != 1) {
        header('Location:Index.php');
        die();
    }
}


?>
    <script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<?php
include_once 'Template/menu.php';
$_SESSION[SESSION_STRING_SELECTED_GROUPS] = "";
$_SESSION[SESSION_STRING_SELECTED_SUB_GROUPS] = "";
$_SESSION[SESSION_STRING_P_P_SELECTED_GROUPS] = "";
$_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS] = "";
?>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-6">
            <h2>نقش</h2>
        </div>
        <div class="col-lg-6 title-en">
            <h2>Role</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <a href="Roles.php">
                            <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                                لیست نقش ها
                            </button>
                        </a>

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                نقش
                            </div>
                            <div class="panel-body">

                                <style>
                                    .checkboxFour input, .checkboxFour2 input {
                                        font-size: 0;
                                    }

                                    .checkboxFour, .checkboxFour2 {
                                        z-index: 1;

                                        width: 25px;
                                        height: 25px;
                                        padding-top: 5px;
                                        padding-right: 5px;

                                        background: #ddd;
                                        border-radius: 100%;
                                        float: right;
                                        position: relative;
                                    }

                                    .checkboxFour label, .checkboxFour2 label {
                                        display: block;
                                        width: 26px;
                                        height: 26px;
                                        border-radius: 100px;

                                        transition: all .5s ease;
                                        cursor: pointer;
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        z-index: 999;

                                        background: #333;
                                    }

                                    .checkboxFour input[type=checkbox]:checked + label, .checkboxFour2 input[type=checkbox]:checked + label {
                                        background: #26ca28;
                                    }
                                </style>
                                <script>
                                    $(document).ready(function () {
                                        $('#products').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#products-options').slideDown(500);
                                            }
                                            else {
                                                $('.p-check').prop('checked', false);
                                                $('#product-groups').html('');
                                                $('#product-subgroups').html('');
                                                $('#product-suppergroups').html('');
                                                $('#products-options').slideUp(500);
                                                <?php
                                                $_SESSION[SESSION_STRING_SELECTED_GROUPS] = "";
                                                $_SESSION[SESSION_STRING_SELECTED_SUB_GROUPS] = "";
                                                ?>
                                            }
                                        });

                                        $('#users').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#users-options').slideDown(500);
                                            }
                                            else {
                                                $('.user-check').prop('checked', false);
                                                $('#users-options').slideUp(500);
                                            }
                                        });


                                        $('#usercoupons').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#usercoupons-options').slideDown(500);
                                            }
                                            else {
                                                $('.usercoupon-check').prop('checked', false);
                                                $('#usercoupons-options').slideUp(500);
                                            }
                                        });


                                        $('#factorproducts').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#factorproducts-options').slideDown(500);
                                            }
                                            else {
                                                $('.factorproduct-check').prop('checked', false);
                                                $('#factorproducts-options').slideUp(500);
                                            }
                                        });

                                        $('#orders').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#orders-options').slideDown(500);
                                            }
                                            else {
                                                $('.orders-check').prop('checked', false);
                                                $('#orders-options').slideUp(500);
                                            }
                                        });

                                        $('#panels').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#panels-options').slideDown(500);
                                            }
                                            else {
                                                $('.panels-check').prop('checked', false);
                                                $('#panels-options').slideUp(500);
                                            }
                                        });


                                        $('#productcoupons').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#productcoupons-options').slideDown(500);
                                            }
                                            else {
                                                $('.productcoupon-check').prop('checked', false);
                                                $('#productcoupons-options').slideUp(500);
                                            }
                                        });

                                        $('#shippingmethods').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#shippingmethods-options').slideDown(500);
                                            }
                                            else {
                                                $('.shippingmethod-check').prop('checked', false);
                                                $('#shippingmethods-options').slideUp(500);
                                            }
                                        });
                                        $('#shippings').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#shippings-options').slideDown(500);
                                            }
                                            else {
                                                $('.shipping-check').prop('checked', false);
                                                $('#shippings-options').slideUp(500);
                                            }
                                        });
                                        $('#linkboxes').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#linkboxes-options').slideDown(500);
                                            }
                                            else {
                                                $('.linkbox-check').prop('checked', false);
                                                $('#linkboxes-options').slideUp(500);
                                            }
                                        });
                                        $('#specialoffers').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#specialoffers-options').slideDown(500);
                                            }
                                            else {
                                                $('.specialoffer-check').prop('checked', false);
                                                $('#specialoffers-options').slideUp(500);
                                            }
                                        });
                                        $('#slides').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#slides-options').slideDown(500);
                                            }
                                            else {
                                                $('.slide-check').prop('checked', false);
                                                $('#slides-options').slideUp(500);
                                            }
                                        });
                                        $('#thumbs').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#thumbs-options').slideDown(500);
                                            }
                                            else {
                                                $('.thumb-check').prop('checked', false);
                                                $('#thumbs-options').slideUp(500);
                                            }
                                        });
                                        $('#prices').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#prices-options').slideDown(500);
                                            }
                                            else {
                                                $('.price-check').prop('checked', false);
                                                $('#prices-options').slideUp(500);
                                            }
                                        });
                                        $('#comments').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#comments-options').slideDown(500);
                                            }
                                            else {
                                                $('.comment-check').prop('checked', false);
                                                $('#comments-options').slideUp(500);
                                            }
                                        });
                                        $('#discounts').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#discounts-options').slideDown(500);
                                            }
                                            else {
                                                $('.discount-check').prop('checked', false);
                                                $('#discounts-options').slideUp(500);
                                            }
                                        });
                                        $('#brands').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#brands-options').slideDown(500);
                                            }
                                            else {
                                                $('.brand-check').prop('checked', false);
                                                $('.brandlist-check').prop('checked', false);
                                                $('#brands-options').slideUp(500);
                                            }
                                        });
                                        $('#customers').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#customers-options').slideDown(500);
                                            }
                                            else {
                                                $('.customer-check').prop('checked', false);
                                                $('#customers-options').slideUp(500);
                                            }
                                        });
                                        $('#productproperties').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#productproperties-options').slideDown(500);
                                            }
                                            else {
                                                $('.productproperty-check').prop('checked', false);
                                                $('#productproperty-groups').html('');
                                                $('#productproperty-subgroups').html('');
                                                $('#productproperty-suppergroups').html('');
                                                $('#productproperties-options').slideUp(500);
                                                <?php
                                                $_SESSION[SESSION_STRING_SELECTED_GROUPS] = "";
                                                $_SESSION[SESSION_STRING_SELECTED_SUB_GROUPS] = "";
                                                ?>
                                            }
                                        });
                                        $('#paymentmethods').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#paymentmethods-options').slideDown(500);
                                            }
                                            else {
                                                $('.paymentmethod-check').prop('checked', false);
                                                $('#paymentmethods-options').slideUp(500);
                                            }
                                        });
                                        $('#opinions').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#opinions-options').slideDown(500);
                                            }
                                            else {
                                                $('.opinion-check').prop('checked', false);
                                                $('#opinions-options').slideUp(500);
                                            }
                                        });
                                        $('#feeds').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#feeds-options').slideDown(500);
                                            }
                                            else {
                                                $('.feed-check').prop('checked', false);
                                                $('#feeds-options').slideUp(500);
                                            }
                                        });
                                        $('#news').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#news-options').slideDown(500);
                                            }
                                            else {
                                                $('.news-check').prop('checked', false);
                                                $('#news-options').slideUp(500);
                                            }
                                        });
                                        $('#guarantees').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#guarantees-options').slideDown(500);
                                            }
                                            else {
                                                $('.guarantee-check').prop('checked', false);
                                                $('#guarantees-options').slideUp(500);
                                            }
                                        });
                                        $('#colors').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#colors-options').slideDown(500);
                                            }
                                            else {
                                                $('.color-check').prop('checked', false);
                                                $('#colors-options').slideUp(500);
                                            }
                                        });
                                        $('#services').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#services-options').slideDown(500);
                                            }
                                            else {
                                                $('.service-check').prop('checked', false);
                                                $('#services-options').slideUp(500);
                                            }
                                        });
                                        $('#groups').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#groups-options').slideDown(500);
                                            }
                                            else {
                                                $('.group-check').prop('checked', false);
                                                $('#groups-options').slideUp(500);
                                            }
                                        });
                                        $('#subgroups').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#subgroups-options').slideDown(500);
                                            }
                                            else {
                                                $('.subgroup-check').prop('checked', false);
                                                $('#subgroups-options').slideUp(500);
                                            }
                                        });
                                        $('#suppergroups').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#suppergroups-options').slideDown(500);
                                            }
                                            else {
                                                $('.suppergroup-check').prop('checked', false);
                                                $('#suppergroups-options').slideUp(500);
                                            }
                                        });
                                        $('#roles').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#roles-options').slideDown(500);
                                            }
                                            else {
                                                $('.role-check').prop('checked', false);
                                                $('#roles-options').slideUp(500);
                                            }
                                        });
                                        $('#stats').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#stats-options').slideDown(500);
                                            }
                                            else {
                                                $('.stat-check').prop('checked', false);
                                                $('#stats-options').slideUp(500);
                                            }
                                        });
                                        $('#settings').change(function () {
                                            if ($(this).is(':checked')) {
                                                $('#settings-options').slideDown(500);
                                            }
                                            else {
                                                $('.settings-check').prop('checked', false);
                                                $('#settings-options').slideUp(500);
                                            }
                                        });

                                        $('#productpropertysubgrouplimit').change(function () {
                                            if ($(this).is(':checked')) {

                                            }
                                            else {
                                                $('.ppsuppergroupcheck').prop('checked', false);
                                            }
                                        });

                                        $('#productgrouplimit').change(function () {
                                            if ($(this).is(':checked')) {
                                                $.ajax({
                                                    url: 'AjaxGroupChecks.php',
                                                    type: 'POST',
                                                    data: {<?php
                                                        if (isset($_GET['id'])) {
                                                            echo "roleId : " . $_GET['id'];
                                                        }
                                                        ?>},
                                                    success: function (result) {
                                                        $('#product-groups').html(result);
                                                    }
                                                });
                                            }
                                            else {
                                                $('#product-groups').html('');
                                                $('#product-subgroups').html('');
                                                $('#product-suppergroups').html('');
                                            }
                                        });

                                        $('#productpropertysubgrouplimit').change(function () {
                                            if ($(this).is(':checked')) {
                                                $.ajax({
                                                    url: 'AjaxGroupChecks2.php',
                                                    type: 'POST',
                                                    data: {<?php
                                                        if (isset($_GET['id'])) {
                                                            echo "roleId : " . $_GET['id'];
                                                        }
                                                        ?>},
                                                    success: function (result) {
                                                        $('#productproperty-groups').html(result);
                                                    }
                                                });
                                            }
                                            else {
                                                $('#productproperty-groups').html('');
                                                $('#productproperty-subgroups').html('');
                                                $('#productproperty-suppergroups').html('');
                                            }
                                        });

                                        $('#brandlimit').change(function () {
                                            if ($(this).is(':checked')) {
                                                $.ajax({
                                                    url: 'AjaxLogoChecks.php',
                                                    type: 'POST',
                                                    data: {<?php
                                                        if (isset($_GET['id'])) {
                                                            echo "roleId : " . $_GET['id'];
                                                        }
                                                        ?>},
                                                    success: function (result) {
                                                        $('#brandslist').html(result);
                                                    }
                                                });
                                            }
                                            else {
                                                $('#brandslist').html('');
                                            }
                                        });

                                    });
                                </script>
                                <div class="Inputs">
                                    <?php
                                    if ($cm == "add") {
                                    ?>
                                    <form action="InsertRole.php" method="post">
                                        <?php
                                        } elseif ($cm == "edit") {
                                        ?>
                                        <form action="UpdateRole.php" method="post">

                                            <input type="hidden" id="id" name="id"
                                                   value="<?php echo $role2->RoleId; ?>"/>
                                            <?php
                                            }
                                            ?>

                                            <fieldset class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-12 control-label">
                                                        نام نقش:
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <input type="Text" class="FullWidthText" id="name" name="name"
                                                               value="<?php echo $role2->Name; ?>"/></td>
                                                    </div>
                                                </div>
                                            </fieldset>


                                            <table>
                                                <tr>
                                                    <td></td>
                                                    <td class="options">
                                                        <div class="title2">دسترسی ها</div>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="products">جدول
                                                                    محصولات</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Products == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="products" name="products"/><label
                                                                            for='products'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="products-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertproduct">افزودن
                                                                        محصول</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="p-check" <?php
                                                                        if ($role2->InsertProduct == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertproduct"
                                                                                                     name="insertproduct"/><label
                                                                                for='insertproduct'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editproduct">ویرایش
                                                                        محصول</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="p-check" <?php
                                                                        if ($role2->EditProduct == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editproduct" name="editproduct"/><label
                                                                                for='editproduct'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteproduct">حذف
                                                                        محصول</label>
                                                                    <div class='checkboxFour'><input class="p-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteProduct == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteproduct"
                                                                                                     name="deleteproduct"/><label
                                                                                for='deleteproduct'></label></div>
                                                                </div>
                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="productapprove">نیاز
                                                                        به تایید جهت
                                                                        فعالسازی
                                                                    </label>
                                                                    <div class='checkboxFour'><input class="p-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->ProductApprove == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="productapprove"
                                                                                                     name="productapprove"/><label
                                                                                for='productapprove'></label></div>
                                                                </div>
                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="productgrouplimit">محدود
                                                                        کردن دسترسی
                                                                        به دسته بندی ها</label>
                                                                    <div class='checkboxFour'><input class="p-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->ProductGroupLimit == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="productgrouplimit"
                                                                                                     name="productgrouplimit"/><label
                                                                                for='productgrouplimit'></label></div>
                                                                </div>
                                                            </div>
                                                            <div id="product-groups" style="display:block;">
                                                                <?php
                                                                if ($role2->ProductGroupLimit == 1) {
                                                                    $group3 = new GroupDataSource();
                                                                    $group3->open();
                                                                    $groups = $group3->Fill();
                                                                    $i = 0;
                                                                    foreach ($groups as $g) {
                                                                        if (($i % 3) == 0) {
                                                                            echo '<br>';
                                                                        }
                                                                        ?>
                                                                        <div class="check-option"><label
                                                                                    class="check-text"
                                                                                    for="g<?php echo $g->GroupId; ?>"><?php echo $g->Name; ?></label>
                                                                            <div class='checkboxFour'><input
                                                                                        class="groupcheck"
                                                                                        type="checkbox" <?php
                                                                                $pos = strpos($role2->AllowedProductGroups, $g->GroupId);
                                                                                if ($pos != FALSE) {
                                                                                    echo ' checked ';
                                                                                }
                                                                                ?> id="g<?php echo $g->GroupId; ?>"
                                                                                        name="groupcheck_list[]"
                                                                                        value="<?php echo $g->GroupId; ?>"/><label
                                                                                        for='g<?php echo $g->GroupId; ?>'></label>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                            <div id="product-subgroups" style="display:block;">
                                                                <?php
                                                                if (trim($role2->AllowedProductGroups) != "" && trim($role2->AllowedProductGroups) != ",") {
                                                                    $groupIds = explode(",", $role2->AllowedProductGroups);
                                                                    foreach ($groupIds as $gid) {
                                                                        if (trim($gid) != "") {
                                                                            $subgroup3 = new SubGroupDataSource();
                                                                            $subgroup3->open();
                                                                            $subgroups = $subgroup3->FillByGroup($gid);
                                                                            $subgroup3->close();
                                                                            $i = 0;
                                                                            foreach ($subgroups as $sg) {
                                                                                if (($i % 3) == 0) {
                                                                                    echo '<br>';
                                                                                }
                                                                                ?>
                                                                                <div class="check-option"><label
                                                                                            class="check-text"
                                                                                            for="sg<?php echo $sg->SubGroupId; ?>"><?php echo $sg->Name; ?></label>
                                                                                    <div class='checkboxFour'><input
                                                                                                class="subgroupcheck"
                                                                                                type="checkbox" <?php
                                                                                        $pos = strpos($role2->AllowedProductSubGroups, $sg->SubGroupId);
                                                                                        if ($pos != FALSE) {
                                                                                            echo ' checked ';
                                                                                        }
                                                                                        ?>
                                                                                                id="sg<?php echo $sg->SubGroupId; ?>"
                                                                                                name="subgroupcheck_list[]"
                                                                                                value="<?php echo $sg->SubGroupId; ?>"/><label
                                                                                                for='sg<?php echo $sg->SubGroupId; ?>'></label>
                                                                                    </div>
                                                                                </div>

                                                                                <?php
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                            <div id="product-suppergroups" style="display:block;">
                                                                <?php
                                                                $subgroupIds = explode(",", $role2->AllowedProductSubGroups);
                                                                foreach ($subgroupIds as $sgid) {
                                                                    if (trim($sgid) != "") {
                                                                        $suppergroup3 = new SupperGroupDataSource();
                                                                        $suppergroup3->open();
                                                                        $suppergroups = $suppergroup3->FillBySubgroup($sgid);
                                                                        $suppergroup3->close();
                                                                        $i = 0;
                                                                        foreach ($suppergroups as $sg) {
                                                                            if (($i % 3) == 0) {
                                                                                echo '<br>';
                                                                            }
                                                                            ?>
                                                                            <div class="check-option"><label
                                                                                    class="check-text"
                                                                                    for="ssg<?php echo $sg->SupperGroupId; ?>"><?php echo $sg->Name; ?></label>
                                                                            <div class='checkboxFour'><input
                                                                                        type="checkbox" <?php
                                                                                $pos = strpos($role2->AllowedProductSupperGroups, $sg->SupperGroupId);
                                                                                if ($pos != FALSE) {
                                                                                    echo ' checked ';
                                                                                }
                                                                                ?>
                                                                                        id="ssg<?php echo $sg->SupperGroupId; ?>"
                                                                                        name="suppergroupcheck_list[]"
                                                                                        value="<?php echo $sg->SupperGroupId; ?>"/><label
                                                                                        for='ssg<?php echo $sg->SupperGroupId; ?>'></label>
                                                                            </div></div><?php
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                4
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <br/>
                                                        <div class="warn2"><i class="fa fa-warning"></i></div>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="users">جدول کاربر
                                                                    ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Users == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="users" name="users"/><label
                                                                            for='users'></label></div>
                                                            </div>

                                                            <br>
                                                            <div id="users-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertuser">افزودن
                                                                        کاربر</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="user-check" <?php
                                                                        if ($role2->InsertUser == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertuser" name="insertuser"/><label
                                                                                for='insertuser'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="edituser">ویرایش
                                                                        کاربر</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="user-check" <?php
                                                                        if ($role2->EditUser == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="edituser" name="edituser"/><label
                                                                                for='edituser'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteuser">حذف
                                                                        کاربر</label>
                                                                    <div class='checkboxFour'><input class="user-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteUser == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteuser" name="deleteuser"/><label
                                                                                for='deleteuser'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="usercoupons">جدول
                                                                    کپن مشتری ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->UserCoupons == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="usercoupons" name="usercoupons"/><label
                                                                            for='usercoupons'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="usercoupons-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertusercoupon">افزودن
                                                                        کپن مشتری</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="usercoupon-check" <?php
                                                                        if ($role2->InsertUserCoupon == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertusercoupon"
                                                                                                     name="insertusercoupon"/><label
                                                                                for='insertusercoupon'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editusercoupon">ویرایش
                                                                        کپن مشتری</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="usercoupon-check" <?php
                                                                        if ($role2->EditUserCoupon == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editusercoupon"
                                                                                                     name="editusercoupon"/><label
                                                                                for='editusercoupon'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteusercoupon">حذف
                                                                        کپن
                                                                        مشتری</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="usercoupon-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteUserCoupon == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteusercoupon"
                                                                                name="deleteusercoupon"/><label
                                                                                for='deleteusercoupon'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="productcoupons">جدول
                                                                    کپن محصولات </label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->ProductCoupons == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="productcoupons" name="productcoupons"/><label
                                                                            for='productcoupons'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="productcoupons-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertproductcoupon">افزودن
                                                                        کپن
                                                                        محصولات</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="productcoupon-check" <?php
                                                                        if ($role2->InsertProductCoupon == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertproductcoupon"
                                                                                                     name="insertproductcoupon"/><label
                                                                                for='insertproductcoupon'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editproductcoupon">ویرایش
                                                                        کپن محصولات</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="productcoupon-check" <?php
                                                                        if ($role2->EditProductCoupon == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editproductcoupon"
                                                                                                     name="editproductcoupon"/><label
                                                                                for='editproductcoupon'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteproductcoupon">حذف
                                                                        کپن
                                                                        محصولات</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="productcoupon-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteProductCoupon == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteproductcoupon"
                                                                                name="deleteproductcoupon"/><label
                                                                                for='deleteproductcoupon'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="factorproducts">جدول
                                                                    سفارشات</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->FactorProducts == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="factorproducts" name="factorproducts"/><label
                                                                            for='factorproducts'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="factorproducts-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editfactorproduct">ویرایش
                                                                        سفارشات</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="factorproduct-check" <?php
                                                                        if ($role2->EditFactorProduct == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editfactorproduct"
                                                                                                     name="editfactorproduct"/><label
                                                                                for='editfactorproduct'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="orders">
                                                                    جدول درخواست های کالا
                                                                </label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Orders == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="orders" name="orders"/><label
                                                                            for='orders'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="orders-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editorders">ویرایش
                                                                        درخواست های کالا</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="orders-check" <?php
                                                                        if ($role2->EditOrder == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editorders"
                                                                                                     name="editorders"/><label
                                                                                for='editorders'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="panels">
                                                                    جدول درخواست های پنل فروش
                                                                </label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Panels == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="panels" name="panels"/><label
                                                                            for='panels'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="panels-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editpanels">ویرایش
                                                                        درخواست های پنل فروش</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="panels-check" <?php
                                                                        if ($role2->EditPanel == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editpanels"
                                                                                                     name="editpanels"/><label
                                                                                for='editpanels'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="shippingmethods">جدول
                                                                    روش های حمل و نقل</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->PaymentMethods == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="shippingmethods"
                                                                                                 name="shippingmethods"/><label
                                                                            for='shippingmethods'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="shippingmethods-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <!--                                            <div class="check-option"><label class="check-text"-->
                                                                <!--                                                                             for="insertshippingmethod">افزودن روش های-->
                                                                <!--                                                    حمل و نقل</label>-->
                                                                <!--                                                <div class='checkboxFour'><input type="checkbox"-->
                                                                <!--                                                                                 class="shippingmethod-check" -->
                                                                <?php
                                                                //                                                    if ($role2->InsertPaymentMethod == 1) {
                                                                //                                                        echo ' checked ';
                                                                //                                                    }
                                                                //                                                    ?><!-- id="insertshippingmethod" name="insertshippingmethod"/><label-->
                                                                <!--                                                            for='insertshippingmethod'></label></div>-->
                                                                <!--                                            </div>-->
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editshippingmethod">ویرایش
                                                                        روش های حمل
                                                                        و نقل</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="shippingmethod-check" <?php
                                                                        if ($role2->EditPaymentMethod == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editshippingmethod"
                                                                                                     name="editshippingmethod"/><label
                                                                                for='editshippingmethod'></label></div>
                                                                </div>
                                                                <!--                                            <div class="check-option"><label class="check-text" class="check-text"-->
                                                                <!--                                                                             for="deleteshippingmethod">حذف روش های حمل-->
                                                                <!--                                                    و نقل</label>-->
                                                                <!--                                                <div class='checkboxFour'><input class="shippingmethod-check"-->
                                                                <!--                                                                                 type="checkbox" -->
                                                                <?php
                                                                //                                                    if ($role2->DeletePaymentMethod == 1) {
                                                                //                                                        echo ' checked ';
                                                                //                                                    }
                                                                //                                                    ?><!-- id="deleteshippingmethod" name="deleteshippingmethod"/><label-->
                                                                <!--                                                            for='deleteshippingmethod'></label></div>-->
                                                                <!--                                            </div>-->
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="shippings">جدول حمل
                                                                    و نقل ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Shippings == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="shippings" name="shippings"/><label
                                                                            for='shippings'></label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div id="shippings-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertshipping">افزودن
                                                                        حمل و نقل ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="shipping-check" <?php
                                                                        if ($role2->InsertShipping == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertshipping"
                                                                                                     name="insertshipping"/><label
                                                                                for='insertshipping'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editshipping">ویرایش
                                                                        حمل و نقل ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="shipping-check" <?php
                                                                        if ($role2->EditShipping == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editshipping" name="editshipping"/><label
                                                                                for='editshipping'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteshipping">حذف
                                                                        حمل و نقل
                                                                        ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="shipping-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteShipping == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteshipping"
                                                                                name="deleteshipping"/><label
                                                                                for='deleteshipping'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="linkboxes">جدول
                                                                    پیوند ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->LinkBoxes == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="linkboxes" name="linkboxes"/><label
                                                                            for='linkboxes'></label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div id="linkboxes-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertlinkbox">افزودن
                                                                        پیوند ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="linkbox-check" <?php
                                                                        if ($role2->InsertLinkBox == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertlinkbox"
                                                                                                     name="insertlinkbox"/><label
                                                                                for='insertlinkbox'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editlinkbox">ویرایش
                                                                        پیوند ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="linkbox-check" <?php
                                                                        if ($role2->EditLinkBox == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editlinkbox" name="editlinkbox"/><label
                                                                                for='editlinkbox'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletelinkbox">حذف
                                                                        پیوند ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="linkbox-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteLinkBox == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletelinkbox"
                                                                                name="deletelinkbox"/><label
                                                                                for='deletelinkbox'></label></div>
                                                                </div>

                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="linkboxgroup">دسترسی
                                                                        به گروه
                                                                        ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="linkbox-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->LinkBoxGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="linkboxgroup" name="linkboxgroup"/><label
                                                                                for='linkboxgroup'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="specialoffers">جدول
                                                                    عنوان های پیشنهادات ویژه</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->SpecialOffers == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="specialoffers" name="specialoffers"/><label
                                                                            for='specialoffers'></label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div id="specialoffers-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertspecialoffer">افزودن
                                                                        عنوان پیشنهادات ویژه</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="specialoffer-check" <?php
                                                                        if ($role2->InsertSpecialOffer == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertspecialoffer"
                                                                                                     name="insertspecialoffer"/><label
                                                                                for='insertspecialoffer'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editspecialoffer">ویرایش
                                                                        عنوان پیشنهادات ویژه</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="specialoffer-check" <?php
                                                                        if ($role2->EditSpecialOffer == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editspecialoffer" name="editspecialoffer"/><label
                                                                                for='editspecialoffer'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletespecialoffer">حذف
                                                                        عنوان پیشنهادات ویژه</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="specialoffer-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteSpecialOffer == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletespecialoffer"
                                                                                name="deletespecialoffer"/><label
                                                                                for='deletespecialoffer'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="slides">جدول اسلاید
                                                                    ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Slides == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="slides" name="slides"/><label
                                                                            for='slides'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="slides-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertslide">افزودن
                                                                        اسلاید ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="slide-check" <?php
                                                                        if ($role2->InsertSlide == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertslide" name="insertslide"/><label
                                                                                for='insertslide'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editslide">ویرایش
                                                                        اسلاید ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="slide-check" <?php
                                                                        if ($role2->EditSlide == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editslide" name="editslide"/><label
                                                                                for='editslide'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteslide">حذف
                                                                        اسلاید ها</label>
                                                                    <div class='checkboxFour'><input class="slide-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteSlide == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteslide" name="deleteslide"/><label
                                                                                for='deleteslide'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="thumbs">جدول ریزعکس
                                                                    ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Thumbs == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="thumbs" name="thumbs"/><label
                                                                            for='thumbs'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="thumbs-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertthumb">افزودن
                                                                        ریزعکس ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="thumb-check" <?php
                                                                        if ($role2->InsertThumb == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertthumb" name="insertthumb"/><label
                                                                                for='insertthumb'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editthumb">ویرایش
                                                                        ریزعکس ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="thumb-check" <?php
                                                                        if ($role2->EditThumb == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editthumb" name="editthumb"/><label
                                                                                for='editthumb'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletethumb">حذف
                                                                        ریزعکس ها</label>
                                                                    <div class='checkboxFour'><input class="thumb-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteThumb == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletethumb" name="deletethumb"/><label
                                                                                for='deletethumb'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="prices">جدول قیمت
                                                                    ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Prices == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="prices" name="prices"/><label
                                                                            for='prices'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="prices-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertprice">افزودن
                                                                        قیمت ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="price-check" <?php
                                                                        if ($role2->InsertPrice == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertprice" name="insertprice"/><label
                                                                                for='insertprice'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editprice">ویرایش
                                                                        قیمت ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="price-check" <?php
                                                                        if ($role2->EditPrice == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editprice" name="editprice"/><label
                                                                                for='editprice'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteprice">حذف
                                                                        قیمت ها</label>
                                                                    <div class='checkboxFour'><input class="price-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeletePrice == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteprice" name="deleteprice"/><label
                                                                                for='deleteprice'></label></div>
                                                                </div>

                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="pricechange">نوسان
                                                                        قیمت</label>
                                                                    <div class='checkboxFour'><input class="price-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->PriceChange == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="pricechange" name="pricechange"/><label
                                                                                for='pricechange'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="comments">جدول پرسش
                                                                    و پاسخ ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Comments == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="comments" name="comments"/><label
                                                                            for='comments'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="comments-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editcomment">ویرایش
                                                                        پرسش و پاسخ ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="comment-check" <?php
                                                                        if ($role2->EditComment == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editcomment" name="editcomment"/><label
                                                                                for='editcomment'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletecomment">حذف
                                                                        پرسش و پاسخ
                                                                        ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="comment-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteComment == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletecomment"
                                                                                name="deletecomment"/><label
                                                                                for='deletecomment'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="discounts">جدول
                                                                    تخفیف ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Discounts == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="discounts" name="discounts"/><label
                                                                            for='discounts'></label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div id="discounts-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editdiscount">ویرایش
                                                                        تخفیف ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="discount-check" <?php
                                                                        if ($role2->EditDiscount == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editdiscount" name="editdiscount"/><label
                                                                                for='editdiscount'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletediscount">حذف
                                                                        تخفیف ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="discount-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteDiscount == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletediscount"
                                                                                name="deletediscount"/><label
                                                                                for='deletediscount'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="brands">جدول برند
                                                                    ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Brands == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="brands" name="brands"/><label
                                                                            for='brands'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="brands-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertbrand">افزودن
                                                                        برند ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="brand-check" <?php
                                                                        if ($role2->InsertBrand == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertbrand" name="insertbrand"/><label
                                                                                for='insertbrand'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editbrand">ویرایش
                                                                        برند ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="brand-check" <?php
                                                                        if ($role2->EditBrand == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editbrand" name="editbrand"/><label
                                                                                for='editbrand'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletebrand">حذف
                                                                        برند ها</label>
                                                                    <div class='checkboxFour'><input class="brand-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteBrand == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletebrand" name="deletebrand"/><label
                                                                                for='deletebrand'></label></div>
                                                                </div>


                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="brandlimit">دسترسی
                                                                        به برند های دلخواه</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="brandlist-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->BrandLimit == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="brandlimit"
                                                                                name="brandlimit"/><label
                                                                                for='brandlimit'></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div id="brandslist"
                                                                 style="display:block;">
                                                                <?php
                                                                if ($role2->BrandLimit == 1) {
                                                                    $logo = new LogoDataSource();
                                                                    $logo->open();
                                                                    $logos = $logo->Fill();
                                                                    $logo->close();
                                                                    $i = 0;

                                                                    foreach ($logos as $l) {
                                                                        if (($i % 3) == 0) {
                                                                            echo '<br>';
                                                                        }
                                                                        ?>
                                                                        <div class="check-option"><label
                                                                                    class="check-text"
                                                                                    for="lg<?php echo $l->LogoId; ?>"><?php echo $l->Name; ?></label>
                                                                            <div class='checkboxFour'><input
                                                                                        class="brandcheck"
                                                                                        type="checkbox" <?php
                                                                                $pos = strpos($role2->AllowedBrands, $l->LogoId);
                                                                                if ($pos != FALSE) {
                                                                                    echo ' checked ';
                                                                                }
                                                                                ?>
                                                                                        id="lg<?php echo $l->LogoId; ?>"
                                                                                        name="brandcheck_list[]"
                                                                                        value="<?php echo $l->LogoId; ?>"/><label
                                                                                        for='lg<?php echo $l->LogoId; ?>'></label>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
                                                            </div>

                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="customers">جدول
                                                                    مشتری ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Customers == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="customers" name="customers"/><label
                                                                            for='customers'></label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div id="customers-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertcustomer">افزودن
                                                                        مشتری ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="customer-check" <?php
                                                                        if ($role2->InsertCustomer == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertcustomer"
                                                                                                     name="insertcustomer"/><label
                                                                                for='insertcustomer'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editcustomer">ویرایش
                                                                        مشتری ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="customer-check" <?php
                                                                        if ($role2->EditCustomer == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editcustomer" name="editcustomer"/><label
                                                                                for='editcustomer'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletecustomer">حذف
                                                                        مشتری ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="customer-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteCustomer == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletecustomer"
                                                                                name="deletecustomer"/><label
                                                                                for='deletecustomer'></label></div>
                                                                </div>
                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="sendsms">ارسال
                                                                        پیام
                                                                        دلخواه</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="customer-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->SendSMS == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="sendsms" name="sendsms"/><label
                                                                                for='sendsms'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="productproperties">جدول
                                                                    ویژگی های محصولات</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->ProductProperties == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="productproperties" name="productproperties"/><label
                                                                            for='productproperties'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="productproperties-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertproductproperty">افزودن
                                                                        ویژگی
                                                                        های محصولات</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="productproperty-check" <?php
                                                                        if ($role2->InsertProductProperty == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertproductproperty"
                                                                                                     name="insertproductproperty"/><label
                                                                                for='insertproductproperty'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editproductproperty">ویرایش
                                                                        ویژگی های
                                                                        محصولات</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="productproperty-check" <?php
                                                                        if ($role2->EditProductProperty == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editproductproperty"
                                                                                                     name="editproductproperty"/><label
                                                                                for='editproductproperty'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteproductproperty">حذف
                                                                        ویژگی های
                                                                        محصولات</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="productproperty-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteProductProperty == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteproductproperty"
                                                                                name="deleteproductproperty"/><label
                                                                                for='deleteproductproperty'></label>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="productpropertysubgrouplimit">دسترسی
                                                                        به زیر زیرمجموعه های دلخواه</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="productproperty-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->ProductPropertySubGroupLimit == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="productpropertysubgrouplimit"
                                                                                name="productpropertysubgrouplimit"/><label
                                                                                for='productpropertysubgrouplimit'></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="productproperty-groups" style="display:block;">

                                                            </div>
                                                            <div id="productproperty-subgroups" style="display:block;">

                                                            </div>
                                                            <div id="productproperty-suppergroups"
                                                                 style="display:block;">
                                                                <?php
                                                                if ($role2->ProductPropertySubGroupLimit == 1) {
                                                                    $suppergroup4 = new SupperGroupDataSource();
                                                                    $suppergroup4->open();
                                                                    $suppergroups = $suppergroup4->Fill();
                                                                    $suppergroup4->close();
                                                                    $i = 0;

                                                                    foreach ($suppergroups as $sg) {

                                                                        if (($i % 5) == 0) {
                                                                            echo '<br>';
                                                                        }
                                                                        ?>
                                                                        <div class="check-option"><label
                                                                                    class="check-text"
                                                                                    for="psg<?php echo $sg->SupperGroupId; ?>"><?php echo $sg->Name; ?></label>
                                                                            <div class='checkboxFour'><input
                                                                                        class="ppsuppergroupcheck"
                                                                                        type="checkbox" <?php
                                                                                $pos = strpos($role2->AllowedProductPropertySubGroups, $sg->SupperGroupId);
                                                                                if ($pos != FALSE) {
                                                                                    echo ' checked ';
                                                                                }
                                                                                ?>
                                                                                        id="psg<?php echo $sg->SupperGroupId; ?>"
                                                                                        name="subgroupcheck_list2[]"
                                                                                        value="<?php echo $sg->SupperGroupId; ?>"/><label
                                                                                        for='psg<?php echo $sg->SupperGroupId; ?>'></label>
                                                                            </div>
                                                                        </div>

                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="paymentmethods">جدول
                                                                    روش های پرداخت</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->ShippingMethods == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="paymentmethods" name="paymentmethods"/><label
                                                                            for='paymentmethods'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="paymentmethods-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <!--                                            <div class="check-option"><label class="check-text"-->
                                                                <!--                                                                             for="insertpaymentmethod">افزودن روش های-->
                                                                <!--                                                    پرداخت</label>-->
                                                                <!--                                                <div class='checkboxFour'><input type="checkbox"-->
                                                                <!--                                                                                 class="paymentmethod-check" -->
                                                                <?php
                                                                //                                                    if ($role2->InsertShippingMethod == 1) {
                                                                //                                                        echo ' checked ';
                                                                //                                                    }
                                                                //                                                    ?><!-- id="insertpaymentmethod" name="insertpaymentmethod"/><label-->
                                                                <!--                                                            for='insertpaymentmethod'></label></div>-->
                                                                <!--                                            </div>-->
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editpaymentmethod">ویرایش
                                                                        روش های پرداخت</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="paymentmethod-check" <?php
                                                                        if ($role2->EditShippingMethod == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editpaymentmethod"
                                                                                                     name="editpaymentmethod"/><label
                                                                                for='editpaymentmethod'></label></div>
                                                                </div>
                                                                <!--                                            <div class="check-option"><label class="check-text" class="check-text"-->
                                                                <!--                                                                             for="deletepaymentmethod">حذف روش های-->
                                                                <!--                                                    پرداخت</label>-->
                                                                <!--                                                <div class='checkboxFour'><input class="paymentmethod-check"-->
                                                                <!--                                                                                 type="checkbox" -->
                                                                <?php
                                                                //                                                    if ($role2->DeleteShippingMethod == 1) {
                                                                //                                                        echo ' checked ';
                                                                //                                                    }
                                                                //                                                    ?><!-- id="deletepaymentmethod" name="deletepaymentmethod"/><label-->
                                                                <!--                                                            for='deletepaymentmethod'></label></div>-->
                                                                <!--                                            </div>-->
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="opinions">جدول
                                                                    نظرات</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Opinions == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="opinions" name="opinions"/><label
                                                                            for='opinions'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="opinions-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editopinion">ویرایش
                                                                        نظرات</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="opinion-check" <?php
                                                                        if ($role2->EditOpinion == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editopinion" name="editopinion"/><label
                                                                                for='editopinion'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteopinion">حذف
                                                                        نظرات</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="opinion-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteOpinion == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteopinion"
                                                                                name="deleteopinion"/><label
                                                                                for='deleteopinion'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="feeds">جدول
                                                                    خبرنامه</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Feeds == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="feeds" name="feeds"/><label
                                                                            for='feeds'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="feeds-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertfeed">افزودن
                                                                        خبرنامه</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="feed-check" <?php
                                                                        if ($role2->InsertFeed == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertfeed" name="insertfeed"/><label
                                                                                for='insertfeed'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editfeed">ویرایش
                                                                        خبرنامه</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="feed-check" <?php
                                                                        if ($role2->EditFeed == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editfeed" name="editfeed"/><label
                                                                                for='editfeed'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletefeed">حذف
                                                                        خبرنامه</label>
                                                                    <div class='checkboxFour'><input class="feed-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteFeed == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletefeed" name="deletefeed"/><label
                                                                                for='deletefeed'></label></div>
                                                                </div>
                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="feedsendemail">ارسال
                                                                        ایمیل
                                                                        دلخواه</label>
                                                                    <div class='checkboxFour'><input class="feed-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->FeedSendEmail == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="feedsendemail"
                                                                                                     name="feedsendemail"/><label
                                                                                for='feedsendemail'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="guarantees">جدول
                                                                    گارانتی ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Guarantees == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="guarantees" name="guarantees"/><label
                                                                            for='guarantees'></label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div id="guarantees-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertguarantee">افزودن
                                                                        گارانتی ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="guarantee-check" <?php
                                                                        if ($role2->InsertGuarantee == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertguarantee" name="insertguarantee"/><label
                                                                                for='insertguarantee'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editguarantee">ویرایش
                                                                        گارانتی ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="guarantee-check" <?php
                                                                        if ($role2->EditGuarantee == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editguarantee"
                                                                                                     name="editguarantee"/><label
                                                                                for='editguarantee'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteguarantee">حذف
                                                                        گارانتی
                                                                        ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="guarantee-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteGuarantee == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteguarantee" name="deleteguarantee"/><label
                                                                                for='deleteguarantee'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="colors">جدول رنگ
                                                                    ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Colors == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="colors" name="colors"/><label
                                                                            for='colors'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="colors-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertcolor">افزودن
                                                                        رنگ ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="color-check" <?php
                                                                        if ($role2->InsertColor == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertcolor" name="insertcolor"/><label
                                                                                for='insertcolor'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editcolor">ویرایش
                                                                        رنگ ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="color-check" <?php
                                                                        if ($role2->EditColor == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editcolor" name="editcolor"/><label
                                                                                for='editcolor'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletecolor">حذف
                                                                        رنگ ها</label>
                                                                    <div class='checkboxFour'><input class="color-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteColor == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletecolor" name="deletecolor"/><label
                                                                                for='deletecolor'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="services">جدول
                                                                    خدمات</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Services == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="services" name="services"/><label
                                                                            for='services'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="services-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertservice">افزودن
                                                                        خدمات</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="service-check" <?php
                                                                        if ($role2->InsertService == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertservice"
                                                                                                     name="insertservice"/><label
                                                                                for='insertservice'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editservice">ویرایش
                                                                        خدمات</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="service-check" <?php
                                                                        if ($role2->EditService == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editservice" name="editservice"/><label
                                                                                for='editservice'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleteservice">حذف
                                                                        خدمات</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="service-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteService == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleteservice"
                                                                                name="deleteservice"/><label
                                                                                for='deleteservice'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="groups">جدول مجموعه
                                                                    ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Groups == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="groups" name="groups"/><label
                                                                            for='groups'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="groups-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertgroup">افزودن
                                                                        مجموعه ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="group-check" <?php
                                                                        if ($role2->InsertGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertgroup" name="insertgroup"/><label
                                                                                for='insertgroup'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editgroup">ویرایش
                                                                        مجموعه ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="group-check" <?php
                                                                        if ($role2->EditGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editgroup" name="editgroup"/><label
                                                                                for='editgroup'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletegroup">حذف
                                                                        مجموعه ها</label>
                                                                    <div class='checkboxFour'><input class="group-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletegroup" name="deletegroup"/><label
                                                                                for='deletegroup'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="subgroups">جدول
                                                                    زیرمجموعه ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->SubGroups == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="subgroups" name="subgroups"/><label
                                                                            for='subgroups'></label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div id="subgroups-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertsubgroup">افزودن
                                                                        زیرمجموعه ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="subgroup-check" <?php
                                                                        if ($role2->InsertSubGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertsubgroup"
                                                                                                     name="insertsubgroup"/><label
                                                                                for='insertsubgroup'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editsubgroup">ویرایش
                                                                        زیرمجموعه ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="subgroup-check" <?php
                                                                        if ($role2->EditSubGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editsubgroup" name="editsubgroup"/><label
                                                                                for='editsubgroup'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletesubgroup">حذف
                                                                        زیرمجموعه
                                                                        ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="subgroup-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteSubGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletesubgroup"
                                                                                name="deletesubgroup"/><label
                                                                                for='deletesubgroup'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="suppergroups">جدول
                                                                    زیر زیرمجموعه ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->SupperGroups == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="suppergroups" name="suppergroups"/><label
                                                                            for='suppergroups'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="suppergroups-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertsuppergroup">افزودن
                                                                        زیر زیرمجموعه ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="suppergroup-check" <?php
                                                                        if ($role2->InsertSupperGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertsuppergroup"
                                                                                                     name="insertsuppergroup"/><label
                                                                                for='insertsuppergroup'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editsuppergroup">ویرایش
                                                                        زیر زیرمجموعه ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="suppergroup-check" <?php
                                                                        if ($role2->EditSupperGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editsuppergroup" name="editsuppergroup"/><label
                                                                                for='editsuppergroup'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletesuppergroup">حذف
                                                                        زیر زیرمجموعه
                                                                        ها</label>
                                                                    <div class='checkboxFour'><input
                                                                                class="suppergroup-check"
                                                                                type="checkbox" <?php
                                                                        if ($role2->DeleteSupperGroup == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletesuppergroup"
                                                                                name="deletesuppergroup"/><label
                                                                                for='deletesuppergroup'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="warn2"><i class="fa fa-warning"></i></div>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="roles">جدول نقش
                                                                    ها</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Roles == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="roles" name="roles"/><label
                                                                            for='roles'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="roles-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertrole">افزودن
                                                                        نقش ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="role-check" <?php
                                                                        if ($role2->InsertRole == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertrole" name="insertrole"/><label
                                                                                for='insertrole'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editrole">ویرایش
                                                                        نقش ها</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="role-check" <?php
                                                                        if ($role2->EditRole == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editrole" name="editrole"/><label
                                                                                for='editrole'></label>
                                                                    </div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deleterole">حذف
                                                                        نقش ها</label>
                                                                    <div class='checkboxFour'><input class="role-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteRole == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deleterole" name="deleterole"/><label
                                                                                for='deleterole'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="news">جدول
                                                                    اخبار</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->News == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="news" name="news"/><label
                                                                            for='news'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="news-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="insertnews">افزودن
                                                                        اخبار</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="news-check" <?php
                                                                        if ($role2->InsertNews == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="insertnews" name="insertnews"/><label
                                                                                for='insertnews'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="editnews">ویرایش
                                                                        اخبار</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="news-check" <?php
                                                                        if ($role2->EditNews == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="editnews" name="editnews"/><label
                                                                                for='editnews'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="deletenews">حذف
                                                                        اخبار
                                                                    </label>
                                                                    <div class='checkboxFour'><input class="news-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->DeleteNews == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="deletenews" name="deletenews"/><label
                                                                                for='deletenews'></label></div>
                                                                </div>
                                                                <br>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 class="check-text"
                                                                                                 for="newsapprove">نیاز
                                                                        به تایید جهت
                                                                        فعالسازی
                                                                        دسته بندی ها</label>
                                                                    <div class='checkboxFour'><input class="p-check"
                                                                                                     type="checkbox" <?php
                                                                        if ($role2->NewsApprove == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="newsapprove" name="newsapprove"/><label
                                                                                for='newsapprove'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="stats">جداول
                                                                    آمار</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Stats == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="stats" name="stats"/><label
                                                                            for='stats'></label></div>
                                                            </div>
                                                            <br>
                                                        </div>


                                                        <br/>
                                                        <div class="checkbox-container">
                                                            <div class="check-option marginbottom-ten block"><label
                                                                        class="check-text"
                                                                        for="settings">جدول
                                                                    تنظیمات</label>
                                                                <div class='checkboxFour'><input type="checkbox" <?php
                                                                    if ($role2->Settings == 1) {
                                                                        echo ' checked ';
                                                                    }
                                                                    ?> id="settings" name="settings"/><label
                                                                            for='settings'></label></div>
                                                            </div>
                                                            <br>
                                                            <div id="settings-options" style="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo 'display: block; ';
                                                            } else {
                                                                echo 'display: none; ';
                                                            }
                                                            ?>">
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="colorsettings">تنظیمات
                                                                        رنگ بندی</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="settings-check" <?php
                                                                        if ($role2->ColorSettings == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="colorsettings"
                                                                                                     name="colorsettings"/><label
                                                                                for='colorsettings'></label></div>
                                                                </div>
                                                                <div class="check-option"><label class="check-text"
                                                                                                 for="menusettings">تنظیمات
                                                                        منو</label>
                                                                    <div class='checkboxFour'><input type="checkbox"
                                                                                                     class="settings-check" <?php
                                                                        if ($role2->MenuSettings == 1) {
                                                                            echo ' checked ';
                                                                        }
                                                                        ?> id="menusettings" name="menusettings"/><label
                                                                                for='menusettings'></label></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="SaveTr">
                                                    <td class="SaveTd"></td>
                                                    <td>
                                                        <button class="btn btn-primary btn-w-m pull-right"
                                                                type="submit"><i
                                                                    class="fa fa-check"></i><strong>تایید</strong>
                                                        </button>
                                                    </td>
                                                </tr>

                                            </table>
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
if (isset($_GET['id'])) {
    ?>
    <script>
        $(document).ready(function () {
            $('.groupcheck').change(function () {
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: 'AjaxSubGroupChecks.php',
                        type: 'POST',
                        data: {
                            checkedgroupId: $(this).attr('value')
                        },
                        success: function (result) {
                            $('#product-subgroups').html(result);
                            $('#product-suppergroups').html('');
                            <?php
                            $_SESSION[SESSION_STRING_SELECTED_SUB_GROUPS] = "";
                            $_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS] = "";
                            ?>

                        }
                    });
                }
                else {
                    $.ajax({
                        url: 'AjaxSubGroupChecks.php',
                        type: 'POST',
                        data: {
                            uncheckedgroupId: $(this).attr('value')
                        },
                        success: function (result) {
                            $('#product-subgroups').html(result);
                        }
                    });
                    $.ajax({
                        url: 'AjaxSupperGroupChecks.php',
                        type: 'POST',
                        data: {uncheckedgroupId: $(this).attr('value')},
                        success: function (result) {
                            $('#product-suppergroups').html(result);
                        }
                    });
                }
            });
            $('.subgroupcheck').change(function () {
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: 'AjaxSupperGroupChecks.php',
                        type: 'POST',
                        data: {checkedsubgroupId: $(this).attr('value')},
                        success: function (result) {
                            $('#product-suppergroups').html(result);
                        }
                    });
                }
                else {
                    $.ajax({
                        url: 'AjaxSupperGroupChecks.php',
                        type: 'POST',
                        data: {uncheckedsubgroupId: $(this).attr('value')},
                        success: function (result) {
                            $('#product-suppergroups').html(result);
                        }
                    });
                }
            });
        });
    </script>
    <?php
}
?>
<?php
include_once 'Template/bottom.php';
