<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/UserDataSource.inc" ;
$uds = new UserDataSource();
$uds->open();

$users = $uds->Fill();
$uds->close();



?>
<?php
include_once 'Template/top.php';
if ($role->Users != 1) {
    header('Location:Index.php');
    die();
}

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>کاربر ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Users</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست کاربر ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

        <div class="Database">
            <?php
            if ($role->InsertUser == 1) {
                ?>
                <a href="User.php">
                    <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                        افزودن کاربر جدید
                    </button>
                </a>
                <?php
            }
            ?>
            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                   placeholder="جستجو در لیست موجود در این صفحه">
            <table class="footable table table-stripped" data-page-size="1000000000"
                   data-filter=#filter>
                <thead>
                <tr>
                    <th>شناسه</th>
                    <th data-hide="phone,tablet">نام</th>
                    <th>نام خانوادگی</th>
                    <th data-hide="phone,tablet">پست الکترونیک</th>
                    <th>نام کاربری</th>
                    <!--<th> کد فعالسازی </th>-->
                    <th data-hide="phone,tablet" data-sort-ignore="true"> وضعیت</th>
                    <th data-hide="phone,tablet"> نقش</th>
                    <?php
                    if ($role->EditUser == 1) {
                        ?>
                        <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
                        <?php
                    }
                    if ($role->DeleteUser == 1) {
                        ?>
                        <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
                        <?php
                    }
                    ?>

                </tr>
                </thead>
                <tbody>
                <?php
                $postsCounter = 0;
                foreach ($users as $u) {
                    $postsCounter++;
                    echo "<tr>";
                    echo "<td><div class='DatabaseField' >" . $u->UserId . "</div></td>";
                    echo "<td><div class='DatabaseField' >" . $u->Name . "</div></td>";
                    echo "<td><div class='DatabaseField' >" . $u->Family . "</div></td>";
                    echo "<td><div class='DatabaseField' >" . $u->Email . "</div></td>";
                    echo "<td><div class='DatabaseField' >" . $u->Username . "</div></td>";
//                    echo "<td><div class='DatabaseField' >" . $u->ActiveCode . "</div></td>";
                    echo "<td><div class='DatabaseField' >";
                    if ($u->Activate == 1) {
                        echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                    } else {
                        echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                    }
                    echo "</div></td>";

                    $role2 = new RoleDataSource();
                    $role2 ->open();
//                    $role2->RoleId = $u->Role;
                    $r = $role2->FindOneRoleNameBasedOnId($u->Role);
                    $role2 ->close();
                    echo "<td><div class='DatabaseField' >" . $r . "</div></td>";

                    if ($role->EditUser == 1) {
                        echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='User.php?id=" . $u->UserId . "'>" . "ویرایش" . "</a></button></td>";
                    }
                    if ($role->DeleteUser == 1) {
                        if ($u->UserId == 1) {
                            echo "<td><button class='btn-white btn btn-sm m-xs' title='Can Not Delete' disabled><a href='#'>" . "امکان حذف وجود ندارد" . "</a></button></td>";
                        } else {
                            echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a href='DeleteConfirm.php?userid=" . $u->UserId . "'>" . "حذف" . "</a></button></td>";
                        }
                    }
                    echo "</tr>";
                }
                ?>
                </tbody>
<!--                <tfoot  style="direction: ltr">-->
<!--                <tr>-->
<!--                    <td colspan="5">-->
<!--                        <ul class="pagination pull-right"></ul>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                </tfoot>-->
            </table>
        </div>
        <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php
include_once 'Template/bottom.php';
    