<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
include_once 'Template/top3.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SpecialOfferTitleDataSource.inc';
$group = new GroupDataSource();
$group->open();
$groups = $group->Fill();
$group->close();


$productcolor = new ProductColor();
session_start();
$product = new ProductDataSource();

if ((trim($_SESSION[SESSION_STRING_GROUP_CK]) == "" && trim($_SESSION[SESSION_STRING_SUB_GROUP_CK]) == "" && trim($_SESSION[SESSION_STRING_SUPPER_GROUP_CK]) == "" && trim($_SESSION[SESSION_STRING_SPECIAL_OFFER]) == "" && trim($_SESSION[SESSION_STRING_ORDER_CK]) == "ProductId" && trim($_SESSION[SESSION_STRING_ORDER_TYPE_CK]) == "DESC" && trim($_SESSION[SESSION_STRING_SEARCH_KEY_CK]) == "") || (isset($_POST['search_box']) && trim($_POST['search_box']) == "")) {
    $product->open();
    $products = $product->Fill();
    $product->close();
} elseif (trim($_SESSION[SESSION_STRING_SPECIAL_OFFER]) != "") {
    $product->open();
    $products = $product->FindSpecialOffers2($_SESSION[SESSION_STRING_SPECIAL_OFFER]);
    $product->close();
} else {
    $product->open();
    $products = $product->AdvancedSearchProducts($_SESSION[SESSION_STRING_GROUP_CK], $_SESSION[SESSION_STRING_SUB_GROUP_CK], $_SESSION[SESSION_STRING_SUPPER_GROUP_CK], $_SESSION[SESSION_STRING_ORDER_CK], $_SESSION[SESSION_STRING_ORDER_TYPE_CK], $_SESSION[SESSION_STRING_SEARCH_KEY_CK]);
    $product->close();
}
$_SESSION[SESSION_INT_CURRENT_PAGE] = $_POST['page'];
?>
<?php
if ($products != NULL) {
    ?>
    <div class="Database">
        <div class="db-cover" id="wait">        
            <span class="loading-title <?php
            if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                echo " SBackground'";
            } else {
                echo " GBackground'";
            }
            ?>">Loading...</span>
            <img class="loading-gif" src="Template/Images/gifs/giphy (3).gif" alt=""/>
        </div>
        <form id="products-form">
            <input type="hidden" value="<?php echo $user1->UserId; ?>" id="user" name="user"/>
            <div class="modal inmodal fade" id="deleteModal" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                            <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>اخطار
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="body">آیا میخواهید این موارد را حذف کنید ؟</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">خیر
                            </button>
                            <button type="button" id="delete-confirm-btn" class="btn btn-primary"
                                    data-dismiss="modal">بله
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal inmodal fade" id="sortModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>انتقال</h4>
                        </div>
                        <div class="modal-body">
                            <div class="body">دسته بندی مورد نظر را انتخاب کنید :</div>
                            <div>
                                <select id="group2" name="group2" class="form-control m-b">
                                    <option value="0" id="group-s" name='group-s'>مجموعه...</option>
                                    <?php
                                    if ($role->ProductGroupLimit) {
                                        foreach ($groups as $gp) {
                                            if (strpos($role->AllowedProductGroups, $gp->GroupId) != false) {
                                                echo '<option value="' . $gp->GroupId . '" >';
                                                echo $gp->Name;
                                                echo '</option>';
                                            }
                                        }
                                    } else {
                                        foreach ($groups as $gp) {
                                            echo '<option value="' . $gp->GroupId . '" >';
                                            echo $gp->Name;
                                            echo '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <span id="subgroup-td2">
                                <select id="subgroup2" name="subgroup2" class="form-control m-b" disabled>
                                    <option>زیر مجموعه...</option>
                                </select>
                            </span>
                                <span id="suppergroup-td2">
                                <select id="suppergroup2" name="suppergroup2" class="form-control m-b" disabled>
                                    <option>زیر زیر مجموعه...</option>
                                </select>
                            </span>
                            </div>
                            <div class="alert alert-warning">
                                توجه! تغییر "مجموعه" منجر به پاک شدن ویژگی محصولات میشود!
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">بستن</button>
                            <button type="button" id="sort-confirm-btn" class="btn btn-primary" data-dismiss="modal">انتقال</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal inmodal fade" id="statusModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>وضعیت</h4>
                        </div>
                        <div class="modal-body">
                            <div class="body">وضعیت را انتخاب کنید :</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">بستن</button>
                            <button type="button" id="activate-confirm-btn" class="btn btn-primary" data-dismiss="modal" style="float: left">فعال</button>
                            <button type="button" id="deactivate-confirm-btn" class="btn btn-danger" data-dismiss="modal" style="float: left">غیرفعال</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal inmodal fade" id="specialofferModal" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                            <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>پیشنهاد
                                ویژه</h4>
                        </div>
                        <div class="modal-body">
                            <div class="body">حالت مورد نظر و دسته بندی را انتخاب کنید :</div>
                            <select id="specialoffers" name="specialoffers"
                                    class="form-control m-b" style="padding: 0;margin-top: 10px">
                                <option value="">انتخاب کنید...</option>
                                <?php
                                require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SpecialOfferTitleDataSource.inc';
                                $stds = new SpecialOfferTitleDataSource();
                                $stds->open();
                                $specialoffertitle = $stds->Fill();
                                $stds->close();
                                foreach ($specialoffertitle as $st) {
                                    echo '<option value="' . $st->SpecialOfferTitleId . '"';
                                    if (isset($_SESSION[SESSION_STRING_SPECIAL_OFFER]) && $_SESSION[SESSION_STRING_SPECIAL_OFFER] == $st->SpecialOfferTitleId) {
                                        echo ' selected ';
                                    }
                                    echo '>';
                                    echo $st->Title;
                                    echo '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                            </button>
                            <button type="button" id="add-confirm-btn" class="btn btn-primary"
                                    data-dismiss="modal" style="float: left">افزودن به پیشنهادات
                                ویژه
                            </button>
                            <button type="button" id="remove-confirm-btn" class="btn btn-danger"
                                    data-dismiss="modal" style="float: left">حذف از پیشنهادات ویژه
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal inmodal fade" id="discountModal" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                            <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>تخفیف
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="body">درصد تخفیف :</div>
                            <input type="number" class="form-control input-sm m-b-xs" id="discount" name="discount" placeholder="چند درصد...؟"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                            </button>
                            <button type="button" id="discount-confirm-btn" class="btn btn-primary"
                                    data-dismiss="modal">تمام
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal inmodal fade" id="couponModal" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                            <h4 class="modal-title"><i class="fa fa-warning text-danger m-xs"></i>کپن
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="body">تعداد کپن :</div>
                            <input type="number" id="coupon" name="coupon"
                                   placeholder="چند کپن به تعداد کپن فعلی محصولات اضافه شود...؟"
                                   class="form-control input-sm m-b-xs"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">بستن
                            </button>
                            <button type="button" id="coupon-confirm-btn" class="btn btn-primary"
                                    data-dismiss="modal">تمام
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <input type="hidden" id="action" name="action" value="none"/>
            </div>
            <style>
                .checkboxFour input, .checkboxFour2 input {
                    font-size: 0;
                }

                .checkboxFour, .checkboxFour2, .checkbox-circle {
                    z-index: 1;

                    /*width: 30px;*/
                    /*height: 30px;*/

                    /*background: #ddd;*/
                    /*border-radius: 100%;*/
                    float: right;
                    top: -5px;
                    right: 0;
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
                    top: 2px;
                    left: 2px;
                    z-index: 999;

                    background: #333;
                }

                .checkboxFour input[type=checkbox]:checked + label, .checkboxFour2 input[type=checkbox]:checked + label {
                    background: #26ca28;
                }
            </style>
            <div class="ScrollViewDiv">
                <table class="footable table table-stripped" data-page-size="1000000000" data-filter=#filter>
                    <thead>
                    <tr>
                        <th data-sort-ignore="true">شناسه
                            <div class='checkbox checkbox-info checkbox-circle' style='margin-right : 5px;'><input
                                        type='checkbox'
                                        value='checkall'
                                        id='checkall'
                                        name='checkall'/><label
                                        for='checkall'></label></div>
                        </th>
                        <th data-hide="phone,tablet">تصویر</th>
                        <th>عنوان</th>
                        <th data-hide="phone,tablet">تعداد</th>
                        <th data-hide="phone,tablet">بازدید</th>
                        <th data-hide="phone,tablet" data-sort-ignore="true"></th>
                        <th data-hide="phone,tablet" id="th1" data-sort-ignore="true"></th>
                        <!--                        --><?php
                        //                        if ($role->DeleteProduct == 1 || $role->EditProduct == 1) {
                        //                            ?>
                        <!--                            <th data-hide="phone,tablet" id="th2" data-sort-ignore="true"></th>-->
                        <!--                            --><?php
                        //                        }
                        //                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
                    <?php
                    $i = 0;
                    $j = $_SESSION[SESSION_STRING_ENTRY];
                    if ($role->ProductGroupLimit) {
                        foreach ($products as $p1) {
                            if (strpos($role->AllowedProductGroups, $p1->Group->GroupId) != false && strpos($role->AllowedProductSubGroups, $p1->SubGroup->SubGroupId) != false && strpos($role->AllowedProductSupperGroups, $p1->SupperGroup->SupperGroupId) != false) {
                                $i++;
                            }
                        }
                    } else {
                        foreach ($products as $p1) {
                            $i++;
                        }
                    }
                    $pages = ceil($i / $j);
                    $pp2 = 1;
                    $postsCounter = 0;
                    $counter2 = 0;
                    if ($role->ProductGroupLimit) {
                        foreach ($products as $p) {
                            if (strpos($role->AllowedProductGroups, $p->Group->GroupId) != false && strpos($role->AllowedProductSubGroups, $p->SubGroup->SubGroupId) != false && strpos($role->AllowedProductSupperGroups, $p->SupperGroup->SupperGroupId) != false) {
                                $counter2++;
                                if ($_SESSION[SESSION_STRING_ENTRY] == 'all') {

                                    if (substr($p->Image, 0, 1) == "/") {
                                        $imgsrc = $p->Image;
                                    } elseif ($p->Image != "") {
                                        $imgsrc = "/" . $p->Image;
                                    } else {
                                        $imgsrc = "";
                                    }

                                    $price = new Price();
//                                $menu = new Menu();

//                                $protocol = new Protocol();

//                                $pprotocol = $protocol->GetProtocolsForOneProduct($p->ProductId);
                                    $guarantee = new GuaranteeDataSource();
                                    $guarantee->open();
                                    $pguarantee = $guarantee->GetGuaranteesForOneProduct($p->ProductId);
                                    $guarantee->close();
                                    $pcolor = new ProductColorDataSource();
                                    $pcolor->open();
                                    $ppcolor = $pcolor->GetProductColorsForOneProduct($p->ProductId);
                                    $pcolor->close();

                                    $stds = new StatDataSource();
                                    $stds->open();
                                    $stats = $stds->GetStatsCountForOneProduct($p->ProductId);
                                    $stds->close();

                                    $sotds = new SpecialOfferTitleDataSource();
                                    $sotds->open();
                                    $specialoffer = $sotds->IsSpecialOfferByProduct($p->ProductId);
                                    $sotds->close();
//                                $pmenu = $menu->GetMenusForOneProduct($p->ProductId);
                                    ?>
                                    <div class="product-info" id="p-info<?php echo $p->ProductId; ?>">
                                    </div>
                                    <?php
                                    $postsCounter++;
                                    echo "<tr>";
                                    echo "<td><div class='DatabaseField' >";
                                    echo "<div class='new-status'>";
                                    if ($p->Activated == 1) {
                                        echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                    } else {
                                        echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                    }
                                    echo '</div>';
                                    echo "" . $p->ProductId . "<div class='checkbox checkbox-info checkbox-circle'><input type='checkbox'  value='" . $p->ProductId . "' id='check" . $p->ProductId . "' ";
                                    echo " name='check_list[]' class='acheck' /><label for='check" . $p->ProductId . "'></label></div>";
                                    echo "</div></td>";
                                    echo "<td><img src='$imgsrc' alt='' class='img-table' /></td>";

                                    echo "<td><div class='DatabaseField LineHeight' >";
                                    echo '<div class="product-title"><b>';
                                    if (strlen($p->Name) > 55) {
                                        $str = substr($p->Name, 0, 55) . '...';
                                        echo $str;
                                    } else {
                                        echo $p->Name;
                                    }
                                    echo "</b></div>";
                                    echo '<div class="product-title">';
                                    if (strlen($p->LatinName) > 45) {
                                        $str = substr($p->LatinName, 0, 45) . '...';
                                        echo $str;
                                    } else {
                                        echo $p->LatinName;
                                    }
                                    echo "</div>";
                                    echo "</div></td>";
                                    echo "<td><div class='DatabaseField quantity' id='quantity" . $p->ProductId . "' data-toggle='modal' data-target='#quantityModal'>";
                                    if ($p->User->Username != 0) {
                                        echo $p->User->Username . " عدد";
                                    } else {
                                        echo 'هیچی';
                                    }
                                    echo "</div></td>";
                                    echo "<td>" . $stats . "</td>";
                                    echo "<td><div class='DatabaseField options-container' >";
                                    echo '<div class="product-meta ';
                                    if (strlen($p->MetaDescription) < 80) {
                                        echo 'meta-red';
                                    } elseif (strlen($p->MetaDescription) >= 80 && strlen($p->MetaDescription) < 135) {
                                        echo 'meta-yellow';
                                    } elseif (strlen($p->MetaDescription) >= 135 && strlen($p->MetaDescription) <= 165) {
                                        echo 'meta-green';
                                    } else {
                                        echo 'meta-yellow';
                                    }
                                    echo '" title="وضعیت متا (توضیحات متا)">';
                                    echo "</div>";
                                    echo '<span class="product-group2 label label-warning" title="دسته بندی">';
                                    $grouplname = explode(" ", $p->SubGroup->LatinName);
                                    $subgrouplname = explode(" ", $p->SupperGroup->LatinName);
                                    if (count($grouplname) > 2) {
                                        echo $grouplname[0] . '...';
                                    } else {
                                        echo $p->SubGroup->LatinName;
                                    }
                                    echo " > ";
                                    if (count($subgrouplname) > 2) {
                                        echo $subgrouplname[0] . '...';
                                    } else {
                                        echo $p->SupperGroup->LatinName;
                                    }
                                    echo "</span>";
                                    echo '<button class="product-price btn btn-primary " data-toggle="modal" data-target="#priceModal" type="button" id="price' . $p->ProductId . '" title="قیمت محصول">';
                                    echo number_format($p->User->Family) . " تومان";
                                    echo "</button>";
                                    echo "</br>";
                                    echo '<span class="product-group label label-info" title="دسته بندی">';
                                    $groupname = explode(" ", $p->SubGroup->Name);
                                    $subgroupname = explode(" ", $p->SupperGroup->Name);
                                    if (count($groupname) > 2) {
                                        echo $groupname[0] . ' ' . $groupname[1] . '...';
                                    } else {
                                        echo $p->SubGroup->Name;
                                    }
                                    echo " > ";
                                    if (count($subgroupname) > 2) {
                                        echo $subgroupname[0] . '...';
                                    } else {
                                        echo $p->SupperGroup->Name;
                                    }
                                    echo "</span>";
                                    if ($p->User->Name != 0) {
                                        echo '<span class="product-discount label label-danger" title="تخفیف">';
                                        echo number_format($p->User->Name) . "%";
                                        echo "</span>";
                                    }
                                    if ($specialoffer == 1) {
                                        echo '<span class="product-specialoffer label label-primary" title="پیشنهاد ویژه">';
                                            echo '<i class="fa fa-diamond" style="font-size: 14px;line-height: 17px"></i>';
                                        echo "</span>";
                                    }
                                    $word = explode(",", $p->Keywords);
                                    $words = 0;
                                    foreach ($word as $w) {
                                        $words++;
                                    }
                                    echo '<div class="product-meta ';
                                    if ($words < 5) {
                                        echo 'meta-red';
                                    } elseif ($words >= 5 && $words < 15) {
                                        echo 'meta-yellow';
                                    } else {
                                        echo 'meta-green';
                                    }
                                    echo '" title="وضعیت متا (کلمات کلیدی)">';
                                    echo "</div>";
                                    if ($p->User->UserId != 0) {
                                        echo '<span class="product-coupon label label-primary" title="کپن دریافتی برای خرید محصول">';
                                        echo number_format($p->User->UserId) . " کپن";
                                        echo "</span>";
                                    }
                                    echo "</div></td>";
                                    echo "<td><div class='btn-group'><button class='product-id3 btn-white btn btn-xs m-md' data-toggle='modal' data-target='#productModal' type='button' title='More Information' value='" . $p->ProductId . "'>اطلاعات</button>";
                                    echo "<button class='btn-white btn btn-xs m-md' title='View'><a target='_blank' href='../Post.php?id=$p->ProductId'>" . "نمایش" . "</a></button>";
                                    if ($role->EditProduct == 1) {
                                        echo "<button class='btn-white btn btn-xs m-md' title='Edit'><a href='Product.php?id=" . $p->ProductId . "'>" . "ویرایش" . "</a></button>";
                                    }
                                    if ($role->DeleteProduct == 1) {
                                        echo "<button class='btn-white btn btn-xs m-md' title='Delete'><a onclick='return deleteConfirm()' href='DeleteProduct.php?id=" . $p->ProductId . "'>" . "حذف" . "</a></button>";
                                    }
                                    echo '</div></td>';
                                    echo "</tr>";
                                } elseif (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == TRUE && ($_SESSION[SESSION_INT_CURRENT_PAGE] * $_SESSION[SESSION_STRING_ENTRY]) - ($_SESSION[SESSION_STRING_ENTRY] - 1) <= $pp2 && $pp2 <= $_SESSION[SESSION_INT_CURRENT_PAGE] * $_SESSION[SESSION_STRING_ENTRY]) {

                                    if (substr($p->Image, 0, 1) == "/") {
                                        $imgsrc = $p->Image;
                                    } elseif ($p->Image != "") {
                                        $imgsrc = "/" . $p->Image;
                                    } else {
                                        $imgsrc = "";
                                    }

                                    $price = new Price();
//                                $menu = new Menu();

                                    $guarantee = new GuaranteeDataSource();
                                    $guarantee->open();
                                    $pguarantee = $guarantee->GetGuaranteesForOneProduct($p->ProductId);
                                    $guarantee->close();
                                    $pcolor = new ProductColorDataSource();
                                    $pcolor->open();
                                    $ppcolor = $pcolor->GetProductColorsForOneProduct($p->ProductId);
                                    $pcolor->close();

                                    $stds = new StatDataSource();
                                    $stds->open();
                                    $stats = $stds->GetStatsCountForOneProduct($p->ProductId);
                                    $stds->close();

                                    $sotds = new SpecialOfferTitleDataSource();
                                    $sotds->open();
                                    $specialoffer = $sotds->IsSpecialOfferByProduct($p->ProductId);
                                    $sotds->close();
//                                $pmenu = $menu->GetMenusForOneProduct($p->ProductId);
                                    ?>
                                    <div class="product-info" id="p-info<?php echo $p->ProductId; ?>">
                                    </div>
                                    <?php
                                    $postsCounter++;
                                    echo "<tr>";
                                    echo "<td><div class='DatabaseField' >";
                                    echo "<div class='new-status'>";
                                    if ($p->Activated == 1) {
                                        echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                    } else {
                                        echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                    }
                                    echo '</div>';
                                    echo "" . $p->ProductId . "<div class='checkbox checkbox-info checkbox-circle'><input type='checkbox'  value='" . $p->ProductId . "' id='check" . $p->ProductId . "' ";
                                    echo " name='check_list[]' class='acheck' /><label for='check" . $p->ProductId . "'></label></div>";
                                    echo "</div></td>";
                                    echo "<td><img src='$imgsrc' alt='' class='img-table' /></td>";

                                    echo "<td><div class='DatabaseField LineHeight' >";
                                    echo '<div class="product-title"><b>';
                                    if (strlen($p->Name) > 55) {
                                        $str = substr($p->Name, 0, 55) . '...';
                                        echo $str;
                                    } else {
                                        echo $p->Name;
                                    }
                                    echo "</b></div>";
                                    echo '<div class="product-title">';
                                    if (strlen($p->LatinName) > 45) {
                                        $str = substr($p->LatinName, 0, 45) . '...';
                                        echo $str;
                                    } else {
                                        echo $p->LatinName;
                                    }
                                    echo "</div>";
                                    echo "</div></td>";
                                    echo "<td><div class='DatabaseField quantity' id='quantity" . $p->ProductId . "' data-toggle='modal' data-target='#quantityModal'>";
                                    if ($p->User->Username != 0) {
                                        echo $p->User->Username . " عدد";
                                    } else {
                                        echo 'هیچی';
                                    }
                                    echo "</div></td>";
                                    echo "<td>" . $stats . "</td>";
                                    echo "<td><div class='DatabaseField options-container' >";
                                    echo '<div class="product-meta ';
                                    if (strlen($p->MetaDescription) < 80) {
                                        echo 'meta-red';
                                    } elseif (strlen($p->MetaDescription) >= 80 && strlen($p->MetaDescription) < 135) {
                                        echo 'meta-yellow';
                                    } elseif (strlen($p->MetaDescription) >= 135 && strlen($p->MetaDescription) <= 165) {
                                        echo 'meta-green';
                                    } else {
                                        echo 'meta-yellow';
                                    }
                                    echo '" title="وضعیت متا (توضیحات متا)">';
                                    echo "</div>";
                                    echo '<span class="product-group2 label label-warning" title="دسته بندی">';
                                    $grouplname = explode(" ", $p->SubGroup->LatinName);
                                    $subgrouplname = explode(" ", $p->SupperGroup->LatinName);
                                    if (count($grouplname) > 2) {
                                        echo $grouplname[0] . '...';
                                    } else {
                                        echo $p->SubGroup->LatinName;
                                    }
                                    echo " > ";
                                    if (count($subgrouplname) > 2) {
                                        echo $subgrouplname[0] . '...';
                                    } else {
                                        echo $p->SupperGroup->LatinName;
                                    }
                                    echo "</span>";
                                    echo '<button class="product-price btn btn-primary " data-toggle="modal" data-target="#priceModal" type="button" id="price' . $p->ProductId . '" title="قیمت محصول">';
                                    echo number_format($p->User->Family) . " تومان";
                                    echo "</button>";
                                    echo "</br>";
                                    echo '<span class="product-group label label-info" title="دسته بندی">';
                                    $groupname = explode(" ", $p->SubGroup->Name);
                                    $subgroupname = explode(" ", $p->SupperGroup->Name);
                                    if (count($groupname) > 2) {
                                        echo $groupname[0] . ' ' . $groupname[1] . '...';
                                    } else {
                                        echo $p->SubGroup->Name;
                                    }
                                    echo " > ";
                                    if (count($subgroupname) > 2) {
                                        echo $subgroupname[0] . '...';
                                    } else {
                                        echo $p->SupperGroup->Name;
                                    }
                                    echo "</span>";
                                    if ($p->User->Name != 0) {
                                        echo '<span class="product-discount label label-danger" title="تخفیف">';
                                        echo number_format($p->User->Name) . "%";
                                        echo "</span>";
                                    }
                                    if ($specialoffer == 1) {
                                        echo '<span class="product-specialoffer label label-primary" title="پیشنهاد ویژه">';
                                            echo '<i class="fa fa-diamond" style="font-size: 14px;line-height: 17px"></i>';
                                        echo "</span>";
                                    }
                                    $word = explode(",", $p->Keywords);
                                    $words = 0;
                                    foreach ($word as $w) {
                                        $words++;
                                    }
                                    echo '<div class="product-meta ';
                                    if ($words < 5) {
                                        echo 'meta-red';
                                    } elseif ($words >= 5 && $words < 15) {
                                        echo 'meta-yellow';
                                    } else {
                                        echo 'meta-green';
                                    }
                                    echo '" title="وضعیت متا (کلمات کلیدی)">';
                                    echo "</div>";
                                    if ($p->User->UserId != 0) {
                                        echo '<span class="product-coupon label label-primary" title="کپن دریافتی برای خرید محصول">';
                                        echo number_format($p->User->UserId) . " کپن";
                                        echo "</span>";
                                    }
                                    echo "</div></td>";
                                    echo "<td><div class='btn-group'><button class='product-id3 btn-white btn btn-xs m-md' data-toggle='modal' data-target='#productModal' type='button' title='More Information' value='" . $p->ProductId . "'>اطلاعات</button>";
                                    echo "<button class='btn-white btn btn-xs m-md' title='View'><a target='_blank' href='../Post.php?id=$p->ProductId'>" . "نمایش" . "</a></button>";
                                    if ($role->EditProduct == 1) {
                                        echo "<button class='btn-white btn btn-xs m-md' title='Edit'><a href='Product.php?id=" . $p->ProductId . "'>" . "ویرایش" . "</a></button>";
                                    }
                                    if ($role->DeleteProduct == 1) {
                                        echo "<button class='btn-white btn btn-xs m-md' title='Delete'><a onclick='return deleteConfirm()' href='DeleteProduct.php?id=" . $p->ProductId . "'>" . "حذف" . "</a></button>";
                                    }
                                    echo '</div></td>';
                                    echo "</tr>";
                                } elseif (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == FALSE && 1 <= $pp2 && $pp2 <= $_SESSION[SESSION_STRING_ENTRY]) {

                                    if (substr($p->Image, 0, 1) == "/") {
                                        $imgsrc = $p->Image;
                                    } elseif ($p->Image != "") {
                                        $imgsrc = "/" . $p->Image;
                                    } else {
                                        $imgsrc = "";
                                    }

                                    $price = new Price();

                                    $guarantee = new GuaranteeDataSource();
                                    $guarantee->open();
                                    $pguarantee = $guarantee->GetGuaranteesForOneProduct($p->ProductId);
                                    $guarantee->close();
                                    $pcolor = new ProductColorDataSource();
                                    $pcolor->open();
                                    $ppcolor = $pcolor->GetProductColorsForOneProduct($p->ProductId);
                                    $pcolor->close();

                                    $stds = new StatDataSource();
                                    $stds->open();
                                    $stats = $stds->GetStatsCountForOneProduct($p->ProductId);
                                    $stds->close();

                                    $sotds = new SpecialOfferTitleDataSource();
                                    $sotds->open();
                                    $specialoffer = $sotds->IsSpecialOfferByProduct($p->ProductId);
                                    $sotds->close();
                                    ?>
                                    <div class="product-info" id="p-info<?php echo $p->ProductId; ?>">
                                    </div>
                                    <?php
                                    $postsCounter++;
                                    echo "<tr>";
                                    echo "<td><div class='DatabaseField' >";
                                    echo "<div class='new-status'>";
                                    if ($p->Activated == 1) {
                                        echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                    } else {
                                        echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                    }
                                    echo '</div>';
                                    echo "" . $p->ProductId . "<div class='checkbox checkbox-info checkbox-circle'><input type='checkbox'  value='" . $p->ProductId . "' id='check" . $p->ProductId . "' ";
                                    echo " name='check_list[]' class='acheck' /><label for='check" . $p->ProductId . "'></label></div>";
                                    echo "</div></td>";
                                    echo "<td><img src='$imgsrc' alt='' class='img-table' /></td>";

                                    echo "<td><div class='DatabaseField LineHeight' >";
                                    echo '<div class="product-title"><b>';
                                    if (strlen($p->Name) > 55) {
                                        $str = substr($p->Name, 0, 55) . '...';
                                        echo $str;
                                    } else {
                                        echo $p->Name;
                                    }
                                    echo "</b></div>";
                                    echo '<div class="product-title">';
                                    if (strlen($p->LatinName) > 45) {
                                        $str = substr($p->LatinName, 0, 45) . '...';
                                        echo $str;
                                    } else {
                                        echo $p->LatinName;
                                    }
                                    echo "</div>";
                                    echo "</div></td>";
                                    echo "<td><div class='DatabaseField quantity' id='quantity" . $p->ProductId . "' data-toggle='modal' data-target='#quantityModal'>";
                                    if ($p->User->Username != 0) {
                                        echo $p->User->Username . " عدد";
                                    } else {
                                        echo 'هیچی';
                                    }
                                    echo "</div></td>";
                                    echo "<td>" . $stats . "</td>";
                                    echo "<td><div class='DatabaseField options-container' >";
                                    echo '<div class="product-meta ';
                                    if (strlen($p->MetaDescription) < 80) {
                                        echo 'meta-red';
                                    } elseif (strlen($p->MetaDescription) >= 80 && strlen($p->MetaDescription) < 135) {
                                        echo 'meta-yellow';
                                    } elseif (strlen($p->MetaDescription) >= 135 && strlen($p->MetaDescription) <= 165) {
                                        echo 'meta-green';
                                    } else {
                                        echo 'meta-yellow';
                                    }
                                    echo '" title="وضعیت متا (توضیحات متا)">';
                                    echo "</div>";
                                    echo '<span class="product-group2 label label-warning" title="دسته بندی">';
                                    $grouplname = explode(" ", $p->SubGroup->LatinName);
                                    $subgrouplname = explode(" ", $p->SupperGroup->LatinName);
                                    if (count($grouplname) > 2) {
                                        echo $grouplname[0] . '...';
                                    } else {
                                        echo $p->SubGroup->LatinName;
                                    }
                                    echo " > ";
                                    if (count($subgrouplname) > 2) {
                                        echo $subgrouplname[0] . '...';
                                    } else {
                                        echo $p->SupperGroup->LatinName;
                                    }
                                    echo "</span>";
                                    echo '<button class="product-price btn btn-primary " data-toggle="modal" data-target="#priceModal" type="button" id="price' . $p->ProductId . '" title="قیمت محصول">';
                                    echo number_format($p->User->Family) . " تومان";
                                    echo "</button>";
                                    echo "</br>";
                                    echo '<span class="product-group label label-info" title="دسته بندی">';
                                    $groupname = explode(" ", $p->SubGroup->Name);
                                    $subgroupname = explode(" ", $p->SupperGroup->Name);
                                    if (count($groupname) > 2) {
                                        echo $groupname[0] . ' ' . $groupname[1] . '...';
                                    } else {
                                        echo $p->SubGroup->Name;
                                    }
                                    echo " > ";
                                    if (count($subgroupname) > 2) {
                                        echo $subgroupname[0] . '...';
                                    } else {
                                        echo $p->SupperGroup->Name;
                                    }
                                    echo "</span>";
                                    if ($p->User->Name != 0) {
                                        echo '<span class="product-discount label label-danger" title="تخفیف">';
                                        echo number_format($p->User->Name) . "%";
                                        echo "</span>";
                                    }
                                    if ($specialoffer == 1) {
                                        echo '<span class="product-specialoffer label label-primary" title="پیشنهاد ویژه">';
                                            echo '<i class="fa fa-diamond" style="font-size: 14px;line-height: 17px"></i>';
                                        echo "</span>";
                                    }
                                    $word = explode(",", $p->Keywords);
                                    $words = 0;
                                    foreach ($word as $w) {
                                        $words++;
                                    }
                                    echo '<div class="product-meta ';
                                    if ($words < 5) {
                                        echo 'meta-red';
                                    } elseif ($words >= 5 && $words < 15) {
                                        echo 'meta-yellow';
                                    } else {
                                        echo 'meta-green';
                                    }
                                    echo '" title="وضعیت متا (کلمات کلیدی)">';
                                    echo "</div>";
                                    if ($p->User->UserId != 0) {
                                        echo '<span class="product-coupon label label-primary" title="کپن دریافتی برای خرید محصول">';
                                        echo number_format($p->User->UserId) . " کپن";
                                        echo "</span>";
                                    }
                                    echo "</div></td>";
                                    echo "<td><div class='btn-group'><button class='product-id3 btn-white btn btn-xs m-md' data-toggle='modal' data-target='#productModal' type='button' title='More Information' value='" . $p->ProductId . "'>اطلاعات</button>";
                                    echo "<button class='btn-white btn btn-xs m-md' title='View'><a target='_blank' href='../Post.php?id=$p->ProductId'>" . "نمایش" . "</a></button>";
                                    if ($role->EditProduct == 1) {
                                        echo "<button class='btn-white btn btn-xs m-md' title='Edit'><a href='Product.php?id=" . $p->ProductId . "'>" . "ویرایش" . "</a></button>";
                                    }
                                    if ($role->DeleteProduct == 1) {
                                        echo "<button class='btn-white btn btn-xs m-md' title='Delete'><a onclick='return deleteConfirm()' href='DeleteProduct.php?id=" . $p->ProductId . "'>" . "حذف" . "</a></button>";
                                    }
                                    echo '</div></td>';
                                    echo "</tr>";
                                }
                                $pp2++;
                            }
                        }
                    } else {
                        foreach ($products as $p) {
                            if ($_SESSION[SESSION_STRING_ENTRY] == 'all') {

                                if (substr($p->Image, 0, 1) == "/") {
                                    $imgsrc = $p->Image;
                                } elseif ($p->Image != "") {
                                    $imgsrc = "/" . $p->Image;
                                } else {
                                    $imgsrc = "";
                                }

                                $price = new Price();
//                            $menu = new Menu();
                                $guarantee = new GuaranteeDataSource();
                                $guarantee->open();
                                $pguarantee = $guarantee->GetGuaranteesForOneProduct($p->ProductId);
                                $guarantee->close();
                                $pcolor = new ProductColorDataSource();
                                $pcolor->open();
                                $ppcolor = $pcolor->GetProductColorsForOneProduct($p->ProductId);
                                $pcolor->close();

                                $stds = new StatDataSource();
                                $stds->open();
                                $stats = $stds->GetStatsCountForOneProduct($p->ProductId);
                                $stds->close();

                                $sotds = new SpecialOfferTitleDataSource();
                                $sotds->open();
                                $specialoffer = $sotds->IsSpecialOfferByProduct($p->ProductId);
                                $sotds->close();
                                ?>
                                <div class="product-info" id="p-info<?php echo $p->ProductId; ?>">
                                </div>
                                <?php
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >";
                                echo "<div class='new-status'>";
                                if ($p->Activated == 1) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo '</div>';
                                echo "" . $p->ProductId . "<div class='checkbox checkbox-info checkbox-circle'><input type='checkbox'  value='" . $p->ProductId . "' id='check" . $p->ProductId . "' ";
                                echo " name='check_list[]' class='acheck' /><label for='check" . $p->ProductId . "'></label></div>";
                                echo "</div></td>";
                                echo "<td><img src='$imgsrc' alt='' class='img-table' /></td>";

                                echo "<td><div class='DatabaseField LineHeight' >";
                                echo '<div class="product-title"><b>';
                                if (strlen($p->Name) > 55) {
                                    $str = substr($p->Name, 0, 55) . '...';
                                    echo $str;
                                } else {
                                    echo $p->Name;
                                }
                                echo "</b></div>";
                                echo '<div class="product-title">';
                                if (strlen($p->LatinName) > 45) {
                                    $str = substr($p->LatinName, 0, 45) . '...';
                                    echo $str;
                                } else {
                                    echo $p->LatinName;
                                }
                                echo "</div>";
                                echo "</div></td>";
                                echo "<td><div class='DatabaseField quantity' id='quantity" . $p->ProductId . "' data-toggle='modal' data-target='#quantityModal'>";
                                if ($p->User->Username != 0) {
                                    echo $p->User->Username . " عدد";
                                } else {
                                    echo 'هیچی';
                                }
                                echo "</div></td>";
                                echo "<td>" . $stats . "</td>";
                                echo "<td><div class='DatabaseField options-container' >";
                                echo '<div class="product-meta ';
                                if (strlen($p->MetaDescription) < 80) {
                                    echo 'meta-red';
                                } elseif (strlen($p->MetaDescription) >= 80 && strlen($p->MetaDescription) < 135) {
                                    echo 'meta-yellow';
                                } elseif (strlen($p->MetaDescription) >= 135 && strlen($p->MetaDescription) <= 165) {
                                    echo 'meta-green';
                                } else {
                                    echo 'meta-yellow';
                                }
                                echo '" title="وضعیت متا (توضیحات متا)">';
                                echo "</div>";
                                echo '<span class="product-group2 label label-warning" title="دسته بندی">';
                                $grouplname = explode(" ", $p->SubGroup->LatinName);
                                $subgrouplname = explode(" ", $p->SupperGroup->LatinName);
                                if (count($grouplname) > 2) {
                                    echo $grouplname[0] . '...';
                                } else {
                                    echo $p->SubGroup->LatinName;
                                }
                                echo " > ";
                                if (count($subgrouplname) > 2) {
                                    echo $subgrouplname[0] . '...';
                                } else {
                                    echo $p->SupperGroup->LatinName;
                                }
                                echo "</span>";
                                echo '<button class="product-price btn btn-primary " data-toggle="modal" data-target="#priceModal" type="button" id="price' . $p->ProductId . '" title="قیمت محصول">';
                                echo number_format($p->User->Family) . " تومان";
                                echo "</button>";
                                echo "</br>";
                                echo '<span class="product-group label label-info" title="دسته بندی">';
                                $groupname = explode(" ", $p->SubGroup->Name);
                                $subgroupname = explode(" ", $p->SupperGroup->Name);
                                if (count($groupname) > 2) {
                                    echo $groupname[0] . ' ' . $groupname[1] . '...';
                                } else {
                                    echo $p->SubGroup->Name;
                                }
                                echo " > ";
                                if (count($subgroupname) > 2) {
                                    echo $subgroupname[0] . '...';
                                } else {
                                    echo $p->SupperGroup->Name;
                                }
                                echo "</span>";
                                if ($p->User->Name != 0) {
                                    echo '<span class="product-discount label label-danger" title="تخفیف">';
                                    echo number_format($p->User->Name) . "%";
                                    echo "</span>";
                                }
                                if ($specialoffer == 1) {
                                    echo '<span class="product-specialoffer label label-primary" title="پیشنهاد ویژه">';
                                        echo '<i class="fa fa-diamond" style="font-size: 14px;line-height: 17px"></i>';
                                    echo "</span>";
                                }
                                $word = explode(",", $p->Keywords);
                                $words = 0;
                                foreach ($word as $w) {
                                    $words++;
                                }
                                echo '<div class="product-meta ';
                                if ($words < 5) {
                                    echo 'meta-red';
                                } elseif ($words >= 5 && $words < 15) {
                                    echo 'meta-yellow';
                                } else {
                                    echo 'meta-green';
                                }
                                echo '" title="وضعیت متا (کلمات کلیدی)">';
                                echo "</div>";
                                if ($p->User->UserId != 0) {
                                    echo '<span class="product-coupon label label-primary" title="کپن دریافتی برای خرید محصول">';
                                    echo number_format($p->User->UserId) . " کپن";
                                    echo "</span>";
                                }
                                echo "</div></td>";
                                echo "<td><div class='btn-group'><button class='product-id3 btn-white btn btn-xs m-md' data-toggle='modal' data-target='#productModal' type='button' title='More Information' value='" . $p->ProductId . "'>اطلاعات</button>";
                                echo "<button class='btn-white btn btn-xs m-md' title='View'><a target='_blank' href='../Post.php?id=$p->ProductId'>" . "نمایش" . "</a></button>";
                                if ($role->EditProduct == 1) {
                                    echo "<button class='btn-white btn btn-xs m-md' title='Edit'><a href='Product.php?id=" . $p->ProductId . "'>" . "ویرایش" . "</a></button>";
                                }
                                if ($role->DeleteProduct == 1) {
                                    echo "<button class='btn-white btn btn-xs m-md' title='Delete'><a onclick='return deleteConfirm()' href='DeleteProduct.php?id=" . $p->ProductId . "'>" . "حذف" . "</a></button>";
                                }
                                echo '</div></td>';
                                echo "</tr>";
                            } elseif (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == TRUE && ($_SESSION[SESSION_INT_CURRENT_PAGE] * $_SESSION[SESSION_STRING_ENTRY]) - ($_SESSION[SESSION_STRING_ENTRY] - 1) <= $pp2 && $pp2 <= $_SESSION[SESSION_INT_CURRENT_PAGE] * $_SESSION[SESSION_STRING_ENTRY]) {

                                if (substr($p->Image, 0, 1) == "/") {
                                    $imgsrc = $p->Image;
                                } elseif ($p->Image != "") {
                                    $imgsrc = "/" . $p->Image;
                                } else {
                                    $imgsrc = "";
                                }
                                
                                $price = new Price();
//                            $menu = new Menu();
                                $guarantee = new GuaranteeDataSource();
                                $guarantee->open();
                                $pguarantee = $guarantee->GetGuaranteesForOneProduct($p->ProductId);
                                $guarantee->close();
                                $pcolor = new ProductColorDataSource();
                                $pcolor->open();
                                $ppcolor = $pcolor->GetProductColorsForOneProduct($p->ProductId);
                                $pcolor->close();

                                $stds = new StatDataSource();
                                $stds->open();
                                $stats = $stds->GetStatsCountForOneProduct($p->ProductId);
                                $stds->close();

                                $sotds = new SpecialOfferTitleDataSource();
                                $sotds->open();
                                $specialoffer = $sotds->IsSpecialOfferByProduct($p->ProductId);
                                $sotds->close();
                                ?>
                                <div class="product-info" id="p-info<?php echo $p->ProductId; ?>">
                                </div>
                                <?php
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >";
                                echo "<div class='new-status'>";
                                if ($p->Activated == 1) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo '</div>';
                                echo "" . $p->ProductId . "<div class='checkbox checkbox-info checkbox-circle'><input type='checkbox'  value='" . $p->ProductId . "' id='check" . $p->ProductId . "' ";
                                echo " name='check_list[]' class='acheck' /><label for='check" . $p->ProductId . "'></label></div>";
                                echo "</div></td>";
                                echo "<td><img src='$imgsrc' alt='' class='img-table' /></td>";

                                echo "<td><div class='DatabaseField LineHeight' >";
                                echo '<div class="product-title"><b>';
                                if (strlen($p->Name) > 55) {
                                    $str = substr($p->Name, 0, 55) . '...';
                                    echo $str;
                                } else {
                                    echo $p->Name;
                                }
                                echo "</b></div>";
                                echo '<div class="product-title">';
                                if (strlen($p->LatinName) > 45) {
                                    $str = substr($p->LatinName, 0, 45) . '...';
                                    echo $str;
                                } else {
                                    echo $p->LatinName;
                                }
                                echo "</div>";
                                echo "</div></td>";
                                echo "<td><div class='DatabaseField quantity' id='quantity" . $p->ProductId . "' data-toggle='modal' data-target='#quantityModal'>";
                                if ($p->User->Username != 0) {
                                    echo $p->User->Username . " عدد";
                                } else {
                                    echo 'هیچی';
                                }
                                echo "</div></td>";
                                echo "<td>" . $stats . "</td>";
                                echo "<td><div class='DatabaseField options-container' >";
                                echo '<div class="product-meta ';
                                if (strlen($p->MetaDescription) < 80) {
                                    echo 'meta-red';
                                } elseif (strlen($p->MetaDescription) >= 80 && strlen($p->MetaDescription) < 135) {
                                    echo 'meta-yellow';
                                } elseif (strlen($p->MetaDescription) >= 135 && strlen($p->MetaDescription) <= 165) {
                                    echo 'meta-green';
                                } else {
                                    echo 'meta-yellow';
                                }
                                echo '" title="وضعیت متا (توضیحات متا)">';
                                echo "</div>";
                                echo '<span class="product-group2 label label-warning" title="دسته بندی">';
                                $grouplname = explode(" ", $p->SubGroup->LatinName);
                                $subgrouplname = explode(" ", $p->SupperGroup->LatinName);
                                if (count($grouplname) > 2) {
                                    echo $grouplname[0] . '...';
                                } else {
                                    echo $p->SubGroup->LatinName;
                                }
                                echo " > ";
                                if (count($subgrouplname) > 2) {
                                    echo $subgrouplname[0] . '...';
                                } else {
                                    echo $p->SupperGroup->LatinName;
                                }
                                echo "</span>";
                                echo '<button class="product-price btn btn-primary " data-toggle="modal" data-target="#priceModal" type="button" id="price' . $p->ProductId . '" title="قیمت محصول">';
                                echo number_format($p->User->Family) . " تومان";
                                echo "</button>";
                                echo "</br>";
                                echo '<span class="product-group label label-info" title="دسته بندی">';
                                $groupname = explode(" ", $p->SubGroup->Name);
                                $subgroupname = explode(" ", $p->SupperGroup->Name);
                                if (count($groupname) > 2) {
                                    echo $groupname[0] . ' ' . $groupname[1] . '...';
                                } else {
                                    echo $p->SubGroup->Name;
                                }
                                echo " > ";
                                if (count($subgroupname) > 2) {
                                    echo $subgroupname[0] . '...';
                                } else {
                                    echo $p->SupperGroup->Name;
                                }
                                echo "</span>";
                                if ($p->User->Name != 0) {
                                    echo '<span class="product-discount label label-danger" title="تخفیف">';
                                    echo number_format($p->User->Name) . "%";
                                    echo "</span>";
                                }
                                if ($specialoffer == 1) {
                                    echo '<span class="product-specialoffer label label-primary" title="پیشنهاد ویژه">';
                                        echo '<i class="fa fa-diamond" style="font-size: 14px;line-height: 17px"></i>';
                                    echo "</span>";
                                }
                                $word = explode(",", $p->Keywords);
                                $words = 0;
                                foreach ($word as $w) {
                                    $words++;
                                }
                                echo '<div class="product-meta ';
                                if ($words < 5) {
                                    echo 'meta-red';
                                } elseif ($words >= 5 && $words < 15) {
                                    echo 'meta-yellow';
                                } else {
                                    echo 'meta-green';
                                }
                                echo '" title="وضعیت متا (کلمات کلیدی)">';
                                echo "</div>";
                                if ($p->User->UserId != 0) {
                                    echo '<span class="product-coupon label label-primary" title="کپن دریافتی برای خرید محصول">';
                                    echo number_format($p->User->UserId) . " کپن";
                                    echo "</span>";
                                }
                                echo "</div></td>";
                                echo "<td><div class='btn-group'><button class='product-id3 btn-white btn btn-xs m-md' data-toggle='modal' data-target='#productModal' type='button' title='More Information' value='" . $p->ProductId . "'>اطلاعات</button>";
                                echo "<button class='btn-white btn btn-xs m-md' title='View'><a target='_blank' href='../Post.php?id=$p->ProductId'>" . "نمایش" . "</a></button>";
                                if ($role->EditProduct == 1) {
                                    echo "<button class='btn-white btn btn-xs m-md' title='Edit'><a href='Product.php?id=" . $p->ProductId . "'>" . "ویرایش" . "</a></button>";
                                }
                                if ($role->DeleteProduct == 1) {
                                    echo "<button class='btn-white btn btn-xs m-md' title='Delete'><a onclick='return deleteConfirm()' href='DeleteProduct.php?id=" . $p->ProductId . "'>" . "حذف" . "</a></button>";
                                }
                                echo '</div></td>';
                                echo "</tr>";
                            } elseif (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == FALSE && 1 <= $pp2 && $pp2 <= $_SESSION[SESSION_STRING_ENTRY]) {

                                if (substr($p->Image, 0, 1) == "/") {
                                    $imgsrc = $p->Image;
                                } elseif ($p->Image != "") {
                                    $imgsrc = "/" . $p->Image;
                                } else {
                                    $imgsrc = "";
                                }

                                $price = new Price();
//                            $menu = new Menu();
                                $guarantee = new GuaranteeDataSource();
                                $guarantee->open();
                                $pguarantee = $guarantee->GetGuaranteesForOneProduct($p->ProductId);
                                $guarantee->close();
                                $pcolor = new ProductColorDataSource();
                                $pcolor->open();
                                $ppcolor = $pcolor->GetProductColorsForOneProduct($p->ProductId);
                                $pcolor->close();

                                $stds = new StatDataSource();
                                $stds->open();
                                $stats = $stds->GetStatsCountForOneProduct($p->ProductId);
                                $stds->close();
                                ?>
                                <div class="product-info" id="p-info<?php echo $p->ProductId; ?>">
                                </div>
                                <?php
                                $postsCounter++;
                                echo "<tr>";
                                echo "<td><div class='DatabaseField' >";
                                echo "<div class='new-status'>";
                                if ($p->Activated == 1) {
                                    echo "<i title='فعال' class='fa fa-check text-navy'></i>";
                                } else {
                                    echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
                                }
                                echo '</div>';
                                echo "" . $p->ProductId . "<div class='checkbox checkbox-info checkbox-circle'><input type='checkbox'  value='" . $p->ProductId . "' id='check" . $p->ProductId . "' ";
                                echo " name='check_list[]' class='acheck' /><label for='check" . $p->ProductId . "'></label></div>";
                                echo "</div></td>";
                                echo "<td><img src='$imgsrc' alt='' class='img-table' /></td>";

                                echo "<td><div class='DatabaseField LineHeight' >";
                                echo '<div class="product-title"><b>';
                                if (strlen($p->Name) > 55) {
                                    $str = substr($p->Name, 0, 55) . '...';
                                    echo $str;
                                } else {
                                    echo $p->Name;
                                }
                                echo "</b></div>";
                                echo '<div class="product-title">';
                                if (strlen($p->LatinName) > 45) {
                                    $str = substr($p->LatinName, 0, 45) . '...';
                                    echo $str;
                                } else {
                                    echo $p->LatinName;
                                }
                                echo "</div>";
                                echo "</div></td>";
                                echo "<td><div class='DatabaseField quantity' id='quantity" . $p->ProductId . "' data-toggle='modal' data-target='#quantityModal'>";
                                if ($p->User->Username != 0) {
                                    echo $p->User->Username . " عدد";
                                } else {
                                    echo 'هیچی';
                                }
                                echo "</div></td>";
                                echo "<td>" . $stats . "</td>";
                                echo "<td><div class='DatabaseField options-container' >";
                                echo '<div class="product-meta ';
                                if (strlen($p->MetaDescription) < 80) {
                                    echo 'meta-red';
                                } elseif (strlen($p->MetaDescription) >= 80 && strlen($p->MetaDescription) < 135) {
                                    echo 'meta-yellow';
                                } elseif (strlen($p->MetaDescription) >= 135 && strlen($p->MetaDescription) <= 165) {
                                    echo 'meta-green';
                                } else {
                                    echo 'meta-yellow';
                                }
                                echo '" title="وضعیت متا (توضیحات متا)">';
                                echo "</div>";
                                echo '<span class="product-group2 label label-warning" title="دسته بندی">';
                                $grouplname = explode(" ", $p->SubGroup->LatinName);
                                $subgrouplname = explode(" ", $p->SupperGroup->LatinName);
                                if (count($grouplname) > 2) {
                                    echo $grouplname[0] . '...';
                                } else {
                                    echo $p->SubGroup->LatinName;
                                }
                                echo " > ";
                                if (count($subgrouplname) > 2) {
                                    echo $subgrouplname[0] . '...';
                                } else {
                                    echo $p->SupperGroup->LatinName;
                                }
                                echo "</span>";
                                echo '<button class="product-price btn btn-primary " data-toggle="modal" data-target="#priceModal" type="button" id="price' . $p->ProductId . '" title="قیمت محصول">';
                                echo number_format($p->User->Family) . " تومان";
                                echo "</button>";
                                echo "</br>";
                                echo '<span class="product-group label label-info" title="دسته بندی">';
                                $groupname = explode(" ", $p->SubGroup->Name);
                                $subgroupname = explode(" ", $p->SupperGroup->Name);
                                if (count($groupname) > 2) {
                                    echo $groupname[0] . ' ' . $groupname[1] . '...';
                                } else {
                                    echo $p->SubGroup->Name;
                                }
                                echo " > ";
                                if (count($subgroupname) > 2) {
                                    echo $subgroupname[0] . '...';
                                } else {
                                    echo $p->SupperGroup->Name;
                                }
                                echo "</span>";
                                if ($p->User->Name != 0) {
                                    echo '<span class="product-discount label label-danger" title="تخفیف">';
                                    echo number_format($p->User->Name) . "%";
                                    echo "</span>";
                                }
                                if ($specialoffer == 1) {
                                    echo '<span class="product-specialoffer label label-primary" title="پیشنهاد ویژه">';
                                        echo '<i class="fa fa-diamond" style="font-size: 14px;line-height: 17px"></i>';
                                    echo "</span>";
                                }
                                $word = explode(",", $p->Keywords);
                                $words = 0;
                                foreach ($word as $w) {
                                    $words++;
                                }
                                echo '<div class="product-meta ';
                                if ($words < 5) {
                                    echo 'meta-red';
                                } elseif ($words >= 5 && $words < 15) {
                                    echo 'meta-yellow';
                                } else {
                                    echo 'meta-green';
                                }
                                echo '" title="وضعیت متا (کلمات کلیدی)">';
                                echo "</div>";
                                if ($p->User->UserId != 0) {
                                    echo '<span class="product-coupon label label-primary" title="کپن دریافتی برای خرید محصول">';
                                    echo number_format($p->User->UserId) . " کپن";
                                    echo "</span>";
                                }
                                echo "</div></td>";
                                echo "<td><div class='btn-group'><button class='product-id3 btn-white btn btn-xs m-md' data-toggle='modal' data-target='#productModal' type='button' title='More Information' value='" . $p->ProductId . "'>اطلاعات</button>";
                                echo "<button class='btn-white btn btn-xs m-md' title='View'><a target='_blank' href='../Post.php?id=$p->ProductId'>" . "نمایش" . "</a></button>";
                                if ($role->EditProduct == 1) {
                                    echo "<button class='btn-white btn btn-xs m-md' title='Edit'><a href='Product.php?id=" . $p->ProductId . "'>" . "ویرایش" . "</a></button>";
                                }
                                if ($role->DeleteProduct == 1) {
                                    echo "<button class='btn-white btn btn-xs m-md' title='Delete'><a onclick='return deleteConfirm()' href='DeleteProduct.php?id=" . $p->ProductId . "'>" . "حذف" . "</a></button>";
                                }
                                echo '</div></td>';
                                echo "</tr>";
                            }
                            $pp2++;
                        }
                    }
                    ?>
                    </tbody>
                    <!--                                        <tfoot>-->
                    <!--                                        <tr>-->
                    <!--                                            <td colspan="5">-->
                    <!--                                                <ul class="pagination pull-right"></ul>-->
                    <!--                                            </td>-->
                    <!--                                        </tr>-->
                    <!--                                        </tfoot>-->
                </table>
            </div>
    </div>
    <?php
    if (isset($pages) && ($pages != 1 && $products != NULL) && $_SESSION[SESSION_STRING_ENTRY] != "all") {
        ?>
        <div class="Pager">
            <a class="page-link btn btn-success" id="1" href="">صفحه اول</a>
            <?php
            $s = 1;
            if ($_SESSION[SESSION_INT_CURRENT_PAGE] > 3) {
                for ($j = $_SESSION[SESSION_INT_CURRENT_PAGE] - 2; $j <= $pages; $j++) {
                    if ($j <= $_SESSION[SESSION_INT_CURRENT_PAGE] + 2) {
                        echo ' <a href="" id="' . $j . '"  class="page-link  ';
                        if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE]) {
                            echo ' btn btn-warning ';
                        } else {
                            echo ' btn btn-success ';
                        }
//                            echo '  href="Products.php?search_box=';
//                            if (isset($_GET["search_box"]) == TRUE) {
//                                echo $_GET['search_box'];
//                            }
                        echo 'page=' . $j . ' " >' . $j . '</a>';
                    } else {

                    }
                    if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE] + 3) {
                        echo ' <span >...</span>';
                    }
                }
            } else {
                for ($j = 1; $j <= $pages; $j++) {
                    if ($j <= 5) {
                        echo ' <a id="' . $j . '"  class="page-link  ';
                        if ($j == $_SESSION[SESSION_INT_CURRENT_PAGE]) {
                            echo ' btn btn-warning ';
                        } else {
                            echo ' btn btn-success ';
                        }
                        echo ' href="">' . $j . '</a>';
                    }
                    if ($j == 5) {
                        echo ' <span >...</span>';
                    }
                }
            }
            ?>
            <a id="<?php echo $pages; ?>" class="page-link btn btn-success" href="">آخرین صفحه</a>
        </div>
        <div class="clear-fix"></div>
        <?php
    }
    ?>
    <?php
    $total_product = new Product();
    if ($role->ProductGroupLimit) {
        ?>
        <div class="RecordsCounter">Access : <?php echo $counter2; ?></div>
        <?php
    } else {
        $total_product = new ProductDataSource();
        $total_product->open();
        ?>
        <div class="RecordsCounter">Total : <?php echo $total_product->TotalPosts(); ?></div>
        <?php
        $total_product->close();
    }
    ?>

    <?php
} else {
    echo '<div class="no-result">';
    echo 'هیج نتیجه ای پیدا نشد!';
    echo '</div>';
}
?>
    <script>
        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $(document).ready(function () {
            $('.select-options').slideUp(500);
            $(".product-id3").click(function () {
//                $("#wait").fadeIn(0);
                var productId = $(this).val();
                $.ajax({
                    url: 'ProductInfo.php',
                    type: 'POST',
                    data: {productId: productId},
                    success: function (result) {
                        $("#p-info").html(result);
                        $("#p-info").fadeIn(250);
                        $("#modalback").fadeIn(250);
                        $("#wait").fadeOut(0);
                    }
                });
            });
            $("#modalback").click(function () {
                $("#p-info").fadeOut(250);
                $("#delete-confirm-message").fadeOut(250);
                $("#status-confirm-message").fadeOut(250);
                $("#sort-confirm-message").fadeOut(250);
                $("#coupon-confirm-message").fadeOut(250);
                $("#specialoffer-confirm-message").fadeOut(250);
                $("#discount-confirm-message").fadeOut(250);
                $("#modalback").fadeOut(500);
            });
            $('#search_box').keyup(function () {
                $("#wait").fadeIn(0);
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'ajaxSearch.php',
                        data: $('#search_form').serialize(),
                        success: function (result) {
                            $("#db").html(result);
                            $("#wait").fadeOut(0);
                        }
                    });
                }, 500);
            });

            $("#delete-confirm-btn").click(function () {
                $("#modalback").fadeOut(500);
                $("#delete-confirm-message").fadeOut(500);
                $("#wait").fadeIn(0);
                $.ajax({
                    type: 'POST',
                    url: 'multiSelect.php',
                    data: $('#products-form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                        $('.select-options').slideUp(500);
                    }
                });
            });

            $("#discount-confirm-btn").click(function () {
                $("#modalback").fadeOut(500);
                $("#discount-confirm-message").fadeOut(500);
                $("#wait").fadeIn(0);
                $.ajax({
                    type: 'POST',
                    url: 'multiSelect.php',
                    data: $('#products-form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                        $('.select-options').slideUp(500);

                    }
                });
            });

            $("#coupon-confirm-btn").click(function () {
                $("#modalback").fadeOut(500);
                $("#coupon-confirm-message").fadeOut(500);
                $("#wait").fadeIn(0);
                $.ajax({
                    type: 'POST',
                    url: 'multiSelect.php',
                    data: $('#products-form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                        $('.select-options').slideUp(500);

                    }
                });
            });

            $("#sort-confirm-btn").click(function () {
                $("#modalback").fadeOut(500);
                $("#sort-confirm-message").fadeOut(500);
                $("#wait").fadeIn(0);
                $.ajax({
                    type: 'POST',
                    url: 'multiSelect.php',
                    data: $('#products-form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                        $('.select-options').slideUp(500);

                    }
                });
            });

            $("#deactivate-confirm-btn").click(function () {
                $('#action').attr('value', 'status-deactivate');
                $("#modalback").fadeOut(500);
                $("#status-confirm-message").fadeOut(500);
                $("#wait").fadeIn(0);
                $.ajax({
                    type: 'POST',
                    url: 'multiSelect.php',
                    data: $('#products-form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                        $('.select-options').slideUp(500);

                    }
                });
            });

            $("#activate-confirm-btn").click(function () {
                $('#action').attr('value', 'status-activate');
                $("#modalback").fadeOut(500);
                $("#status-confirm-message").fadeOut(500);
                $("#wait").fadeIn(0);
                $.ajax({
                    type: 'POST',
                    url: 'multiSelect.php',
                    data: $('#products-form').serialize(),
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                        $('.select-options').slideUp(500);

                    }
                });
            });


            $(".page-link").click(function (e) {
                $("#wait").fadeIn(0);
                e.preventDefault();
                $.ajax({
                    url: 'ajaxPager.php',
                    type: 'POST',
                    data: {
                        page: $(this).attr('id')
                    },
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                    },
                    error: function (result) {
                        alert("لطفا دوباره امتحان کنید!");
                    }
                });
            });
            $(".cancel-btn").click(function () {
                $("#delete-confirm-message").fadeOut(250);
                $("#status-confirm-message").fadeOut(250);
                $("#sort-confirm-message").fadeOut(250);
                $("#coupon-confirm-message").fadeOut(250);
                $("#discount-confirm-message").fadeOut(250);
                $("#specialoffer-confirm-message").fadeOut(250);
                $("#modalback").fadeOut(500);
                $('#group-s').attr('value', '0');
                $('#subgroup-td').html("<select id = 'subgroup2' name = 'subgroup2' disabled><option> زیر مجموعه... </option></select>");
                $('#discount').attr('value', '');
                $('#coupon').attr('value', '');
            });
            $("#delete-btn").click(function () {
                $('#action').attr('value', 'delete');
                $("#delete-confirm-message").fadeIn(250);
                $("#modalback").fadeIn(250);
            });
            $("#status-btn").click(function () {
                $('#action').attr('value', 'status');
                $("#status-confirm-message").fadeIn(250);
                $("#modalback").fadeIn(250);
            });
            $("#sort-btn").click(function () {
                $('#action').attr('value', 'sort');
                $("#sort-confirm-message").fadeIn(250);
                $("#modalback").fadeIn(250);
            });
            $("#coupon-btn").click(function () {
                $('#action').attr('value', 'coupon');
                $("#coupon-confirm-message").fadeIn(250);
                $("#modalback").fadeIn(250);
            });
            $("#discount-btn").click(function () {
                $('#action').attr('value', 'discount');
                $("#discount-confirm-message").fadeIn(250);
                $("#modalback").fadeIn(250);
            });

            $('#checkall').change(function () {
                if ($(this).is(':checked')) {
                    $('.acheck').prop('checked', true);
                    $('.select-options').slideDown(500);
                }
                else {
                    $('.acheck').prop('checked', false);
                    $('.select-options').slideUp(500);
                }
            });

            $('.acheck').change(function () {
                $('.select-options').slideDown(500);
                if ($('.acheck').is(':checked')) {
                }
                else {
                    $('.select-options').slideUp(500);
                }
            });

            $("#order").change(function () {
                $("#wait").fadeIn(0);
                var order = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'ajaxSearch.php',
                    data: {order: order},
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                    }
                });
            });
            $("#ordertype").change(function () {
                $("#wait").fadeIn(0);
                var ordertype = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'ajaxSearch.php',
                    data: {ordertype: ordertype},
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                    }
                });
            });
            $("#group").change(function () {
                $("#wait").fadeIn(0);
                var group = $(this).val();
                var subgroup = '';
                var suppergroup = '';
                $.ajax({
                    type: 'POST',
                    url: 'RefreshSubgroups4.php',
                    data: {group: group},
                    success: function (data) {
                        $('#subgroup-td').html(data);
                        $('#suppergroup').html("<option value='0' >زیر زیر مجموعه ...</option>");
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: 'ajaxSearch.php',
                    data: {group: group, subgroup: subgroup, suppergroup: suppergroup},
                    success: function (result) {
                        $("#db").html(result);
                        $("#wait").fadeOut(0);
                    }
                });
            });

            $("#group2").change(function () {
                var group = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'RefreshSubgroups3.php',
                    data: {group: group},
                    success: function (data) {
                        $('#subgroup-td2').html(data);
                    }
                });
            });


            $("#add-confirm-btn").click(function () {
                $('#action').attr('value', 'add-specialoffer');
                $("#modalback").fadeOut(500);
                $("#specialoffer-confirm-message").fadeOut(500);
                $("#wait").fadeIn(0);
                var special_offer = $("#specialoffers").val();
                if (special_offer == "") {
                    alert("لطفا یکی از گزینه ها را انتخاب نمایید!");
                    $("#wait").fadeOut(0);
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'multiSelect.php',
                        data: $('#products-form').serialize(),
                        success: function (result) {
                            $("#db").html(result);
                            $("#wait").fadeOut(0);
                            $('.select-options').slideUp(500);

                        }
                    });
                }
            });

            $("#remove-confirm-btn").click(function () {
                $('#action').attr('value', 'remove-specialoffer');
                $("#modalback").fadeOut(500);
                $("#specialoffer-confirm-message").fadeOut(500);
                $("#wait").fadeIn(0);
                var special_offer = $("#specialoffers").val();
                if (special_offer == "") {
                    alert("لطفا یکی از گزینه ها را انتخاب نمایید!");
                    $("#wait").fadeOut(0);
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'multiSelect.php',
                        data: $('#products-form').serialize(),
                        success: function (result) {
                            $("#db").html(result);
                            $("#wait").fadeOut(0);
                            $('.select-options').slideUp(500);

                        }
                    });
                }
            });

            $("#specialoffer-btn").click(function () {
                $('#action').attr('value', 'specialoffer');
                $("#specialoffer-confirm-message").fadeIn(250);
                $("#modalback").fadeIn(250);
            });


            $(".quantity").click(function () {
                var productId = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    url: 'AjaxLoadColor.php',
                    data: {product:productId },
                    success: function (data) {
                        $('#colorSamples').html(data);
                    }
                });
                
                $('#quantityId').attr('value', $(this).attr('id'));
                $('#quantityContent').attr('value', $(this).val());
                $("#quantity-pop").fadeIn(250);
                $("#modalback").fadeIn(250);
            });
            $(".product-price").click(function () {
                $('#priceId').attr('value', $(this).attr('id'));
                $("#price-pop").fadeIn(250);
                $("#modalback").fadeIn(250);

            });

        });
    </script>

<?php
//include_once 'Template/bottom.php';