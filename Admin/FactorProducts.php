<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
$domain = $_SERVER['SERVER_NAME'];
$count = 0;

include_once 'Template/top.php';
if ($role->FactorProducts != 1) {
    header('Location:Index.php');
    die();
}
include_once 'Template/menu.php';


require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/FactorProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProvinceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/BillDataSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ShippingDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';


require_once '../Template/CustomeDate/jdatetime.class.php';
$prv = new Province();
$cllds = new ColorListDataSource();
$ccds = new CustomerDataSource();
$ct = new City();
$shds = new ShippingDataSource();
$fpds = new FactorProductDataSource();
$fpds->open();
if (isset($_GET['code'])) {
    $factorProducts = $fpds->FillByCode($_GET['code']);
    $count = 0;
    foreach ($factorProducts as $f) {
        $count++;
    }
    $printAllowed = TRUE;
} else {
    $factorProducts = $fpds->Fill();
    $printAllowed = FALSE;
}
$fpds->close();

?>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<link rel="stylesheet" href="Template/Styles/print-style.css" type="text/css" media="print"/>
<link href="Template/Styles/plugins/toastr/toastr.min.css" rel="stylesheet">
<style type="text/css">

</style>
<script type="text/javascript">
    $(document).ready(function () {
        $(".productid-image").click(function () {
            var productId = $(this).attr('alt');
            $.ajax({
                url: 'ProductInfo.php',
                type: 'POST',
                data: {productId: productId},
                success: function (result) {
                    $("#modal-content").html(result);
//                    $("#p-info").fadeIn(500);
//                    $("#modalback").fadeIn(250);
                }
            });
        });

        $(".BillCheck").click(function () {
            var code = $(this).attr('alt');
            $.ajax({
                url: 'BillInfo.php',
                type: 'POST',
                data: {code: code},
                success: function (result) {
                    $("#billmodal-content").html(result);
//                    $("#b-info").fadeIn(500);
//                    $("#modalback").fadeIn(250);
                }
            });
        });

        $("#modalback").click(function () {
            $("#p-info").fadeOut(250);
            $("#b-info").fadeOut(250);
            $(".email-modal").fadeOut(250);
            $("#edit-factor").fadeOut(250);
            $("#modalback").fadeOut(500);
        });
        $(".email").click(function () {
            $.ajax({
                url: 'AjaxEmailModal.php',
                type: 'POST',
                data: {customerId: $(this).attr("title")},
                success: function (result) {
                    $("#emailmodal-content").html(result);
//                    $("#modalback").fadeIn(250);
//                    $("#email-modal").fadeIn(500);
                }
            })
        });
        $(".manual").click(function () {
            $('#p-tracecode').val($(this).attr('id'));
//            $("#modalback").fadeIn(250);
//            $("#edit-factor").fadeIn(500);
        });
        $(".cancel-btn").click(function () {
            $("#modalback").fadeOut(500);
            $("#edit-factor").fadeOut(250);
        });
    });
</script>

<div class="modal inmodal fade" id="edit-factorModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>ویرایش دستی
                </h4>
            </div>
            <div class="modal-body">
                <div class="body">انتخاب کنید :</div>
                <input type="hidden" id="p-tracecode" name="p-tracecode" value=""/>
                <div>
                    <select id="paymentmethod" name="paymentmethod" class="form-control m-b"
                            style="width: 100%;font-size: 12px">
                        <option value="-1">روش پرداخت...</option>
                        <option value="1">پرداخت آنلاین</option>
                        <option value="2">پرداخت درب منزل</option>
                        <option value="3">پرداخت آفلاین</option>
                    </select>

                    <select id="paymentstatus" name="paymentstatus" class="form-control m-b"
                            style="width: 100%;font-size: 12px">
                        <option value="-1">وضعیت پرداخت...</option>
                        <option value="0">در حال پرداخت...</option>
                        <option value="1">پرداخت شد</option>
                        <option value="2">شکست خورد</option>
                        <option value="3">توسط کاربر لغو شد</option>
                        <option value="4">هنوز پرداخت نشده</option>
                        <option value="5">در انتظار دریافت فیش</option>
                        <option value="6">پرداخت شد | نبود موجودی!</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                </button>
                <button type="button" id="submit" class="btn btn-primary"
                        data-dismiss="modal">ویرایش
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal inmodal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">


        </div>
    </div>
</div>

<div class="modal inmodal fade" id="billModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="billmodal-content">


        </div>
    </div>
</div>

<div class="modal inmodal fade" id="emailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="emailmodal-content">


        </div>
    </div>
</div>
<!--<div class="success-message" id="success-msg">ایمیل با موفقیت ارسال شد!</div>-->
<div class="modalback" id="modalback"></div>
<div class="product-info" id="p-info"></div>
<div class="email-modal" id="b-info"></div>
<div class="email-modal" id="email-modal"></div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>فاکتور</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Factor</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="FactorProductsTable.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            بازگشت به لیست سفارشات
                        </button>
                    </a>


                    <div class="Database NoBorder">
                        <div class="Database Bordered">
                            <div class="Factor">
                                <?php
                                $priceHolder = 0;
                                $postsCounter = 0;
                                $cshow = 1;
                                $show = 1;
                                $itemcounts = 1;
                                $i = 1;
                                $fpds->open();
                                foreach ($factorProducts

                                         as $c) {
                                //                        $factorProduct->TraceCode = $c->TraceCode;
                                $factorProducts2 = $fpds->FillByCode($c->TraceCode);
                                $count = 0;
                                foreach ($factorProducts2 as $f) {
                                    $count++;
                                }
                                if ($itemcounts != 0) {
                                    $itemscount = (($count - 3) % 3);
                                    if ($itemscount < 0) {
                                        $itemscount = -$itemscount;
                                    }
                                } else {
                                    $itemscount = 0;
                                }
                                if ($c->Services != "") {
                                    $services = "";
                                    $servicesPrice = 0;
                                    $tempservices = explode(',', $c->Services);
                                    foreach ($tempservices as $s) {
                                        $service = explode('-', $s);
                                        $services .= ',' . $service[0];
                                        $servicesPrice += $service[1];
                                    }
                                }

                                if ($cshow == 1) {
                                    ?>
                                    <div class="item comment2 <?php
                                    //                        if ($c->Status == 1) {
                                    //                            echo ' BlueBordered2';
                                    //                        } elseif ($c->Status == 2) {
                                    //                            echo ' GreenBordered2';
                                    //                        } elseif ($c->Status == 3) {
                                    //                            echo ' RedBordered2';
                                    //                        } else {
                                    echo ' Normal';
                                    //                        }
                                    ?>">
                                        <?php
                                        $date2 = explode('/', $c->Date);
                                        $date = new jDateTime(true, true, 'Asia/Tehran');
                                        $time2 = $date->mktime(0, 0, 0, intval($date2[1]), intval($date2[2]), intval($date2[0]), false, 'America/New_York');
                                        echo "<span class='Time2'>" . $date->date('l j F Y', $time2, true, true, 'Asia/Tehran') . "</span>";
                                        echo ' ';
                                        echo "<span class='Time'>$c->Time</span>";
                                        ?>
                                    </div>
                                    <div class="item comment <?php
                                    //                        if ($c->Status == 1) {
                                    //                            echo ' BlueBordered2';
                                    //                        } elseif ($c->Status == 2) {
                                    //                            echo ' GreenBordered2';
                                    //                        } elseif ($c->Status == 3) {
                                    //                            echo ' RedBordered2';
                                    //                        } else {
                                    echo ' Normal';
                                    //                        }
                                    ?>">
                                        <?php echo $c->Comment; ?>
                                    </div>
                                    <?php
                                }
                                $cshow = 0;

                                if (isset($customerId) && isset($factorId)) {
                                    $itemcounts = 1;
                                    if ($c->TraceCode == $traceCode) {
                                        $priceHolder += $c->Count * $c->Price;
                                        $customerId .= "," . $c->Factor->Customer->CustomerId;
                                        $factorId .= "," . $c->FactorProductId;
                                    } else {
                                        $fp = new FactorProductDataSource();
                                        $fp->open();
                                        $fps = $fp->FillByCode($traceCode);

                                        foreach ($fps as $f) {
                                            $c4 = $fp->FindOneFactorProductBasedOnId($f->FactorProductId);
                                        }

                                        $fp->close();
                                        ?>
                                        <div class="factor-overview <?php
                                        if ($c4->Status == 2) {
                                            echo '  Sent';
                                        } elseif ($c4->Status == 1) {
                                            echo ' Preparing';
                                        } elseif ($c4->Status == 3) {
                                            echo ' Canceled';
                                        }
                                        ?>">
                                            <div class="col-md-10">
                                                <div class="customer-info">
                                                    <?php
                                                    $cc = new CustomerDataSource();
                                                    $cc->open();
                                                    //                                        $cc->CustomerId = $c4->Factor->Customer->CustomerId;
                                                    $customer = $cc->FindOneCustomerBasedOnId($c4->Factor->Customer->CustomerId);
                                                    $cc->close();
                                                    $email = $customer->Email;
                                                    ?>

                                                    <div class="name-box">

                                                    <span class="label label-danger" style="width: 100%"
                                                          title="نام مشتری"><i
                                                                class="fa fa-user"></i><?php echo $customer->Name . " " . $customer->Family; ?></span>
                                                    </div>


                                                    <div class="location-box" title="منطقه">
                                                        <i class="fa fa-map-pin"></i>
                                                        <span><?php echo $prv->GetName($customer->Estate); ?>
                                                            / <?php echo $ct->GetName($customer->City); ?> </span>
                                                    </div>

                                                    <div class="address-box" title="آدرس محل زندگی">
                                                        <span><i class="fa fa-road"></i><?php echo $customer->Address; ?></span>
                                                    </div>

                                                    <div class="shipping-box" title="روش حمل و نقل">
                                                        <i class="fa fa-truck"></i>
                                                        <span>
 <?php
 $tempsh = explode('-', $c4->ShippingMethod);
 echo $tempsh[0];
 ?>
                            </span>
                                                    </div>
                                                    <?php
                                                    if ($tempsh[0] != "رایگان") {
                                                        ?>
                                                        <div class="shipping-box-price">
                                        <span><?php

                                            $shds = new ShippingDataSource();
                                            $shds->open();
                                            //                                            $shipping->City = $customer->Estate;
                                            $sh = $shds->FindOneShippingBasedOnProvince($customer->Estate);
                                            $shds->close();
                                            if ($sh == null) {
                                                echo number_format($tempsh[1]) . " تومان";
                                            } else {
                                                echo number_format($sh->Price + $tempsh[1]) . " تومان";
                                            }
                                            ?></span>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        $sh = new Shipping();
                                                        $sh->Price = 0;
                                                    }
                                                    ?>

                                                    <div class="payment-box label label-warning" title="روش پرداخت">
                                                        <i class="fa fa-credit-card-alt"></i>
                                                        <span>
 <?php
 if ($c4->PaymentMethod == 1) {
     echo 'پرداخت آنلاین';
 } elseif ($c4->PaymentMethod == 2) {
     echo 'پرداخت درب منزل';
 } elseif ($c4->PaymentMethod == 3) {
     echo 'پرداخت آفلاین';
 }
 ?>
                            </span>
                                                    </div>
                                                    <div class="payment-box-status label label-success">
                                        <span>
                                            <?php

                                            if ($c4->PaymentStatus == 0) {
                                                echo 'در حال پرداخت...';
                                            } elseif ($c4->PaymentStatus == 1) {
                                                echo 'پرداخت شد';
                                            } elseif ($c4->PaymentStatus == 2) {
                                                echo 'شکست خورد';
                                            } elseif ($c4->PaymentStatus == 3) {
                                                echo 'توسط کاربر لغو شد';
                                            } elseif ($c4->PaymentStatus == 4) {
                                                echo 'هنوز پرداخت نشده';
                                            } elseif ($c4->PaymentStatus == 5) {
                                                echo 'در انتظار دریافت فیش';
                                            } elseif ($c4->PaymentStatus == 6) {
                                                echo ' پرداخت شد | نبود موجودی! ';
                                                echo "(لطفا وجه را به مشتری بازگردانید)";
                                            }

                                            ?>
                                        </span>
                                                    </div>
                                                    <?php
                                                    $bill = new BillDataSource();
                                                    $bill->open();
                                                    $b = $bill->FindByCode($c4->TraceCode);
                                                    $bill->close();
                                                    if ($c4->PaymentStatus == 4 && $c4->Status != 4) {
                                                        echo '<div class="payment-button"><a class="btn btn-primary btn-w-m" onclick="return payedConfirm()" href="BillPayed.php?code=' . $c4->TraceCode . '">مشتری هزینه را پرداخت کرد</a></div>';
                                                    } elseif (($c4->PaymentStatus == 5 || isset($b->Status)) && $c4->Status != 4) {
                                                        echo '<div class="payment-button2"><a class="BillCheck btn btn-primary btn-w-m" data-toggle="modal" data-target="#billModal" alt="' . $c4->TraceCode . '"><div class="red-circle ';
                                                        $bill = new BillDataSource();
                                                        $bill->open();
                                                        $b = $bill->FindByCode($c4->TraceCode);
                                                        $bill->close();
                                                        if ($b != null) {
                                                            if ($b->Status == 0) {
                                                                echo "red";
                                                            } elseif ($b->Status == 1) {
                                                                echo "green notification2";
                                                            } elseif ($b->Status == 2) {
                                                                echo "green";
                                                            } elseif ($b->Status == 3) {
                                                                echo "red notification2";
                                                            }
                                                        } else {
                                                            echo "red";
                                                        }
                                                        echo ' "></div>رسید پرداختی مشتری</a></div>';
                                                    }
                                                    if ($role->EditFactorProduct == 1) {
                                                        ?>

                                                        <div class="payment-button"><a title="تغییرات دستی"
                                                                                       id="<?php echo $c4->TraceCode; ?>"
                                                                                       class="manual btn btn-primary btn-w-m"
                                                                                       data-toggle="modal"
                                                                                       data-target="#edit-factorModal">تغییرات
                                                                دستی</a></div>
                                                        <?php
                                                    }
                                                    if ($c4->PaymentStatus == 3 || $c4->PaymentStatus == 2 || (isset($b->Status) && $b->Status == 3) || $c4->Status == 3 || $c4->Status == 4) {
                                                        ?>
                                                        <div class="payment-button"><a title="حذف این فاکتور"
                                                                                       onclick="return deleteConfirm()"
                                                                                       href="DeleteFactorProduct.php?code=<?php echo $c4->TraceCode; ?>"
                                                                                       class="delete btn btn-danger btn-w-m">حذف
                                                                این فاکتور</a></div>
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($c4->Services != "") {
                                                        ?>

                                                        <div class="services-box">
                                                            <?php
                                                            $svcs = explode(',', $services);
                                                            $i = 1;
                                                            foreach ($svcs as $svc) {
                                                                if ($svc != "") {
                                                                    echo "<div class='num' title='خدمات'><span>$i</span></div>";
                                                                    echo '<span class="service" title="خدمات">';
                                                                    echo $svc;
                                                                    echo '</span>';
                                                                    $i++;
                                                                }
                                                            }
                                                            $priceHolder += $servicesPrice;
                                                            ?>
                                                        </div>

                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($c4->RefId != "") {
                                                        ?>

                                                        <div class="shipping-box" title="کد پیگیری درگاه پرداخت">
                                        <span style="padding-right: 15px; letter-spacing: 0.5px;">
                                        <?php
                                        echo $c->RefId;
                                        ?>
                                        </span>
                                                        </div>

                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="status-nodisplay">
                                <span>وضعیت : <?php
                                    if ($c4->Status == 0) {
                                        echo "در انتظار بررسی";
                                    } elseif ($c4->Status == 1) {
                                        echo 'تایید شد و در پروسه انبار';
                                    } elseif ($c4->Status == 2) {
                                        echo 'ارسال شد';
                                    } elseif ($c4->Status == 3) {
                                        echo 'لغو شد';
                                    } elseif ($c4->Status == 4) {
                                        echo 'توسط مشتری حذف شد';
                                    }
                                    ?></span>
                                                    </div>


                                                    <div class="price-box">
                                <span>
                                    مبلغ پرداخت شده توسط مشتری :
                                    <?php
                                    echo number_format($c4->Amount) . " تومان";
                                    ?>
                                </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="customer-info">
                                                    <div class="phone-box label label-info">
                                                        <i class="fa fa-phone"></i>
                                                        <span><?php echo $customer->Phone; ?> </span>
                                                    </div>

                                                    <div class="mobile-box label label-info">
                                                        <i class="fa fa-phone"></i>
                                                        <span><?php echo $customer->Mobile; ?></span>
                                                    </div>

                                                    <div class="post-box label label-info">
                                                        <i class="fa fa-home"></i>
                                                        <span style="display: inline-block;"><?php echo $customer->PostCode; ?></span>
                                                    </div>


                                                    <?php
                                                    if ($c4->Coupon != 0) {
                                                        ?>
                                                        <div class="coupon-box label label-info" title="تخفیف کپن">
                                                            <i class="fa fa-money"></i>
                                                            <span>-<?php echo number_format($c4->Coupon) . " تومان"; ?></span>
                                                        </div>

                                                        <?php
                                                        $priceHolder -= $c4->Coupon;
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <!--                                <div class="title"><span>اطلاعات مشتری</span></div>-->
                                            <div class="col-md-12" style="margin-bottom: 10px">
                                                <div class="info-buttons">
                                                    <?php
                                                    $cshow = 1;
                                                    if ($role->EditFactorProduct == 1 && $c4->Status != 4 && $c4->PaymentStatus != 0 && $c4->PaymentStatus != 2 && $c4->PaymentStatus != 3) {
                                                        ?>
                                                        <a onclick='return factorSentConfirm()'
                                                           href="FactorSent.php?&status=2<?php echo "&code=" . $c4->TraceCode; ?>"
                                                           class="f-btn done btn btn-primary btn-w-m <?php
                                                           if ($c->Status == 2) {
                                                               echo "Bordered3";
                                                           }
                                                           ?>  ">ارسال شد</a>
                                                        <a onclick='return factorApprovedConfirm()'
                                                           href="FactorSent.php?&status=1<?php echo "&code=" . $c4->TraceCode; ?>"
                                                           class="f-btn preparing btn btn-warning btn-w-m <?php
                                                           if ($c->Status == 1) {
                                                               echo "Bordered3";
                                                           }
                                                           ?>  ">تایید شد و در پروسه انبار</a>
                                                        <a onclick='return factorReturnedConfirm()'
                                                           href="FactorSent.php?status=3<?php echo "&code=" . $c4->TraceCode; ?>"
                                                           class="f-btn returned btn btn-danger btn-w-m <?php
                                                           if ($c->Status == 3) {
                                                               echo "Bordered3";
                                                           }
                                                           ?>  ">لغو شد</a>
                                                        <?php
                                                    }
                                                    if ($role->EditFactorProduct == 1) {
                                                        ?>
                                                        <a title="<?php echo $customer->CustomerId; ?>"
                                                           class="f-btn email btn btn-primary btn-w-m"
                                                           data-toggle='modal' data-target='#emailModal'>ارسال ایمیل</a>
                                                        <?php
                                                    }
                                                    if ($printAllowed) {
                                                        ?>
                                                        <a class="f-btn print btn btn-white"
                                                           onclick="printFunction()">پرینت از صفحه</a>
                                                        <script>
                                                            function printFunction() {
                                                                window.print();
                                                            }
                                                        </script>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                            <div class="clear-fix"></div>
                                        </div>

                                        <?php
                                        echo '</div>';
                                        echo '<div class="clear-fix"></div>';

                                        echo '<div class="Factor" >';

                                        $customerId .= "|" . $c->Factor->Customer->CustomerId;
                                        $factorId .= "|" . $c->FactorProductId;
                                        $traceCode = $c->TraceCode;
                                        $priceHolder = 0;
                                    }
                                } else {
                                    $priceHolder += $c->Count * $c->Price;
                                    $customerId = $c->Factor->Customer->CustomerId;
                                    $traceCode = $c->TraceCode;
                                    $factorId = $c->FactorProductId;
                                }
                                $postsCounter++;
                                if ($cshow == 1) {
                                    ?>
                                    <div class="item comment2 <?php
                                    //                        if ($c->Status == 1) {
                                    //                            echo ' BlueBordered2';
                                    //                        } elseif ($c->Status == 2) {
                                    //                            echo ' GreenBordered2';
                                    //                        } elseif ($c->Status == 3) {
                                    //                            echo ' RedBordered2';
                                    //                        } else {
                                    echo ' Normal';
                                    //                        }
                                    ?>">
                                        <?php
                                        $date2 = explode('/', $c->Date);
                                        $date = new jDateTime(true, true, 'Asia/Tehran');
                                        $time2 = $date->mktime(0, 0, 0, intval($date2[1]), intval($date2[2]), intval($date2[0]), false, 'America/New_York');
                                        echo "<span class='Time2'>" . $date->date('l j F Y', $time2, true, true, 'Asia/Tehran') . "</span>";
                                        echo ' ';
                                        echo "<span class='Time'>$c->Time</span>";
                                        ?>
                                    </div>
                                    <div class="item comment <?php
                                    //                        if ($c->Status == 1) {
                                    //                            echo ' BlueBordered2';
                                    //                        } elseif ($c->Status == 2) {
                                    //                            echo ' GreenBordered2';
                                    //                        } elseif ($c->Status == 3) {
                                    //                            echo ' RedBordered2';
                                    //                        } else {
                                    echo ' Normal';
                                    //                        }
                                    ?>">
                                        <?php echo $c->Comment; ?>
                                    </div>
                                    <?php
                                }
                                $cshow = 0;
                                if ($itemscount == 2 && $count < 3) {
                                    ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="item <?php
                                        //                        if ($c->Status == 1) {
                                        //                            echo ' BlueBordered2';
                                        //                        } elseif ($c->Status == 2) {
                                        //                            echo ' GreenBordered2';
                                        //                        } elseif ($c->Status == 3) {
                                        //                            echo ' RedBordered2';
                                        //                        } else {
                                        echo ' Normal';
                                        //                        }
                                        ?>">
                                            <ul>

                                                <li>
                                                    <div class="image-box"></div>
                                                </li>
                                                <li>
                                                    <div class="guarantee-box" style="height: 30px;"></div>
                                                </li>
                                                <li>
                                                    <div class="name-box"><span class="name"><div
                                                                    class="no-name"></div></span><br/><span
                                                                class="lname"><div
                                                                    class="no-lname"></div></span></div>
                                                </li>
                                                <li>
                                                    <div class="count-box"></div>
                                                </li>
                                                <li>
                                                    <div class="color-box"></div>
                                                </li>
                                                <li style="width: 100%; margin-top: 25px;"><span><div
                                                                class="no-price"></div></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="item <?php
                                    //                    if ($c->Status == 1) {
                                    //                        echo ' BlueBordered2';
                                    //                    } elseif ($c->Status == 2) {
                                    //                        echo ' GreenBordered2';
                                    //                    } elseif ($c->Status == 3) {
                                    //                        echo ' RedBordered2';
                                    //                    } else {
                                    echo ' Normal';
                                    //                    }
                                    ?>">
                                        <ul>
                                            <li>
                                                <div class="image-box">
                                                    <img src="../<?php echo $c->Product->Image; ?>"
                                                         class="productid-image"
                                                         data-toggle='modal' data-target='#productModal'
                                                         alt="<?php echo $c->Product->ProductId; ?>"/>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="guarantee-box"
                                                     title="گارانتی : <?php echo $c->Guarantee; ?>">
                                                    <span class="label label-primary"> <?php echo $c->Guarantee; ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="name-box">
                                                    <span class="name"><?php echo $c->Product->Name; ?></span>
                                                    <br/>
                                                    <span class="lname"><?php echo $c->Product->LatinName; ?></span>
                                                    <br/>
                                                    <?php

                                                    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/LogoDataSource.inc";

                                                    $lds = new LogoDataSource();
                                                    $lds->open();

                                                    //                                        $log = new Logo();
                                                    //                                        $log->LogoId = $c->Product->Brand->LogoId;
                                                    $log = $lds->FindOneLogoBasedOnId($c->Product->Brand->LogoId);
                                                    ?>
                                                    تامین کننده : <span
                                                            class="lname"><?php echo $log->Name; ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="count-box label label-warning"
                                                     title="<?php echo $c->Count; ?> عدد">
                                                    <span><?php echo $c->Count; ?>x</span>
                                                </div>
                                            </li>
                                            <li>
                                                <?php
                                                $cllds->open();
                                                $colorsample = $cllds->FindOneColorSample($c->Color);
                                                $cllds->close();
                                                ?>
                                                <div class="color-box"
                                                     style="background-color: <?php echo $colorsample; ?>;"
                                                     title="<?php echo $c->Color; ?>">
                                                    <span class="color-name"><?php echo $c->Color; ?></span>
                                                </div>
                                            </li>

                                            <li class="PriceContainer">
                                                    <span class="label label-success"><?php echo number_format($c->Count * $c->Price); ?>
                                                        تومان</span>
                                            </li>

                                            <li class="PriceContainer">
                                                    <span class="label label-success"><?php echo $c->Status; ?>
                                                    </span>
                                            </li>
                                    </div>
                                </div>
                            <?php
                            if ($itemscount == 2 && $count < 3) {
                                ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="item <?php
                                    //                        if ($c->Status == 1) {
                                    //                            echo ' BlueBordered2';
                                    //                        } elseif ($c->Status == 2) {
                                    //                            echo ' GreenBordered2';
                                    //                        } elseif ($c->Status == 3) {
                                    //                            echo ' RedBordered2';
                                    //                        } else {
                                    echo ' Normal';
                                    //                        }
                                    ?>">
                                        <ul>
                                            <li>
                                                <div class="image-box"></div>
                                            </li>
                                            <li>
                                                <div class="guarantee-box" style="height: 30px;"></div>
                                            </li>
                                            <li>
                                                <div class="name-box"><span class="name"><div
                                                                class="no-name"></div></span><br/><span
                                                            class="lname"><div
                                                                class="no-lname"></div></span></div>
                                            </li>
                                            <li>
                                                <div class="count-box"></div>
                                            </li>
                                            <li>
                                                <div class="color-box"></div>
                                            </li>
                                            <li style="width: 100%; margin-top: 25px;"><span><div
                                                            class="no-price"></div></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                            if ($itemscount == 1 && !isset($_GET['code'])) {
                            $itemcounts = 0;
                            ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="item <?php
                                    //                        if ($c->Status == 1) {
                                    //                            echo ' BlueBordered2';
                                    //                        } elseif ($c->Status == 2) {
                                    //                            echo ' GreenBordered2';
                                    //                        } elseif ($c->Status == 3) {
                                    //                            echo ' RedBordered2';
                                    //                        } else {
                                    echo ' Normal';
                                    //                        }
                                    ?>">
                                        <ul>
                                            <li>
                                                <div class="image-box"></div>
                                            </li>
                                            <li>
                                                <div class="guarantee-box" style="height: 30px;"></div>
                                            </li>
                                            <li>
                                                <div class="name-box"><span class="name"><div
                                                                class="no-name"></div></span><br/><span
                                                            class="lname"><div
                                                                class="no-lname"></div></span></div>
                                            </li>
                                            <li>
                                                <div class="count-box"></div>
                                            </li>
                                            <li>
                                                <div class="color-box"></div>
                                            </li>
                                            <li style="width: 100%; margin-top: 25px;"><span><div
                                                            class="no-price"></div></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                    <?php
                                    }
                                    }


                                    $fpds->close();
                                    if (($itemscount == 1 && $count < 3) && $itemcounts == 1) {
                                    ?>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="item Normal ">
                                        <ul>
                                            <li>
                                                <div class="image-box"></div>
                                            </li>
                                            <li>
                                                <div class="guarantee-box" style="height: 30px;"></div>
                                            </li>
                                            <li>
                                                <div class="name-box"><span class="name"><div
                                                                class="no-name"></div></span><br/><span class="lname"><div
                                                                class="no-lname"></div></span></div>
                                            </li>
                                            <li>
                                                <div class="count-box"></div>
                                            </li>
                                            <li>
                                                <div class="color-box"></div>
                                            </li>
                                            <li style="width: 100%; margin-top: 25px;"><span><div
                                                            class="no-price"></div></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php
                            }
                            if ($itemcounts == 1 && $count > 3) {
                                ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="item <?php
                                    //                    if ($c->Status == 1) {
                                    //                        echo ' BlueBordered2';
                                    //                    } elseif ($c->Status == 2) {
                                    //                        echo ' GreenBordered2';
                                    //                    } elseif ($c->Status == 3) {
                                    //                        echo ' RedBordered2';
                                    //                    } else {
                                    echo ' Normal';
                                    //                    }
                                    ?>">
                                        <ul>
                                            <li>
                                                <div class="image-box"></div>
                                            </li>
                                            <li>
                                                <div class="guarantee-box" style="height: 30px;"></div>
                                            </li>
                                            <li>
                                                <div class="name-box"><span class="name"><div
                                                                class="no-name"></div></span><br/><span class="lname"><div
                                                                class="no-lname"></div></span></div>
                                            </li>
                                            <li>
                                                <div class="count-box"></div>
                                            </li>
                                            <li>
                                                <div class="color-box"></div>
                                            </li>
                                            <li style="width: 100%; margin-top: 25px;"><span><div
                                                            class="no-price"></div></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="item <?php
                                    //                    if ($c->Status == 1) {
                                    //                        echo ' BlueBordered2';
                                    //                    } elseif ($c->Status == 2) {
                                    //                        echo ' GreenBordered2';
                                    //                    } elseif ($c->Status == 3) {
                                    //                        echo ' RedBordered2';
                                    //                    } else {
                                    echo ' Normal';
                                    //                    }
                                    ?>">
                                        <ul>
                                            <li>
                                                <div class="image-box"></div>
                                            </li>
                                            <li>
                                                <div class="guarantee-box" style="height: 30px;"></div>
                                            </li>
                                            <li>
                                                <div class="name-box"><span class="name"><div
                                                                class="no-name"></div></span><br/><span class="lname"><div
                                                                class="no-lname"></div></span></div>
                                            </li>
                                            <li>
                                                <div class="count-box"></div>
                                            </li>
                                            <li>
                                                <div class="color-box"></div>
                                            </li>
                                            <li style="width: 100%; margin-top: 25px;"><span><div
                                                            class="no-price"></div></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <?php
                            }
                            $fp = new FactorProduct();
                            ?>
                                <div class="factor-overview <?php
                                if ($c->Status == 2) {
                                    echo '  Sent';
                                } elseif ($c->Status == 1) {
                                    echo ' Preparing';
                                } elseif ($c->Status == 3 || $c->Status == 4) {
                                    echo ' Canceled';
                                }
                                ?>">
                                    <div class="col-md-10">
                                        <div class="customer-info">
                                            <?php
                                            $cc = new CustomerDataSource();
                                            $cc->open();
                                            //                                        $cc->CustomerId = $c4->Factor->Customer->CustomerId;
                                            $customer = $cc->FindOneCustomerBasedOnId($c->Factor->Customer->CustomerId);
                                            $cc->close();
                                            $email = $customer->Email;
                                            ?>

                                            <div class="name-box">

                                                    <span class="label label-danger" style="width: 100%"
                                                          title="نام مشتری"><i
                                                                class="fa fa-user"></i><?php echo $customer->Name . " " . $customer->Family; ?></span>
                                            </div>


                                            <div class="location-box" title="منطقه">
                                                <i class="fa fa-map-pin"></i>
                                                <span><?php echo $prv->GetName($customer->Estate); ?>
                                                    / <?php echo $ct->GetName($customer->City); ?> </span>
                                            </div>

                                            <div class="address-box" title="آدرس محل زندگی">
                                                <span><i class="fa fa-road"></i><?php echo $customer->Address; ?></span>
                                            </div>

                                            <div class="shipping-box" title="روش حمل و نقل">
                                                <i class="fa fa-truck"></i>
                                                <span>
 <?php
 $tempsh = explode('-', $c->ShippingMethod);
 echo $tempsh[0];
 ?>
                            </span>
                                            </div>
                                            <?php
                                            if ($tempsh[0] != "رایگان") {
                                                ?>
                                                <div class="shipping-box-price">
                                        <span><?php

                                            $shds = new ShippingDataSource();
                                            $shds->open();
                                            //                                            $shipping->City = $customer->Estate;
                                            $sh = $shds->FindOneShippingBasedOnProvince($customer->Estate);
                                            $shds->close();
                                            if ($sh == null) {
                                                echo number_format($tempsh[1]) . " تومان";
                                            } else {
//                                                echo $sh->Price + $tempsh[1];
//                                                echo  "<br>";
                                                echo number_format($sh->Price + $tempsh[1]) . " تومان";
//                                                echo $tempsh[1];
                                            }
                                            ?></span>
                                                </div>
                                                <?php
                                            } else {
                                                $sh = new Shipping();
                                                $sh->Price = 0;
                                            }
                                            ?>

                                            <div class="payment-box label label-warning" title="روش پرداخت">
                                                <i class="fa fa-credit-card-alt"></i>
                                                <span>
 <?php
 if ($c->PaymentMethod == 1) {
     echo 'پرداخت آنلاین';
 } elseif ($c->PaymentMethod == 2) {
     echo 'پرداخت درب منزل';
 } elseif ($c->PaymentMethod == 3) {
     echo 'پرداخت آفلاین';
 }
 ?>
                            </span>
                                            </div>
                                            <div class="payment-box-status label label-success">
                                        <span>
                                            <?php

                                            if ($c->PaymentStatus == 0) {
                                                echo 'در حال پرداخت...';
                                            } elseif ($c->PaymentStatus == 1) {
                                                echo 'پرداخت شد';
                                            } elseif ($c->PaymentStatus == 2) {
                                                echo 'شکست خورد';
                                            } elseif ($c->PaymentStatus == 3) {
                                                echo 'توسط کاربر لغو شد';
                                            } elseif ($c->PaymentStatus == 4) {
                                                echo 'هنوز پرداخت نشده';
                                            } elseif ($c->PaymentStatus == 5) {
                                                echo 'در انتظار دریافت فیش';
                                            } elseif ($c->PaymentStatus == 6) {
                                                echo ' پرداخت شد | نبود موجودی! ';
                                                echo "(لطفا وجه را به مشتری بازگردانید)";
                                            }

                                            ?>
                                        </span>
                                            </div>
                                            <?php
                                            $bill = new BillDataSource();
                                            $bill->open();
                                            $b = $bill->FindByCode($c->TraceCode);
                                            $bill->close();
                                            if ($c->PaymentStatus == 4 && $c->Status != 4) {
                                                echo '<div class="payment-button"><a class="btn btn-primary btn-w-m" onclick="return payedConfirm()" href="BillPayed.php?code=' . $c4->TraceCode . '">مشتری هزینه را پرداخت کرد</a></div>';
                                            } elseif (($c->PaymentStatus == 5 || isset($b->Status)) && $c->Status != 4) {
                                                echo '<div class="payment-button2"><a class="BillCheck btn btn-primary btn-w-m" data-toggle="modal" data-target="#billModal" alt="' . $c->TraceCode . '"><div class="red-circle ';
                                                $bill = new BillDataSource();
                                                $bill->open();
                                                $b = $bill->FindByCode($c->TraceCode);
                                                $bill->close();
                                                if ($b != null) {
                                                    if ($b->Status == 0) {
                                                        echo "red";
                                                    } elseif ($b->Status == 1) {
                                                        echo "green notification2";
                                                    } elseif ($b->Status == 2) {
                                                        echo "green";
                                                    } elseif ($b->Status == 3) {
                                                        echo "red notification2";
                                                    }
                                                } else {
                                                    echo "red";
                                                }
                                                echo ' "></div>رسید پرداختی مشتری</a></div>';
                                            }
                                            if ($role->EditFactorProduct == 1) {
                                                ?>
                                                <div class="payment-button"><a title="تغییرات دستی"
                                                                               id="<?php echo $c->TraceCode; ?>"
                                                                               class="manual btn btn-primary btn-w-m"
                                                                               data-toggle="modal"
                                                                               data-target="#edit-factorModal">تغییرات
                                                        دستی</a></div>
                                                <?php
                                            }
                                            if ($c->PaymentStatus == 3 || $c->PaymentStatus == 2 || (isset($b->Status) && $b->Status == 3) || $c->Status == 3 || $c->Status == 4) {
                                                ?>
                                                <div class="payment-button"><a title="حذف این فاکتور"
                                                                               onclick="return deleteConfirm()"
                                                                               href="DeleteFactorProduct.php?code=<?php echo $c->TraceCode; ?>"
                                                                               class="delete btn btn-danger btn-w-m">حذف
                                                        این فاکتور</a></div>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if ($c->Services != "") {
                                                ?>

                                                <div class="services-box">
                                                    <?php
                                                    $svcs = explode(',', $services);
                                                    $i = 1;
                                                    foreach ($svcs as $svc) {
                                                        if ($svc != "") {
                                                            echo "<div class='num' title='خدمات'><span>$i</span></div>";
                                                            echo '<span class="service" title="خدمات">';
                                                            echo $svc;
                                                            echo '</span>';
                                                            $i++;
                                                        }
                                                    }
                                                    $priceHolder += $servicesPrice;
                                                    ?>
                                                </div>

                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if ($c->RefId != "") {
                                                ?>

                                                <div class="shipping-box" title="کد پیگیری درگاه پرداخت">
                                        <span style="padding-right: 15px; letter-spacing: 0.5px;">
                                        <?php
                                        echo $c->RefId;
                                        ?>
                                        </span>
                                                </div>

                                                <?php
                                            }
                                            ?>

                                            <div class="status-nodisplay">
                                <span>وضعیت : <?php
                                    if ($c->Status == 0) {
                                        echo "در انتظار بررسی";
                                    } elseif ($c->Status == 1) {
                                        echo 'تایید شد و در پروسه انبار';
                                    } elseif ($c->Status == 2) {
                                        echo 'ارسال شد';
                                    } elseif ($c->Status == 3) {
                                        echo 'لغو شد';
                                    } elseif ($c->Status == 4) {
                                        echo 'توسط مشتری حذف شد';
                                    }
                                    ?></span>
                                            </div>


                                            <div class="price-box">
                                <span>
                                    مبلغ پرداخت شده توسط مشتری :
                                    <?php
                                    echo number_format($c->Amount) . " تومان";
                                    ?>
                                </span>
                                            </div>

                                            <div class="price-box2">
                                <span>
                                    مبلغ کل محصولات :
                                    <?php
                                    echo number_format($priceHolder) . " تومان";
                                    ?>
                                </span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="customer-info">
                                            <div class="phone-box label label-info">
                                                <i class="fa fa-phone"></i>
                                                <span><?php echo $customer->Phone; ?> </span>
                                            </div>

                                            <div class="mobile-box label label-info">
                                                <i class="fa fa-phone"></i>
                                                <span><?php echo $customer->Mobile; ?></span>
                                            </div>

                                            <div class="post-box label label-info">
                                                <i class="fa fa-home"></i>
                                                <span style="display: inline-block;"><?php echo $customer->PostCode; ?></span>
                                            </div>


                                            <?php
                                            if ($c->Coupon != 0) {
                                                ?>
                                                <div class="coupon-box label label-info" title="تخفیف کپن">
                                                    <i class="fa fa-money"></i>
                                                    <span>-<?php echo number_format($c->Coupon) . " تومان"; ?></span>
                                                </div>

                                                <?php
                                                $priceHolder -= $c->Coupon;
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-bottom: 10px">
                                        <div class="info-buttons">
                                            <?php
                                            $cshow = 1;
                                            if ($role->EditFactorProduct == 1 && $c->Status != 4 && $c->PaymentStatus != 0 && $c->PaymentStatus != 2 && $c->PaymentStatus != 3) {
                                                ?>
                                                <a onclick='return factorSentConfirm()'
                                                   href="FactorSent.php?&status=2<?php echo "&code=" . $c->TraceCode; ?>"
                                                   class="f-btn done btn btn-primary btn-w-m <?php
                                                   if ($c->Status == 2) {
                                                       echo "Bordered3";
                                                   }
                                                   ?>  ">ارسال شد</a>
                                                <a onclick='return factorApprovedConfirm()'
                                                   href="FactorSent.php?&status=1<?php echo "&code=" . $c->TraceCode; ?>"
                                                   class="f-btn preparing btn btn-warning btn-w-m <?php
                                                   if ($c->Status == 1) {
                                                       echo "Bordered3";
                                                   }
                                                   ?>  ">تایید شد و در پروسه انبار</a>
                                                <a onclick='return factorReturnedConfirm()'
                                                   href="FactorSent.php?status=3<?php echo "&code=" . $c->TraceCode; ?>"
                                                   class="f-btn returned btn btn-danger btn-w-m <?php
                                                   if ($c->Status == 3) {
                                                       echo "Bordered3";
                                                   }
                                                   ?>  ">لغو شد</a>
                                                <?php
                                            }
                                            if ($role->EditFactorProduct == 1) {
                                                ?>
                                                <a title="<?php echo $customer->CustomerId; ?>"
                                                   class="f-btn email btn btn-primary btn-w-m" data-toggle='modal'
                                                   data-target='#emailModal'>ارسال ایمیل</a>
                                                <?php
                                            }
                                            if ($printAllowed) {
                                                ?>
                                                <a class="f-btn print btn btn-white"
                                                   onclick="printFunction()">پرینت از صفحه</a>
                                                <script>
                                                    function printFunction() {
                                                        window.print();
                                                    }
                                                </script>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="RecordsCounter" style="left: 30px">Total : <?php echo $postsCounter; ?></div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div></div>
<?php
if (isset($_GET['request'])) {
    if ($_GET['request'] == 'approved') {
        $message = "فیش بانکی سفارش شما با کد پیگیری  " . $_GET['code'] . " با موفقیت تایید شد و سفارش شما وارد مراحل بررسی شد. جهت دریافت اطلاعات بیشتر به حساب کاربری خود در سایت مراجعه کنید. با تشکر" . '<br/><br/><a style="float:left;  color:#fff; background-color:#09f; padding:7px; border-radius:50px; font-family:Arial;" href="http://' . $domain . '/UserProfile.php">حساب کاربری</a>';
        ?>
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: 'AjaxSendCustomEmail.php',
                    type: 'POST',
                    data: {text: '<?php echo $message; ?>', email: "<?php echo $email; ?>"},
                    success: function (res) {

                    }
                });
            });
        </script>
        <?php
    } else {
        $message = "فیش بانکی سفارش شما با کد پیگیری  " . $_GET['code'] . " متاسفانه رد شده است، شما می توانید اطلاعات فیش بانکی خود را در صفحه حساب کاربری خود ویرایش کنید. با تشکر" . '<br/><br/><a style="float:left;  color:#fff; background-color:#09f; padding:7px; border-radius:50px; font-family:Arial;" href="http://' . $domain . '/UserProfile.php">حساب کاربری</a>';
        ?>
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: 'AjaxSendCustomEmail.php',
                    type: 'POST',
                    data: {text: '<?php echo $message; ?>', email: "<?php echo $email; ?>"},
                    success: function (res) {

                    }
                });
            });
        </script>
        <?php
    }
}

include_once 'Template/bottom.php';
