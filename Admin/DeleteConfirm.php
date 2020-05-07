<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top.php';
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>هشدار حذف</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Delete Warning</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <?php
                    if (isset($_GET['colorlistid'])) {
                        ?>
                        <a href="ColorLists.php">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-mail-forward"></i>
                                بازگشت
                            </button>
                        </a>
                        <?php
                    } elseif (isset($_GET['guaranteeid'])) {
                        ?>
                        <a href="GuaranteeLists.php">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-mail-forward"></i>
                                بازگشت
                            </button>
                        </a>
                        <?php
                    } elseif (isset($_GET['customerid'])) {
                        ?>
                        <a href="Customers.php">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-mail-forward"></i>
                                بازگشت
                            </button>
                        </a>
                        <?php
                    } elseif (isset($_GET['roleid'])) {
                        ?>
                        <a href="Roles.php">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-mail-forward"></i>
                                بازگشت
                            </button>
                        </a>
                        <?php
                    } elseif (isset($_GET['gpid'])) {
                        ?>
                        <a href="Groups.php">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-mail-forward"></i>
                                بازگشت
                            </button>
                        </a>
                        <?php
                    } elseif (isset($_GET['sgpid'])) {
                        ?>
                        <a href="SubGroups.php">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-mail-forward"></i>
                                بازگشت
                            </button>
                        </a>
                        <?php
                    } elseif (isset($_GET['ssgpid'])) {
                        ?>
                        <a href="SupperGroups.php">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-mail-forward"></i>
                                بازگشت
                            </button>
                        </a>
                        <?php
                    } elseif (isset($_GET['userid'])) {
                        ?>
                        <a href="Users.php">
                            <button class="btn btn-success btn-w-m" type="button"><i class="fa fa-mail-forward"></i>
                                بازگشت
                            </button>
                        </a>
                        <?php
                    }
                    ?>

                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            حذف
                        </div>
                        <div class="panel-body">

                            <?php
                            if (isset($_GET['colorlistid'])) {
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';


                                $clds = new ColorListDataSource();
                                $clds->open();
                                $c = $clds->FindOneColorListBasedOnId($_GET['colorlistid']);
                                $clds->close();


                                $pcds = new ProductColorDataSource();
                                $pcds->open();
                                $temp = $pcds->GetProductsOfColor($c->ColorListId);
                                $pcds->close();

                                $pds = new ProductDataSource();
                                $pds->open();
                                ?>
                                <div class="delete_confirm">
                                    <div class="alert alert-danger">
                                            <span> با حذف این رنگ، <?php echo $c->Name; ?>
                                                برای تمام محصولات حذف خواهد شد! (همینطور تعداد موجودی محصولات با رنگ <?php echo $c->Name; ?>
                                                )</span>
                                    </div>
                                    <div class="block">
                                        <div class="title">محصولات دارای این رنگ</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <li>
                                                        <a href="Product.php?id=<?php echo $t->Product; ?>"
                                                           title="<?php echo $t->Name; ?>"
                                                           target="_blank">
                                                            <div class="image-container">
                                                                <img src="../<?php $pds->FindOneProductImage($t->Product); ?>"/>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if ($temp == null) {
                                                    $safedelete = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                $pds->close();
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="block"></div>

                                    <div class="buttons" style="text-align: left">
                                        <a onclick='return deleteConfirm()' class="<?php
                                        if (isset($safedelete)) {
                                            echo 'btn btn-primary btn-w-m';
                                        } else {
                                            echo 'btn btn-danger btn-w-m';
                                        }
                                        ?>"
                                           href="operateColorList.php?id=<?php echo $_GET['colorlistid']; ?>">
                                            <i class="fa fa-trash"></i>
                                            حذف کردن
                                        </a>
                                    </div>
                                </div>
                                <?php
                            } elseif (isset($_GET['guaranteeid'])) {
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeListDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';


                                $glds = new GuaranteeListDataSource();
                                $glds->open();
                                $g = $glds->FindOneGuaranteeListBasedOnId($_GET['guaranteeid']);
                                $glds->close();


                                $pgds = new GuaranteeDataSource();
                                $pgds->open();
                                $temp = $pgds->GetThisGuaranteeProducts($_GET['guaranteeid']);
                                $pgds->close();


                                $pds = new ProductDataSource();
                                $pds->open();

                                ?>
                                <div class="delete_confirm">
                                    <div class="alert alert-danger">
                                        <span>با حذف این گارانتی، گارانتی <?php echo $g->Name; ?> تمام محصولات حذف خواهد شد!</span>
                                    </div>
                                    <div class="block">
                                        <div class="title">محصولات دارای این گارانتی</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <li>
                                                        <a href="Product.php?id=<?php echo $t->Product; ?>"
                                                           title="<?php echo $t->Name; ?>"
                                                           target="_blank">
                                                            <div class="image-container">
                                                                <img src="../<?php $pds->FindOneProductImage($t->Product); ?>"/>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if ($temp == null) {
                                                    $safedelete = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                $pds->close();
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="block"></div>

                                    <div class="buttons">
                                        <a onclick='return deleteConfirm()' class="<?php
                                        if (isset($safedelete)) {
                                            echo 'btn btn-primary btn-w-m';
                                        } else {
                                            echo 'btn btn-danger btn-w-m';
                                        }
                                        ?>"
                                           href="operateGuaranteeList.php?id=<?php echo $_GET['guaranteeid']; ?>">
                                            <i class="fa fa-trash"></i>
                                            حذف کردن
                                        </a>
                                    </div>
                                </div>
                                <?php
                            } elseif (isset($_GET['customerid'])) {
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';

                                $cds = new CustomerDataSource();
                                $cds->open();
                                $customer = new Customer();
                                $customer->CustomerId = $_GET['customerid'];
                                $c = $cds->FindOneCustomerBasedOnId($_GET['customerid']);

                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';

                                $cmds = new CommentDataSource();
                                $cmds->open();
                                $temp = $cmds->GetThisCustomerComments($_GET['customerid']);
                                $cmds->close();

                                ?>
                                <div class="delete_confirm">
                                    <div class="alert alert-danger">
                                        با حذف این مشتری موارد زیر نیز حذف خواهند شد!
                                    </div>
                                    <div class="block">
                                        <div class="title">پرسش و پاسخ های این مشتری</div>
                                        <div class="content">
                                            <?php
                                            foreach ($temp as $t) {
                                                ?>
                                                <div class="text"><?php echo "<span class='num' title='شناسه'>" . $t->CommentId . '</span>' . $t->Value; ?></div>

                                                <?php
                                            }
                                            if ($temp == null) {
                                                $safedelete1 = 1;
                                                ?>
                                                <div class="alert alert-warning">
                                                    هیچ موردی در ارتباط نیست
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';
                                    $o = new OpinionDataSource();
                                    $o->open();
                                    $temp = $o->GetThisCustomerOpinions($_GET['customerid']);
                                    $o->close();

                                    ?>
                                    <div class="block">
                                        <div class="title">نظرات این مشتری</div>
                                        <div class="content">
                                            <?php
                                            foreach ($temp as $t) {
                                                ?>
                                                <div class="text"><?php echo "<span class='num' title='شناسه'>" . $t->OpinionId . '</span>' . $t->Value . "<span class='rate' title='امتیاز'>" . $t->Rate . " از 5</span>"; ?></div>
                                                <?php
                                            }
                                            if ($temp == null) {
                                                $safedelete2 = 1;
                                                ?>
                                                <div class="alert alert-warning">
                                                    هیچ موردی در ارتباط نیست
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
                                    $fp = new FactorProductDataSource();
                                    $fp->open();
                                    $temp = $fp->FindOneCustomerFactors2($_GET['customerid']);
                                    $fp->close();
                                    ?>
                                    <div class="block">
                                        <div class="title">سفارشات این مشتری</div>
                                        <div class="content">
                                            <?php
                                            foreach ($temp as $t) {
                                                ?>
                                                <div class="text"><?php echo "<span class='num' title='شناسه'>" . $t->FactorProductId . '</span>' . $t->TraceCode . "<span class='status' title='وضعیت'>";
                                                    if ($t->Status == 0) {
                                                        echo "در انتظار بررسی";
                                                    } elseif ($t->Status == 1) {
                                                        echo 'تایید شد و در پروسه انبار';
                                                    } elseif ($t->Status == 2) {
                                                        echo 'ارسال شد';
                                                    } elseif ($t->Status == 3) {
                                                        echo 'لغو شد';
                                                    } elseif ($t->Status == 4) {
                                                        echo 'توسط مشتری حذف شد';
                                                    }
                                                    echo "</span>"; ?></div>
                                                <?php
                                            }
                                            if ($temp == null) {
                                                $safedelete3 = 1;
                                                ?>
                                                <div class="alert alert-warning">
                                                    هیچ موردی در ارتباط نیست
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>


                                    <div class="buttons" style="text-align: left">
                                        <a onclick='return deleteConfirm()' class="<?php
                                        if (isset($safedelete1) && isset($safedelete2) && isset($safedelete3)) {
                                            echo 'btn btn-primary btn-w-m';
                                        } else {
                                            echo 'btn btn-danger btn-w-m';
                                        }
                                        ?>"
                                           href="operateCustomer.php?id=<?php echo $_GET['customerid']; ?>">
                                            <i class="fa fa-trash"></i>
                                            حذف کردن
                                        </a>
                                    </div>
                                </div>
                                <?php
                            } elseif (isset($_GET['roleid'])) {


                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/RoleDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserDataSource.inc';


                                $role = new RoleDataSource();
                                $role->open();
                                $r = $role->FindOneRoleBasedOnId($_GET['roleid']);
                                $role->close();


                                $user = new UserDataSource();
                                $user->open();
                                $users = $user->GetThisRoleUsers($_GET['roleid']);
                                $user->close();
                                ?>
                                <div class="delete_confirm">
                                    <div class="alert alert-danger">
                                        با حذف این نقش موارد زیر نیز حذف خواهند شد!
                                    </div>
                                    <div class="block">
                                        <div class="title">کاربران دارای این نقش</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($users as $t) {

                                                    echo '<div class="text"><span class="num" title="شناسه">' . $t->UserId . '</span>' . $t->Name . ' ' . $t->Family . ' | ' . $t->Email . '</div>';

                                                }
                                                if ($users == null) {
                                                    $safedelete = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';

                                    $d = new DiscountDataSource();
                                    $d->open();

                                    ?>

                                    <div class="block">
                                        <div class="title">تخفیف های ثبت شده توسط این کاربر</div>
                                        <div class="content">
                                            <?php
                                            foreach ($users as $user) {
                                                $temp = $d->GetThisUserDiscounts($user->UserId);
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <div class="text"><?php echo "<span class='num' title='شناسه'>" . $t->DiscountId . '</span>' . $t->Value . '%'; ?></div>

                                                    <?php
                                                }
                                            }

                                            $false = 1;
                                            foreach ($users as $user) {
                                                $temp = $d->GetThisUserDiscounts($user->UserId);
                                                foreach ($temp as $t) {
                                                    unset($false);
                                                }
                                            }
                                            if (isset($false)) {
                                                $safedelete2 = 1;
                                                ?>
                                                <div class="alert alert-warning">
                                                    هیچ موردی در ارتباط نیست
                                                </div>
                                                <?php
                                            }


                                            $d->close();

                                            ?>

                                        </div>
                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
                                    $o = new PriceDataSource();
                                    $o->open();

                                    ?>
                                    <div class="block">
                                        <div class="title">قیمت های ثبت شده توسط این کاربران</div>
                                        <div class="content">
                                            <?php
                                            foreach ($users as $user) {
                                                $temp = $o->GetThisUserPrices($user->UserId);
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <div class="text"><?php echo "<span class='num' title='شناسه'>" . $t->PriceId . '</span>' . number_format($t->Value) . " تومان</span>"; ?></div>
                                                    <?php
                                                }
                                            }
                                            $false = 1;
                                            foreach ($users as $user) {
                                                $temp = $o->GetThisUserPrices($user->UserId);
                                                foreach ($temp as $t) {
                                                    unset($false);
                                                }
                                            }
                                            if (isset($false)) {
                                                $safedelete3 = 1;
                                                ?>
                                                <div class="alert alert-warning">
                                                    هیچ موردی در ارتباط نیست
                                                </div>
                                                <?php
                                            }
                                            $o->close();
                                            ?>
                                        </div>

                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
                                    $fp = new ProductDataSource();
                                    $fp->open();

                                    ?>
                                    <div class="block">
                                        <div class="title">محصولات ثبت شده توسط این کاربران</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($users as $user) {
                                                    $temp = $fp->GetThisUserProducts($user->UserId);
                                                    foreach ($temp as $t) {
                                                        ?>
                                                        <li>
                                                            <a href="Product.php?id=<?php echo $t->ProductId; ?>"
                                                               title="<?php echo $t->Name; ?>" target="_blank">
                                                                <div class="image-container">
                                                                    <img src="../<?php echo $t->Image; ?>"/>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                $false = 1;
                                                foreach ($users as $user) {
                                                    $temp = $fp->GetThisUserProducts($user->UserId);
                                                    foreach ($temp as $t) {
                                                        unset($false);
                                                    }
                                                }
                                                if (isset($false)) {
                                                    $safedelete4 = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }

                                                $fp->close();
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/NewsDataSource.inc';
                                    $fp = new NewsDataSource();
                                    $fp->open();

                                    ?>
                                    <div class="block">
                                        <div class="title">خبر های ثبت شده توسط این کاربران</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($users as $user) {
                                                    $temp = $fp->GetThisUserNews($user->UserId);
                                                    foreach ($temp as $t) {
                                                        ?>
                                                        <li>
                                                            <a href="NewsForm.php?id=<?php echo $t->NewsId; ?>"
                                                               title="<?php echo $t->Title; ?>" target="_blank">
                                                                <div class="image-container">
                                                                    <img src="../<?php echo $t->Image; ?>"/>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                $false = 1;
                                                foreach ($users as $user) {
                                                    $temp = $fp->GetThisUserNews($user->UserId);
                                                    foreach ($temp as $t) {
                                                        unset($false);
                                                    }
                                                }
                                                if (isset($false)) {
                                                    $safedelete5 = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                $fp->close();
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="block"></div>


                                    <div class="buttons">
                                        <a onclick='return deleteConfirm()' class="<?php
                                        if (isset($safedelete) && isset($safedelete2) && isset($safedelete3) && isset($safedelete4) && isset($safedelete5)) {
                                            echo 'btn btn-primary btn-w-m';;
                                        } else {
                                            echo 'btn btn-danger btn-w-m';
                                        }
                                        ?>"
                                           href="DeleteRole.php?id=<?php echo $_GET['roleid']; ?>">
                                            <i class="fa fa-trash"></i>
                                            حذف کردن
                                        </a>
                                    </div>
                                </div>
                                <?php
                            } elseif
                            (isset($_GET['gpid'])) {
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
                                $group = new GroupDataSource();
                                $group->open();
                                $gp = $group->FindOneGroupBasedOnId($_GET['gpid']);
                                $group->close();

                                $product = new ProductDataSource();
                                $product->open();
                                $temp = $product->FillByGroup($_GET['gpid']);
                                $product->close();
                                ?>
                                <div class="delete_confirm">
                                    <div class="alert alert-danger">
                                            <span>با حذف این مجموعه، تمامی زیر مجموعه ها و زیر زیرمجموعه های <?php echo $gp->Name; ?>
                                                و محصولات زیر حذف خواهند شد.</span>
                                    </div>
                                    <div class="block">
                                        <div class="title">محصولات این مجموعه</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <li>
                                                        <a href="Product.php?id=<?php echo $t->ProductId; ?>"
                                                           title="<?php echo $t->Name; ?>" target="_blank">
                                                            <div class="image-container">
                                                                <img src="../<?php echo $t->Image; ?>"/>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if ($temp == null) {
                                                    $safedelete = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="block"></div>

                                    <div class="buttons" style="text-align: left">
                                        <a onclick='return deleteConfirm()' class="<?php
                                        if (isset($safedelete)) {
                                            echo 'btn btn-primary btn-w-m';
                                        } else {
                                            echo 'btn btn-danger btn-w-m';
                                        }
                                        ?>"
                                           href="operateGroup.php?id=<?php echo $_GET['gpid']; ?>">
                                            <i class="fa fa-trash"></i>
                                            حذف کردن
                                        </a>
                                    </div>
                                </div>
                                <?php
                            } elseif
                            (isset($_GET['sgpid'])) {
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
                                $subgroup = new SubGroupDataSource();
                                $subgroup->open();
                                $sgp = $subgroup->FindOneSubGroupBasedOnId($_GET['sgpid']);
                                $subgroup->close();

                                $product = new ProductDataSource();
                                $product->open();
                                $temp = $product->FillBySGroup($_GET['sgpid']);
                                $product->close();
                                ?>
                                <div class="delete_confirm">
                                    <div class="alert alert-danger">
                                            <span> با حذف این زیر مجموعه، تمام زیر زیرمجموعه های <?php echo $sgp->Name; ?>
                                                و محصولات زیر حذف خواهند شد! </span>
                                    </div>
                                    <div class="block">
                                        <div class="title">محصولات این زیر مجموعه</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <li>
                                                        <a href="Product.php?id=<?php echo $t->ProductId; ?>"
                                                           title="<?php echo $t->Name; ?>" target="_blank">
                                                            <div class="image-container">
                                                                <img src="../<?php echo $t->Image; ?>"/>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if ($temp == null) {
                                                    $safedelete = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="block"></div>

                                    <div class="buttons">
                                        <a onclick='return deleteConfirm()' class="<?php
                                        if (isset($safedelete)) {
                                            echo 'btn btn-primary btn-w-m';
                                        } else {
                                            echo 'btn btn-danger btn-w-m';
                                        }
                                        ?>"
                                           href="operateSubGroup.php?id=<?php echo $_GET['sgpid']; ?>">
                                            <i class="fa fa-trash"></i>
                                            حذف کردن
                                        </a>
                                    </div>
                                </div>
                                <?php
                            } elseif
                            (isset($_GET['ssgpid'])) {
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
                                $spgroup = new SupperGroupDataSource();
                                $spgroup->open();
                                $sgp = $spgroup->FindOneSupperGroupBasedOnId($_GET['ssgpid']);
                                $spgroup->close();
                                $product = new ProductDataSource();
                                $product->open();
                                $temp = $product->FillBySSGroup($_GET['ssgpid']);
                                $product->close();
                                ?>
                                <div class="delete_confirm">
                                    <div class="alert alert-danger">
                                        با حذف این زیر زیرمجموعه، تمام محصولات زیر حذف خواهند شد!
                                    </div>
                                    <div class="block">
                                        <div class="title">محصولات این زیر زیرمجموعه</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <li>
                                                        <a href="Product.php?id=<?php echo $t->ProductId; ?>"
                                                           title="<?php echo $t->Name; ?>" target="_blank">
                                                            <div class="image-container">
                                                                <img src="../<?php echo $t->Image; ?>"/>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if ($temp == null) {
                                                    $safedelete = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="block"></div>

                                    <div class="buttons">
                                        <a onclick='return deleteConfirm()' class="<?php
                                        if (isset($safedelete)) {
                                            echo 'btn btn-primary btn-w-m';
                                        } else {
                                            echo 'btn btn-danger btn-w-m';
                                        }
                                        ?>"
                                           href="operateSupperGroup.php?id=<?php echo $_GET['ssgpid']; ?>">
                                            <i class="fa fa-trash"></i>
                                            حذف کردن
                                        </a>
                                    </div>
                                </div>
                                <?php
                            } elseif
                            (isset($_GET['userid'])) {

                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/UserDataSource.inc';
                                $uds = new UserDataSource();
                                $uds->open();

                                $u = $uds->FindOneUserBasedOnId($_GET['userid']);

                                ?>
                                <div class="delete_confirm">
                                    <div class="alert alert-danger">
                                        با حذف این کاربر موارد زیر نیز حذف خواهند شد!
                                    </div>
                                    <div class="alert alert-success">
                                        پیشنهاد : به جای حذف کردن کاربر آن را ویرایش یا غیرفعال کنید.
                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/DiscountDataSource.inc';
                                    $d = new DiscountDataSource();
                                    $d->open();
                                    $temp = $d->GetThisUserDiscounts($_GET['userid']);
                                    $d->close();
                                    ?>

                                    <div class="block">
                                        <div class="title">تخفیف های ثبت شده توسط این کاربر</div>
                                        <div class="content">
                                            <?php
                                            foreach ($temp as $t) {
                                                ?>
                                                <div class="text"><?php echo "<span class='num' title='شناسه'>" . $t->DiscountId . '</span>' . $t->Value . '%'; ?></div>

                                                <?php
                                            }
                                            if ($temp == null) {
                                                $safedelete1 = 1;
                                                ?>
                                                <div class="alert alert-warning">
                                                    هیچ موردی در ارتباط نیست
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
                                    $o = new PriceDataSource();
                                    $o->open();
                                    $temp = $o->GetThisUserPrices($_GET['userid']);
                                    $o->close();
                                    ?>
                                    <div class="block">
                                        <div class="title">قیمت های ثبت شده توسط این کاربر</div>
                                        <div class="content">
                                            <?php
                                            foreach ($temp as $t) {
                                                ?>
                                                <div class="text"><?php echo "<span class='num' title='شناسه'>" . $t->PriceId . '</span>' . number_format($t->Value) . " تومان</span>"; ?></div>
                                                <?php
                                            }
                                            if ($temp == null) {
                                                $safedelete2 = 1;
                                                ?>
                                                <div class="alert alert-warning">
                                                    هیچ موردی در ارتباط نیست
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
                                    $fp = new ProductDataSource();
                                    $fp->open();
                                    $temp = $fp->GetThisUserProducts($_GET['userid']);
                                    $fp->close();
                                    ?>
                                    <div class="block">
                                        <div class="title">محصولات ثبت شده توسط این کاربر</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <li>
                                                        <a href="Product.php?id=<?php echo $t->ProductId; ?>"
                                                           title="<?php echo $t->Name; ?>" target="_blank">
                                                            <div class="image-container">
                                                                <img src="../<?php echo $t->Image; ?>"/>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if ($temp == null) {
                                                    $safedelete3 = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/NewsDataSource.inc';
                                    $fp = new NewsDataSource();
                                    $fp->open();
                                    $temp = $fp->GetThisUserNews($_GET['userid']);
                                    $fp->close();
                                    ?>
                                    <div class="block">
                                        <div class="title">خبر های ثبت شده توسط این کاربر</div>
                                        <div class="content">
                                            <ul>
                                                <?php
                                                foreach ($temp as $t) {
                                                    ?>
                                                    <li>
                                                        <a href="Product.php?id=<?php echo $t->NewsId; ?>"
                                                           title="<?php echo $t->Title; ?>"
                                                           target="_blank">
                                                            <div class="image-container">
                                                                <img src="../<?php echo $t->Image; ?>"/>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if ($temp == null) {
                                                    $safedelete4 = 1;
                                                    ?>
                                                    <div class="alert alert-warning">
                                                        هیچ موردی در ارتباط نیست
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="block"></div>


                                    <div class="buttons">
                                        <a onclick='return deleteConfirm()' class="<?php
                                        if (isset($safedelete1) && isset($safedelete2) && isset($safedelete3) && isset($safedelete4)) {
                                            echo 'btn btn-primary btn-w-m';
                                        } else {
                                            echo 'btn btn-danger btn-w-m';
                                        }
                                        ?>"
                                           href="operateUser.php?id=<?php echo $_GET['userid']; ?>">
                                            <i class="fa fa-trash"></i>
                                            حذف کردن
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<?php
include_once 'Template/bottom.php';
