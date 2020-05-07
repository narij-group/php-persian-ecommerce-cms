<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/RoleDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
$rlds = new RoleDataSource();
$rlds->open();
$roles = $rlds->Fill();
$rlds->close();
?>
<?php
include_once 'Template/top.php';
if ($role->Roles != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>نقش ها</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Roles</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>لیست نقش ها</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <?php
                    if ($role->InsertRole == 1) {
                        ?>
                        <a href="Role.php">
                            <button class="btn btn-primary btn-w-m" type="button"><i class="fa fa-plus"></i>
                                افزودن نقش جدید
                            </button>
                        </a>
                        <?php
                    }
                    ?>




                    <div class="roles">
                        <?php
                        $postsCounter = 0;
                        foreach ($roles as $s) {
                            if ($s->Name != 'Admin') {
                                $postsCounter++;
                                echo "<div class='role'>";
                                echo "<div class='role-top'>";
                                echo "<div class='role-id btn btn-success' >" . $s->RoleId . "</div>";
                                echo "<div class='role-title btn btn-info' >" . $s->Name . "</div>";
                                echo "</div>";
                                echo "<div class='clear-fix'></div>";
                                echo "<div class='role-group-title ";
                                if ($s->Products) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>محصولات</div>";
                                if ($s->Products) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertProduct) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditProduct) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteProduct) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                    echo '<div class="product-limit-groups ';
                                    if ($s->ProductApprove) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >نیاز به تایید جهت فعالسازی</div>';
                                    if ($s->ProductGroupLimit) {
                                        echo '<div class="product-limit-groups ';
                                        if ($s->ProductGroupLimit) {
                                            echo ' access';
                                        } else {
                                            echo ' access-denied';
                                        }
                                        echo '">دسترسی دلخواه به دسته بندی ها</div>';
                                        if (trim($s->AllowedProductGroups) != "" && trim($s->AllowedProductGroups) != ",") {
                                            echo '<div class="groups-container">';
                                            $groupsId = explode(",", $s->AllowedProductGroups);
                                            foreach ($groupsId as $gid) {
                                                if (trim($gid) != "") {
                                                    echo '<div class="group access">';
                                                    $group = new GroupDataSource();
                                                    $group->open();
                                                    $g = $group->FindOneGroupBasedOnId($gid);
                                                    $group->close();
                                                    echo $g->Name;
                                                    echo "</div>";
                                                }
                                            }
                                            echo "</div>";
                                        } else {
                                            echo '<div class="groups-container">';
                                            echo '<div class="group access-denied">';
                                            echo 'به هیچ مجموعه ای دسترسی ندارد ( به هیچ محصولی دسترسی ندارد )';
                                            echo "</div>";
                                            echo "</div>";
                                        }

                                        if (trim($s->AllowedProductSubGroups) != "" && trim($s->AllowedProductSubGroups) != ",") {
                                            echo '<div class="groups-container">';
                                            $sgroupsId = explode(",", $s->AllowedProductSubGroups);
                                            foreach ($sgroupsId as $sgid) {
                                                if (trim($sgid) != "") {
                                                    echo '<div class="group access">';
                                                    $sgroup = new SubGroupDataSource();
                                                    $sgroup->open();
                                                    $sg = $sgroup->FindOneSubGroupBasedOnId($sgid);
                                                    $sgroup->close();
                                                    echo $sg->Name;
                                                    echo "</div>";
                                                }
                                            }
                                            echo "</div>";
                                        }
                                        if (trim($s->AllowedProductSupperGroups) != "" && trim($s->AllowedProductSupperGroups) != ",") {
                                            echo '<div class="groups-container">';
                                            $ssgroupsId = explode(",", $s->AllowedProductSupperGroups);
                                            foreach ($ssgroupsId as $ssgid) {
                                                if (trim($ssgid) != "") {
                                                    echo '<div class="group access">';
                                                    $ssgroup = new SupperGroupDataSource();
                                                    $ssgroup->open();
                                                    $ssgroup->SupperGroupId = $ssgid;
                                                    $ssg = $ssgroup->FindOneSupperGroupBasedOnId($ssgid);
                                                    $ssgroup->close();
                                                    echo $ssg->Name;
                                                    echo "</div>";
                                                }
                                            }
                                            echo "</div>";
                                        }
                                    }
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Users) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>کاربر ها</div>";
                                if ($s->Users) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertUser) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditUserCoupon) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteUser) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->UserCoupons) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>کپن مشتری ها</div>";
                                if ($s->UserCoupons) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertUserCoupon) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditUserCoupon) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteUserCoupon) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->ProductCoupons) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>کپن محصولات</div>";
                                if ($s->ProductCoupons) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertProductCoupon) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditProductCoupon) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteProductCoupon) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->FactorProducts) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>سفارشات</div>";
                                if ($s->FactorProducts) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->EditFactorProduct) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->ShippingMethods) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>روش های حمل</div>";
                                if ($s->ShippingMethods) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertShippingMethod) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditShippingMethod) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteShippingMethod) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Shippings) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>حمل و نقل ها</div>";
                                if ($s->Shippings) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertShipping) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditShipping) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteShipping) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->LinkBoxes) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>پیوند ها</div>";
                                if ($s->LinkBoxes) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertLinkBox) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditLinkBox) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteLinkBox) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                    echo '<div class="product-limit-groups ';
                                    if ($s->LinkBoxGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '">دسترسی به گروه ها</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Slides) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>اسلاید ها</div>";
                                if ($s->Slides) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertSlide) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditSlide) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteSlide) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Thumbs) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>ریزعکس ها</div>";
                                if ($s->Thumbs) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertThumb) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditThumb) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteThumb) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Prices) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>قیمت ها</div>";
                                if ($s->Prices) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertPrice) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditPrice) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeletePrice) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                    echo '<div class="product-limit-groups ';
                                    if ($s->PriceChange) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '">استفاده از نوسان قیمت</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Comments) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>پرسش و پاسخ ها</div>";
                                if ($s->Comments) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->EditComment) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteComment) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Discounts) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>تخفیف ها</div>";
                                if ($s->Discounts) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->EditDiscount) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteDiscount) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Brands) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>برند ها</div>";
                                if ($s->Brands) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertBrand) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditBrand) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteBrand) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Customers) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>مشتری ها</div>";
                                if ($s->Customers) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertCustomer) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditCustomer) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteCustomer) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                    echo '<div class="product-limit-groups ';
                                    if ($s->SendSMS) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '">ارسال پیام دلخواه</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->ProductProperties) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>ویژگی های محصولات</div>";
                                if ($s->ProductProperties) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertProductProperty) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditProductProperty) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteProductProperty) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                    if ($s->ProductPropertySubGroupLimit) {
                                        echo '<div class="product-limit-groups ';
                                        if ($s->ProductPropertySubGroupLimit) {
                                            echo ' access';
                                        } else {
                                            echo ' access-denied';
                                        }
                                        echo '">دسترسی دلخواه به زیر زیرمجموعه ها</div>';
                                        if (trim($s->AllowedProductPropertySubGroups) != "" && trim($s->AllowedProductPropertySubGroups) != ",") {
                                            echo '<div class="groups-container">';
                                            $sgroupsId = explode(",", $s->AllowedProductPropertySubGroups);
                                            foreach ($sgroupsId as $sgid) {
                                                if (trim($sgid) != "") {
                                                    echo '<div class="group access">';
                                                    $sgroup = new SupperGroupDataSource();
                                                    $sgroup->open();
                                                    $sg = $sgroup->FindOneSupperGroupBasedOnId($sgid);
                                                    $sgroup->close();
                                                    echo $sg->Name;
                                                    echo "</div>";
                                                }
                                            }
                                            echo "</div>";
                                        } else {
                                            echo '<div class="groups-container">';
                                            echo '<div class="group access-denied">';
                                            echo 'به هیچ زیر مجموعه ای دسترسی ندارد ( به هیچ ویژگی محصولی دسترسی ندارد )';
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    }
                                }

                                echo "<div class='role-group-title margin-top";
                                if ($s->PaymentMethods) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>روش های پرداخت</div>";
                                if ($s->PaymentMethods) {
                                    echo '<div class="core-actions" >';
//                    echo '<div class="core-action ';
//                    if ($s->InsertPaymentMethod) {
//                        echo ' access';
//                    } else {
//                        echo ' access-denied';
//                    }
//                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditPaymentMethod) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
//                    echo '<div class="core-action ';
//                    if ($s->DeletePaymentMethod) {
//                        echo ' access';
//                    } else {
//                        echo ' access-denied';
//                    }
//                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Opinions) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>نظرات</div>";
                                if ($s->Opinions) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->EditOpinion) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteOpinion) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Feeds) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>خبرنامه</div>";
                                if ($s->Feeds) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertFeed) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditFeed) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteFeed) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                    echo '<div class="product-limit-groups ';
                                    if ($s->FeedSendEmail) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '">ارسال ایمیل دلخواه</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Guarantees) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>گارانتی ها</div>";
                                if ($s->Guarantees) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertGuarantee) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditGuarantee) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteGuarantee) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Colors) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>رنگ ها</div>";
                                if ($s->Colors) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertColor) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditColor) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteColor) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Services) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>خدمات</div>";
                                if ($s->Services) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertService) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditService) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteService) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Groups) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>مجموعه ها</div>";
                                if ($s->Groups) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->SubGroups) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>زیرمجموعه ها</div>";
                                if ($s->SubGroups) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertSubGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditSubGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteSubGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->SupperGroups) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>زیر زیرمجموعه ها</div>";
                                if ($s->SupperGroups) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertSupperGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditSupperGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteSupperGroup) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Roles) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>نقش ها</div>";
                                if ($s->Roles) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertRole) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditRole) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteRole) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                }


                                echo "<div class='role-group-title margin-top ";
                                if ($s->News) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>اخبار</div>";
                                if ($s->News) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action ';
                                    if ($s->InsertNews) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >افزودن</div>';
                                    echo '<div class="core-action ';
                                    if ($s->EditNews) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >ویرایش</div>';
                                    echo '<div class="core-action ';
                                    if ($s->DeleteNews) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >حذف</div>';
                                    echo '</div>';
                                    echo '<div class="product-limit-groups ';
                                    if ($s->NewsApprove) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >نیاز به تایید جهت فعالسازی</div>';

                                }


                                echo "<div class='role-group-title margin-top";
                                if ($s->Stats) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>آمار ها</div>";


                                echo "<div class='role-group-title margin-top";
                                if ($s->Settings) {
                                    echo ' access';
                                } else {
                                    echo ' access-denied';
                                }
                                echo "'>تنظیمات</div>";
                                if ($s->Settings) {
                                    echo '<div class="core-actions" >';
                                    echo '<div class="core-action2 ';
                                    if ($s->ColorSettings) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >تنظیمات رنگ بندی</div>';
                                    echo '<div class="core-action2 ';
                                    if ($s->MenuSettings) {
                                        echo ' access';
                                    } else {
                                        echo ' access-denied';
                                    }
                                    echo '" >تنظیمات منو</div>';
                                    echo '</div>';
                                }
                                echo '<div class="role-btn">';
                                if (trim($s->Name) != "Admin") {
                                    if ($role->EditRole == 1) {
                                        echo "<a class='Edit btn btn-warning' href='Role.php?id=" . $s->RoleId . "'>" . "<i class='fa fa-edit'></i>ویرایش" . "</a>";
                                    }
                                    if ($role->DeleteRole == 1) {
                                        echo "<a class='Delete btn btn-danger' href='DeleteConfirm.php?roleid=" . $s->RoleId . "'>" . "<i class='fa fa-trash-o'></i>حذف" . "</a>";
                                    }
                                }
                                echo '</div>';
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
//                echo "<div><span>" . $s->Products . "</div>";
//                echo "<div>" . $s->InsertProduct . " </div>";

include_once 'Template/bottom.php';
    