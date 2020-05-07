<?php
include_once 'Template/top.php';
$_SESSION[SESSION_INT_PRICE_HOLDER] = "";
$_SESSION[SESSION_INT_CURRENT_PAGE] = 1;
$_SESSION[SESSION_STRING_ORDER] = " ProductId";
if (isset($_GET['BestSellers'])) {
    $_SESSION[SESSION_STRING_ORDER] = " Sells";
} elseif (isset($_GET['MostPopular'])) {
    $_SESSION[SESSION_STRING_ORDER] = " Popularity";
}
$_SESSION[SESSION_STRING_ASC_DESC_ORDER_TYPE] = " DESC ";
$_SESSION[SESSION_STRING_CHECKED_BOX] = "";
$_SESSION[SESSION_STRING_SEARCH_BOX] = "";
?>
    <title><?php echo $settings->SiteName; ?>- جستجو</title>
    <script>
        $(document).ready(function () {

            $('ul.needmore').each(function () {

                var LiN = $(this).find('li').length;
                if (LiN > 6) {
                    $('li', this).eq(5).nextAll().hide().addClass('toggleable');
                    $(this).append('<li class="more">+ بیشتر...</li>');
                }

            });
            $('ul').on('click', '.more', function () {
                if ($(this).hasClass('less')) {
                    $(this).text('+ بیشتر...').removeClass('less');
                } else {
                    $(this).text('- بستن...').addClass('less');
                }
                $(this).siblings('li.toggleable').slideToggle();
            });
        });</script>
    <!--<link href="Template/noUiSlider/nouislider.min.css" rel="stylesheet" type="text/css"/>-->
    <link href="Template/noUiSlider/nouislider.css" rel="stylesheet" type="text/css"/>


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="Template/Rating/dist/themes/custom2.css" rel="stylesheet" type="text/css"/>

    <div class="success-message" id="cart-success-msg">محصول با موفقیت به سبد خرید افزوده شد</div>

<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SubGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SupperGroupDataSource.inc';


//$protocol = new ProtocolList();
//$protocols = $protocol->Fill();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/LogoDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SubMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SupperMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/MenuTitleDataSource.inc';
//$logo = new LogoDataSource();
//$logo->open();
//$logos = $logo->Fill();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/OpinionDataSource.inc';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductColorDataSource.inc';


$color = new ProductColorDataSource();
$color->open();
$colors = $color->Fill();
$color->close();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/PriceDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/DiscountDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductDataSource.inc';
$product = new Product();


$opinion = new OpinionDataSource();
$opinion->open();


$discount = new DiscountDataSource();
$discount->open();
$price = new PriceDataSource();
$price->open();

$products = array();
if (isset($_GET['search_box'])) {
    $p = new ProductDataSource();
    $p->open();
//    $p->Name = $_GET['search_box'];
    $products = $p->CSearchProducts($_GET['search_box']);
    $p->close();


    $logo = new LogoDataSource();
    $logo->open();
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
//            $logo->LogoId = $l;
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
//            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }

} elseif (isset($_GET['search_box_mob'])) {
    $p = new ProductDataSource();
    $p->open();
//    $p->Name = $_GET['search_box'];
    $products = $p->CSearchProducts($_GET['search_box_mob']);
    $p->close();


    $logo = new LogoDataSource();
    $logo->open();
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
//            $logo->LogoId = $l;
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
//            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }

} elseif (isset($_GET['brand'])) {
    $p = new ProductDataSource();
    $p->open();
//    $p->Brand = $_GET['brand'];
    $products = $p->SearchBrands($_GET['brand']);
    $p->close();

    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
//            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();


        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();


        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }
} elseif (isset($_GET['special_offers'])) {
    $p = new ProductDataSource();
    $p->open();
    $products = $p->FindSpecialOffers2($_GET['special_offers']);
    $p->close();
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }

        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }

} elseif (isset($_GET['group'])) {


    $pds = new ProductDataSource();
    $pds->open();
    $productIds = $pds->FillByG($_GET['group']);
    $pds->close();
    $products = array();
    $i = 0;
    $GroupId = $_GET['group'];
    foreach ($productIds as $p) {
        $p2 = new ProductDataSource();
        $p2->open();
//        $p2->ProductId = $p;
        $products[$i] = $p2->FindOneProductBasedOnId($p);
        $p2->close();
        $i++;
    }
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }
} elseif (isset($_GET['sbgroup'])) {


    $pds = new ProductDataSource();
    $pds->open();
    $productIds = $pds->FillBySG($_GET['sbgroup']);
    $pds->close();
    $products = array();
    $i = 0;
    $SubGroupId = $_GET['sbgroup'];
    foreach ($productIds as $p) {
        $p2 = new ProductDataSource();
        $p2->open();
//        $p2->ProductId = $p;
        $products[$i] = $p2->FindOneProductBasedOnId($p);
        $p2->close();
        $i++;
    }
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }
} elseif (isset($_GET['spgroup'])) {


    $pds = new ProductDataSource();
    $pds->open();
    $productIds = $pds->FillBySPG($_GET['spgroup']);
    $pds->close();
    $products = array();
    $i = 0;
    require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/ProductPropertyDataSource.inc";
    $pp = new ProductPropertyDataSource();
    $pp->open();
    $properties = $pp->CFindOneSupperGroupRecords($_GET['spgroup']);
    $SupperGroupId = $_GET['spgroup'];
    foreach ($productIds as $p) {
        $p2 = new ProductDataSource();
        $p2->open();
        $products[$i] = $p2->FindOneProductBasedOnId($p);
        $p2->close();
        $i++;
    }
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }

        foreach ($uniquelogos as $l) {
//            $logo->LogoId = $l;
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
    }
} elseif (isset($_GET['tid'])) {

    $sp = new SupperMenuDataSource();
    $sp->open();
    $sps = $sp->getSupperMenusOfThisTitle($_GET['tid']);
    $sp->close();
    $i = 0;
    $TitleId = $_GET['tid'];
    $products = array();
    $TitleSupperGroups = "";
    foreach ($sps as $spid) {
        $TitleSupperGroups .= ',' . $spid->SupperGroup->SupperGroupId;
        $pds = new ProductDataSource();
        $pds->open();
        $productIds = $pds->FillBySPG($spid->SupperGroup->SupperGroupId);
        $pds->close();
        foreach ($productIds as $p) {
            $p2 = new ProductDataSource();
            $p2->open();
            $p2->ProductId = $p;
            $products[$i] = $p2->FindOneProductBasedOnId($p);
            $p2->close();
            $i++;
        }
    }
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }

} else {


    $p = new ProductDataSource();
    $p->open();
    $products = $p->CFill($_SESSION[SESSION_STRING_ORDER], $_SESSION[SESSION_STRING_ASC_DESC_ORDER_TYPE]);
    $p->close();
    $i = 0;
    $templogos = array();
    foreach ($products as $p) {
        $templogos[$i] = $p->Brand->LogoId;
        $tempprices[$i] = $p->User->Family;
        $tempsubgroups[$i] = $p->SubGroup->SubGroupId;
        $tempgroups[$i] = $p->Group->GroupId;
        $tempsuppergroups[$i] = $p->SupperGroup->SupperGroupId;
        $i++;
    }
    $i = 0;
    if ($templogos != null && $tempgroups != null && $tempsubgroups != null && $tempsuppergroups != null && $tempprices) {
        $uniquelogos = array_unique($templogos);
        $uniquesbgroups = array_unique($tempsubgroups);
        $uniquegroups = array_unique($tempgroups);
        $uniquesuppergroups = array_unique($tempsuppergroups);
        $maxprice = max($tempprices);
        $minprice = min($tempprices);
        if ($minprice == null || $minprice == $maxprice) {
            $minprice = 0;
        }
        foreach ($uniquelogos as $l) {
//            $logo->LogoId = $l;
            $logo = new LogoDataSource();
            $logo->open();
            $logos[$i] = $logo->FindOneLogoBasedOnId($l);
            $logo->close();
            $i++;
        }
        $subgroup = new SubGroupDataSource();
        $subgroup->open();
        foreach ($uniquesbgroups as $s) {
            $subgroup->SubGroupId = $s;
            $subgroups[$i] = $subgroup->FindOneSubGroupBasedOnId($s);
            $i++;
        }
        $subgroup->close();

        $group = new GroupDataSource();
        $group->open();
        foreach ($uniquegroups as $s) {
            $group->GroupId = $s;
            $groups[$i] = $group->FindOneGroupBasedOnId($s);
            $i++;
        }
        $group->close();

        $suppergroup = new SupperGroupDataSource();
        $suppergroup->open();
        foreach ($uniquesuppergroups as $s) {
            $suppergroup->SupperGroupId = $s;
            $suppergroups[$i] = $suppergroup->FindOneSupperGroupBasedOnId($s);
            $i++;
        }
        $suppergroup->close();
    }
}
?>
    <meta name="description" content="Products"/>
<?php
include_once 'Template/menu.php';
//echo date("Y/m/d");
$checkboxCounter = 0;
?>
    <script src="Template/noUiSlider/nouislider.min.js" type="text/javascript"></script>
    <script src="Template/noUiSlider/wNumb.js" type="text/javascript"></script>

    <script type='text/javascript' src='Template/Scripts/flickity-docs.min.js'></script>
    <link rel='stylesheet' href='Template/Styles/flickity-docs.css' type='text/css'/>

    <script>
        $(document).ready(function () {

            var elem = document.querySelector('#flickity');
            var elem2 = document.querySelector('.gallery');
            var elem3 = document.querySelector('#flickity3');
            var flkty = new Flickity(elem, {
                // options
                cellAlign: 'right',
                contain: true,
                freeScroll: true,
                pageDots: false,
                rightToLeft: true,
                prevNextButtons: false
            });

            var flkty = new Flickity(elem2, {
                // options
                cellAlign: 'right',
                contain: true,
                freeScroll: true,
                pageDots: false,
                rightToLeft: true,
                prevNextButtons: false
            });

            var flkty = new Flickity(elem3, {
                // options
                cellAlign: 'right',
                contain: true,
                freeScroll: true,
                pageDots: false,
                rightToLeft: true,
                prevNextButtons: false
            });
        });

    </script>

    <!--Main Content-->
    <div class="success-message" style="display: none;" id="success-compare">محصول با موفقیت به لیست مقایسه
        افزوده شد!
    </div>
    <div class="error-message" style="display: none;" id="error-compare">شما قبلا این محصول را به لیست
        مقایسه اضافه
        کردید!
    </div>

    <div class="success-message" style="background-color: #fff49e; color: black;" id="cart-warning-cart-msg">
        محصول قبلا به سبد خرید اضافه شده است
    </div>
    <div class="container">
        <div class="main-container">
            <?php
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/GroupDataSource.inc';
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SubGroupDataSource.inc';
            require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SupperGroupDataSource.inc';
            $gds = new GroupDataSource();
            $gds->open();
            $groups = $gds->Fill();
            $group1 = $gds->FirstId();
            $gds->close();

            $sbgds = new SubGroupDataSource();
            $sbgds->open();

            $spgds = new SupperGroupDataSource();
            $spgds->open();

            if (isset($_GET['group'])) {
                $subgroups = $sbgds->FillByGroup($_GET['group']);
                $GID = $_GET['group'];
                $SBGID = 0;
                $SPGID = 0;
            } else if (isset($_GET['sbgroup'])) {
                $subgroup2 = $sbgds->FindOneSubGroupBasedOnId($_GET['sbgroup']);
                $subgroups = $sbgds->FillByGroup($subgroup2->Group->GroupId);
                $supgroups = $spgds->FillBySubgroup($_GET['sbgroup']);
                $GID = $sbgds->FindOneSubGroupBasedOnId($_GET['sbgroup'])->Group->GroupId;
                $SBGID = $_GET['sbgroup'];
                $SPGID = 0;
            } else if (isset($_GET['spgroup'])) {
                $supgroup2 = $spgds->FindOneSupperGroupBasedOnId($_GET['spgroup']);
                $supgroups = $spgds->FillBySubgroup($supgroup2->SubGroup->SubGroupId);
                $subgroups = $sbgds->FillByGroup($supgroup2->Group->GroupId);
                $GID = $spgds->FindOneSupperGroupBasedOnId($_GET['spgroup'])->Group->GroupId;
                $SBGID = $supgroup2->SubGroup->SubGroupId;
                $SPGID = $_GET['spgroup'];
            } else {
                $subgroups = $sbgds->FillByGroup($group1);
                $GID = $group1;
                $SBGID = 0;
                $SPGID = 0;
            }

            echo '<div class="row" id="catmenu" style="margin-top: -15px; margin-bottom: 15px;">';
            echo '<ul class="gallery">';
            foreach ($groups as $g) {
                $select = "";
                if ($GID == $g->GroupId) {
                    $select = "selected";
                }
                echo '<a href="Products.php?group=' . $g->GroupId . '">';
                echo '<li class="gallery-cell gallery_category_mob ' . $select . '" id="' . $g->GroupId . '">';
                echo '<div class="image">';
                echo '<img src="' . $g->Image . '">';
                echo '</div>';
                echo '<div class="text">';
                echo $g->Name;
                echo '</div>';
                echo '</li>';
                echo '</a>';
            }
            echo '</ul>';
            echo '<div class="clear-fix"></div>';
            echo '<div id="category-list2">';
            echo ' <div class="items" id="flickity">';


            $sb1 = 0;
            $sbgds->close();
            $sb_i = 0;
            foreach ($subgroups as $sb) {
                if ($sb_i == 0) {
                    $sb1 = $sb->SubGroupId;
                }
                $select = "";
                if ($SBGID == $sb->SubGroupId) {
                    $select = "selected";
                }
                echo '<a class="' . $select . '" href="Products.php?sbgroup=' . $sb->SubGroupId . '">';
                echo '<div class="gallery-cell">';
                echo $sb->Name;
                echo '</div>';
                echo '</a>';
                $sb_i++;
            }
            echo '</div>';
            echo '</div>';

            echo '<div id="category-list3">';
            echo ' <div class="items" id="flickity3">';

            if (isset($_GET['group'])) {
                $supgroups = $spgds->FillBySubgroup($sb1);
            } else if (isset($_GET['sbgroup'])) {
            } else if (isset($_GET['spgroup'])) {
            } else {
                $supgroups = $spgds->FillBySubgroup($sb1);
            }

            $spgds->close();
            foreach ($supgroups as $spb) {
                $select = "";
                if ($SPGID == $spb->SupperGroupId) {
                    $select = "selected";
                }
                echo '<a class="' . $select . '" href="Products.php?spgroup=' . $spb->SupperGroupId . '">';
                echo '<div class="gallery-cell">';
                echo $spb->Name;
                echo '</div>';
                echo '</a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            ?>

            <div class="row">
                <div class="content col-md-8">
                    <!--Content-->
                    <div class="Products">
                        <div class="header">
                            <div class="title col-md-12">
                                <span>محصولات</span>
                            </div>
                        </div>
                        <div class="header-line"></div>

                        <div class="Search">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="order">
                                        <span> مرتب سازی بر اساس</span>
                                        <select id="Order1">
                                            <option value="ProductId">تازگی</option>
                                            <option value="Price">قیمت</option>
                                            <option value="Sells" <?php
                                            if (isset($_GET['BestSellers'])) {
                                                echo ' selected ';
                                            }
                                            ?>>فروش
                                            </option>
                                            <option value="Visits">بازدید</option>
                                            <option value="Popularity" <?php
                                            if (isset($_GET['MostPopular'])) {
                                                echo ' selected ';
                                            }
                                            ?> >محبوبیت
                                            </option>
                                        </select>
                                        <select id="Order2">
                                            <option value="DESC">نزولی</option>
                                            <option value="ASC">صعودی</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <input type="text" name="search_box" id="search_box2"
                                           placeholder="جستجو بین کالاهای زیر..."/>
                                </div>
                            </div>
                        </div>
                        <div id="products">
                            <div class="db-cover5" id="wait">
                                <span class="loading-title"></span>
                                <img class="loading-gif" src="Template/Images/loading.gif" alt=""/>
                            </div>

                            <div class="row">
                                <div class="TBL">
                                    <?php
                                    $i = 0;
                                    $j = 30;
                                    foreach ($products as $p1) {
                                        $i++;
                                    }
                                    $pages = ceil($i / $j);
                                    $pp2 = 1;

                                    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/UI/WidgetBuilder.php';
                                    //                                    if (count($products) != 0 && !isset($_GET['special_offers'])) {
                                    if (count($products) != 0) {
                                        foreach ($products as $p1) {
                                            //TODO START

                                            if (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == TRUE && ($_SESSION[SESSION_INT_CURRENT_PAGE] * 30) - (30 - 1) <= $pp2 && $pp2 <= $_SESSION[SESSION_INT_CURRENT_PAGE] * 30) {
                                                if ($settings->AskQuantityForAdding == 1) {
                                                    WidgetBuilder::createProductThumbWidgetInstantPurchase($p1, $tax);
                                                } else {
                                                    WidgetBuilder::createProductThumbWidget($p1, $tax);
                                                }
                                            } elseif (isset($_SESSION[SESSION_INT_CURRENT_PAGE]) == FALSE && 1 <= $pp2 && $pp2 <= 30) {
                                                if ($settings->AskQuantityForAdding == 1) {
                                                    WidgetBuilder::createProductThumbWidgetInstantPurchase($p1, $tax);
                                                } else {
                                                    WidgetBuilder::createProductThumbWidget($p1, $tax);
                                                }
                                            }
                                            //TODO END
                                            $pp2++;
                                        }
                                    }
//                                    elseif (isset($_GET['special_offers'])) {
//
//                                        foreach ($products as $p1) {
//                                            if ($settings->AskQuantityForAdding == 1) {
//                                                WidgetBuilder::createProductThumbWidgetInstantPurchase($p1, $tax);
//                                            } else {
//                                                WidgetBuilder::createProductThumbWidget($p1, $tax);
//                                            }
//                                        }
//
//                                    }
                                    else {
                                        ?>
                                        <div class="search-error-p">
                                            <div>متاسفانه موردی بین محصولات پیدا نشد.</div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>


                            <?php
                            if ($pages != 1 && $products != null) { ?>
                                <div class="Pager">
                                    <a class="page-link" id="1" href="">صفحه اول</a>
                                    <?php
                                    $s = 1;
                                    for ($j = 1; $j <= $pages; $j++) {
                                        if ($j <= 5) {
                                            echo ' <a class="page-link ';
                                            if ($j == 1) {
                                                echo ' Selected ';
                                            }
                                            echo '" id="' . $j . '" ';
                                            echo ' href="">' . $j . '</a>';
                                        }
                                        if ($j == 5) {
                                            echo ' <span >...</span>';
                                        }
                                    }
                                    ?>
                                    <a id="<?php echo $pages; ?>" class="page-link" href="">آخرین صفحه</a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div id="div"></div>
                    <?php
                    //    $product4 = $color->getUniqueProducts();
                    //
                    //    foreach ($product4 as $ppp)
                    //    {
                    //        echo $ppp;
                    //        echo '<br /> ';
                    //    }
                    ?>
                    <!--SideBar-->

                    <aside>
                        <div class="Options">
                            <div class="header">
                                <div class="title">
                                    <span>گزینه های جستجو</span>
                                </div>
                            </div>
                            <div class="header-line"></div>
                            <?php
                            if (!isset($SupperGroupId)) {
                            ?>
                            <div class="Category" id="price-option">
                                <ul>
                                    <li>
                                        <div class="Title" id="price-option-title">بر اساس قیمت ( تومان )</div>
                                    </li>
                                    <li style="width: 245px;  ">
                                        <br/>
                                        <div class="" id="priceSlider"></div>
                                        <div class="left-price" id="lower-value"></div>
                                        <div class="right-price" id="upper-value"></div>
                                        <br/>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            if (isset($logos) && !isset($_GET['brand'])) {
                                ?>
                                <div class="Category" id="brand-option">
                                    <ul class="needmore">
                                        <li>
                                            <div class="Title" id="brand-option-title">بر اساس برند محصول</div>
                                        </li>
                                        <?php
                                        foreach ($logos as $l) {
                                            ?>
                                            <li>
                                                <div class="checkbox2">
                                                    <div class="checkboxFour">
                                                        <input type="checkbox" class="checkboxCheck"
                                                               value="brand-<?php echo $l->LogoId; ?>"
                                                               id="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                               name=""/>
                                                        <label for="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                               class="checklabel"></label>
                                                    </div>
                                                    <label class="chblabel"
                                                           for="checkboxFourInput<?php echo $checkboxCounter; ?>"><?php echo $l->Name; ?>
                                                        | <?php echo $l->LatinName; ?></label>
                                                </div> <?php $checkboxCounter++ ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="Category" id="color-option">
                                <ul class="needmore">
                                    <li>
                                        <div class="Title" id="color-option-title">بر اساس رنگ</div>
                                    </li>
                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/ColorListDataSource.inc";
                                    $ucolor = new ColorListDataSource();
                                    $ucolor->open();
                                    $ucolors = $ucolor->Fill2();
                                    $ucolor->close();
                                    foreach ($ucolors as $c) {
                                        ?>
                                        <li>
                                            <div class="color-sample"
                                                 style="background-color: <?php echo $c->Sample; ?>; "></div>
                                            <div class="checkbox2">
                                                <div class="checkboxFour">
                                                    <input type="checkbox" class="checkboxCheck"
                                                           value="color-<?php echo $c->ColorListId; ?>"
                                                           id="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           name=""/>
                                                    <label for="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           class="checklabel"></label>
                                                </div>
                                                <label class="chblabel"
                                                       for="checkboxFourInput<?php echo $checkboxCounter; ?>"><?php echo $c->Name; ?></label>
                                            </div> <?php $checkboxCounter++; ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                        }
                        else {
                            ?>
                            <div class="Category" id="price-option">
                                <ul>
                                    <li>
                                        <div class="Title" id="price-option-title">بر اساس قیمت ( تومان )</div>
                                    </li>
                                    <li style="width: 245px;  ">
                                        <br/>
                                        <div class="" id="priceSlider"></div>
                                        <div class="left-price" id="lower-value"></div>
                                        <div class="right-price" id="upper-value"></div>
                                        <br/>
                                    </li>
                                </ul>
                            </div>
                        <?php
                        $ppids = '';
                        foreach ($properties as $p) {
                        $propertyId = $p->ProductPropertyId;
                        if (trim($p->Value) == '-' || trim($p->Value) == '') {
                        ?>
                            <script>
                                $(document).ready(function () {
                                    $('#property<?php echo $p->ProductPropertyId; ?>-option').hover(function () {
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('border-color', '#09f');
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('color', '#09f');
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('transition', 'color 0.3s,border 0.3s');
                                    }, function () {
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('border-color', '');
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('color', '');
                                    });
                                });
                            </script>
                            <div class="Category" id="property<?php echo $p->ProductPropertyId; ?>-option">
                                <ul class="needmore">
                                    <li>
                                        <div class="Title"
                                             id="property<?php echo $p->ProductPropertyId; ?>-option-title">بر
                                            اساس <?php echo $p->Name; ?></div>
                                    </li>
                                    <?php
                                    $i = 0;
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/ProductAndPropertyDataSource.inc';
                                    $panp = new ProductAndPropertyDataSource();
                                    $panp->open();
                                    $panps = $panp->FindSpeceficProperty($p->Name, $p->Group->SupperGroupId);
                                    $panp->close();
                                    $i = 0;
                                    foreach ($panps as $p) {
                                        $upapsValues[$i] = $p->Value;
                                        $i++;
                                    }
                                    if (isset($upapsValues)) {
                                        $upap = array_unique($upapsValues);
                                        sort($upap);
                                        foreach ($upap as $p) {
                                            if (trim($p) != "") {
                                                ?>
                                                <li>
                                                    <div class="checkbox2">
                                                        <div class="checkboxFour">
                                                            <input type="checkbox" class="checkboxCheck"
                                                                   value="property-<?php echo $propertyId . '-' . $p; ?>"
                                                                   id="checkboxFourInput<?php echo $checkboxCounter; ?>"/>
                                                            <label for="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                                   class="checklabel"></label>
                                                        </div>
                                                        <label class="chblabel"
                                                               for="checkboxFourInput<?php echo $checkboxCounter; ?>"><?php echo $p; ?></label>
                                                    </div> <?php $checkboxCounter++; ?>
                                                </li>
                                                <?php
                                            }
                                        }
                                    } else {
                                        echo "فیلتر در حال حاضر در دسترس نیست.";
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php
                        } elseif (trim($p->Value) == 'دارد-ندارد') {
                            $ppids .= "," . $p->ProductPropertyId;
                        }
                        else {
                        ?>
                            <script>
                                $(document).ready(function () {
                                    $('#property<?php echo $p->ProductPropertyId; ?>-option').hover(function () {
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('border-color', '#09f');
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('color', '#09f');
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('transition', 'color 0.3s,border 0.3s');
                                    }, function () {
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('border-color', '');
                                        $('#property<?php echo $p->ProductPropertyId; ?>-option-title').css('color', '');
                                    });
                                });
                            </script>
                            <div class="Category" id="property<?php echo $p->ProductPropertyId; ?>-option">
                                <ul class="needmore">
                                    <li>
                                        <div class="Title"
                                             id="property<?php echo $p->ProductPropertyId; ?>-option-title">بر
                                            اساس <?php echo $p->Name; ?></div>
                                    </li>
                                    <?php
                                    $values = explode('-', $p->Value);
                                    foreach ($values as $v) {
                                        ?>
                                        <?php
                                        ?>
                                        <li>
                                            <div class="checkbox2">
                                                <div class="checkboxFour">
                                                    <input type="checkbox" class="checkboxCheck"
                                                           value="property-<?php echo $propertyId . '-' . $v; ?>"
                                                           id="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           name=""/>
                                                    <label for="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           class="checklabel"></label>
                                                </div>
                                                <label class="chblabel"
                                                       for="checkboxFourInput<?php echo $checkboxCounter; ?>"><?php echo $v; ?></label>
                                            </div> <?php $checkboxCounter++ ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php
                        }
                        }
                        $properties2 = array();
                        if ($ppids != "") {
                            $i = 0;
                            $IDS = explode(",", $ppids);
                            $property = new ProductPropertyDataSource();
                            $property->open();
                            foreach ($IDS as $id) {
                                if ($id != "") {

                                    $properties2[$i] = $property->FindOneProductPropertyBasedOnId($id);
                                    $i++;
                                }
                            }
                            $property->close();
                        }
                        ?>
                            <script>
                                $(document).ready(function () {
                                    $('#property-check-option').hover(function () {
                                        $('#property-check-option-title').css('border-color', '#09f');
                                        $('#property-check-option-title').css('color', '#09f');
                                        $('#property-check-option-title').css('transition', 'color 0.3s,border 0.3s');
                                    }, function () {
                                        $('#property-check-option-title').css('border-color', '');
                                        $('#property-check-option-title').css('color', '');
                                    });
                                });
                            </script>
                        <?php
                        if ($properties2 != null) {
                        ?>
                            <div class="Category" id="property-check-option">
                                <ul class="needmore">
                                    <li>
                                        <div class="Title" id="property-check-option-title">بر اساس محصولات دارای...
                                        </div>
                                    </li>
                                    <?php
                                    foreach ($properties2 as $p) {
                                        ?>
                                        <li>
                                            <div class="checkbox2">
                                                <div class="checkboxFour">
                                                    <input type="checkbox" class="checkboxCheck"
                                                           value="property-<?php echo $p->ProductPropertyId . '-' . 'دارد'; ?>"
                                                           id="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           name=""/>
                                                    <label for="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           class="checklabel"></label>
                                                </div>
                                                <label class="chblabel"
                                                       for="checkboxFourInput<?php echo $checkboxCounter; ?>"><?php echo $p->Name; ?></label>
                                            </div> <?php $checkboxCounter++ ?>
                                        </li>
                                        <?php

                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if (isset($logos) && !isset($_GET['brand'])) {
                        ?>
                            <div class="Category" id="brand-option">
                                <ul class="needmore">
                                    <li>
                                        <div class="Title" id="brand-option-title">بر اساس برند محصولات</div>
                                    </li>
                                    <?php
                                    foreach ($logos as $l) {
                                        ?>
                                        <li>
                                            <div class="checkbox2">
                                                <div class="checkboxFour">
                                                    <input type="checkbox" class="checkboxCheck"
                                                           value="brand-<?php echo $l->LogoId; ?>"
                                                           id="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           name=""/>
                                                    <label for="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           class="checklabel"></label>
                                                </div>
                                                <label class="chblabel"
                                                       for="checkboxFourInput<?php echo $checkboxCounter; ?>"><?php echo $l->Name; ?>
                                                    | <?php echo $l->LatinName; ?></label>
                                            </div> <?php $checkboxCounter++ ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php
                        }
                        ?>
                            <div class="Category" id="color-option">
                                <ul class="needmore">
                                    <li>
                                        <div class="Title" id="color-option-title">بر اساس رنگ ها</div>
                                    </li>
                                    <?php
                                    require_once __DIR__ . DIRECTORY_SEPARATOR . "ClassesEx/datasource/ColorListDataSource.inc";
                                    $ucolor = new ColorListDataSource();
                                    $ucolor->open();
                                    $ucolors = $ucolor->Fill2();
                                    $ucolor->close();
                                    foreach ($ucolors as $c) {
                                        ?>
                                        <li>
                                            <div class="color-sample"
                                                 style="background-color: <?php echo $c->Sample; ?>; "></div>
                                            <div class="checkbox2">
                                                <div class="checkboxFour">
                                                    <input type="checkbox" class="checkboxCheck"
                                                           value="color-<?php echo $c->ColorListId; ?>"
                                                           id="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           name=""/>
                                                    <label for="checkboxFourInput<?php echo $checkboxCounter; ?>"
                                                           class="checklabel"></label>
                                                </div>
                                                <label class="chblabel"
                                                       for="checkboxFourInput<?php echo $checkboxCounter; ?>"><?php echo $c->Name; ?></label>
                                            </div> <?php $checkboxCounter++; ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>

                            <?php
                        }
                        if (isset($groups) && isset($subgroups) && isset($suppergroups)) {
                            ?>
                            <div class="Categorize">
                                <header>
                                    <h3>
                                        دسته بندی ها
                                    </h3>
                                </header>
                                <div class="header">
                                    <div class="title">
                                        <span>دسته بندی ها</span>
                                    </div>
                                </div>
                                <div class="header-line"></div>
                                <table>
                                    <?php
                                    foreach ($groups as $gp) {
                                        ?>
                                        <tr class="first">
                                            <td><span class="first"><b><?php echo $gp->Name; ?></b></span><span
                                                        class="latin"><b><?php echo $gp->LatinName; ?></b></span></td>
                                        </tr>
                                        <?php
                                        foreach ($subgroups as $sgp) {
                                            if ($sgp->Group->GroupId == $gp->GroupId) {
                                                ?>
                                                <tr class="second">
                                                    <td>
                                                        <a href="Products.php?sbgroup=<?php echo $sgp->SubGroupId; ?>"><span
                                                                    class="second"><?php echo $sgp->Name; ?></span></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $titleid = 0;

                                                $submenu = new SubMenu();

                                                $submenu->SubGroup = $sgp->SubGroupId;


                                                $subds = new SubMenuDataSource();
                                                $subds->open();
                                                $sbmenus = $subds->getBySubgroup($submenu);
                                                $subds->close();


                                                $suppermenu = new SupperMenuDataSource();
                                                $suppermenu->open();
                                                foreach ($sbmenus as $sb) {
                                                    $mtds = new MenuTitleDataSource();
                                                    $mtds->open();
                                                    $titles = $mtds->getOneSubMenuTitles($sb->SubMenuId);
                                                    $mtds->close();
                                                    foreach ($titles as $t) {
                                                        $titleid = $t->MenuTitleId;
                                                        $print = false;
                                                        $spmenus = $suppermenu->getSupperMenusOfThisTitle($t->MenuTitleId);

                                                        foreach ($spmenus as $sp) {
                                                            foreach ($suppergroups as $sp2) {
                                                                if ($sp2->SupperGroupId == $sp->SupperGroup->SupperGroupId) {
                                                                    $print = true;
                                                                }
                                                            }
                                                        }
                                                        if ($print == true) {
                                                            ?>
                                                            <tr class="third">
                                                                <td>
                                            <span class="third"><a
                                                        href="Products.php?tid=<?php echo $t->MenuTitleId; ?>"><?php echo $t->Name; ?></a></span>
                                                                </td>
                                                            </tr>
                                                            <?php


                                                            foreach ($spmenus as $sp) {
                                                                foreach ($suppergroups as $sp2) {
                                                                    if ($sp2->SupperGroupId == $sp->SupperGroup->SupperGroupId) {
                                                                        ?>
                                                                        <tr class="forth">
                                                                            <td>
                                                                        <span class="forth"><a
                                                                                    href="Products.php?spgroup=<?php echo $sp->SupperGroup->SupperGroupId; ?>"><?php echo $sp->SupperGroup->Name; ?></a></span>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                            <?php
                        }
                        ?>
                    </aside>
                </div>
            </div>

        </div>
    </div>
    <script>
        <?php
        if (!isset($maxprice) || !isset($minprice)) {
            $minprice = 0;
            $maxprice = 10000;
        }

        ?>
        var nonLinearSlider = document.getElementById('priceSlider');
        noUiSlider.create(nonLinearSlider, {
            start: [<?php echo $minprice; ?>, <?php echo $maxprice; ?>],
            connect: true,
            step: 1000,
            range: {
                'min': <?php echo $minprice; ?>,
                'max': <?php echo $maxprice; ?>
            },
            format: wNumb({
                decimals: 0,
                thousand: ',',
                postfix: ' تومان',
            })
        });
        var nodes = [
            document.getElementById('lower-value'), // 0
            document.getElementById('upper-value')  // 1
        ];
        nonLinearSlider.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            nodes[handle].innerHTML = values[handle];
        });
    </script>
    <script>
        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $(document).ready(function () {

            $('#price-option').hover(function () {
                $('#price-option-title').css('border-color', '#09f');
                $('#price-option-title').css('color', '#09f');
                $('#price-option-title').css('transition', 'color 0.3s,border 0.3s');
            }, function () {
                $('#price-option-title').css('border-color', '');
                $('#price-option-title').css('color', '');
            });
            $('#brand-option').hover(function () {
                $('#brand-option-title').css('border-color', '#09f');
                $('#brand-option-title').css('color', '#09f');
                $('#brand-option-title').css('transition', 'color 0.3s,border 0.3s');
            }, function () {
                $('#brand-option-title').css('border-color', '');
                $('#brand-option-title').css('color', '');
            });
            $('#color-option').hover(function () {
                $('#color-option-title').css('border-color', '#09f');
                $('#color-option-title').css('color', '#09f');
                $('#color-option-title').css('transition', 'color 0.3s,border 0.3s');
            }, function () {
                $('#color-option-title').css('border-color', '');
                $('#color-option-title').css('color', '');
            });

            $(".compare-btn-link").click(function () {
                $("#success-compare").fadeOut(250);
                $("#error-compare").fadeOut(250);
                var ID = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: 'AddToCompare.php',
                    data: {id: ID},
                    success: function (data) {
                        $('#div').html(data);
                    }
                });
            });
            $("#lower-value").bind("DOMSubtreeModified", function () {
                $("#wait").css("display", "block");
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/AjaxAdvancedSearch.php',
                        data: {
                            Price: $("#lower-value").text() + '-' + $("#upper-value").text(), <?php
                            if (isset($_GET['group'])) {
                                echo "group_id :  " . $_GET['group'];
                            } elseif (isset($_GET['tid'])) {
                                echo "supper_groups : '$TitleSupperGroups'";
                            } elseif (isset($_GET['sbgroup'])) {
                                echo "sub_group :  " . $_GET['sbgroup'];
                            } elseif (isset($_GET['spgroup'])) {
                                echo "supper_group :  " . $_GET['spgroup'];
                            } elseif (isset($_GET['brand'])) {
                                echo "brand : " . $_GET['brand'];
                            } elseif (isset($_GET['special_offers'])) {
                                echo "special_offers :  " . $_GET['special_offers'];
                            } elseif (isset($_GET['search_box'])) {
                                echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                            }
                            ?> },
                        success: function (data) {
                            $("#wait").css("display", "none");
                            $('#products').html(data);
                        }
                    });
                }, 1000);
            });
            $("#upper-value").bind("DOMSubtreeModified", function () {
                $("#wait").css("display", "block");
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/AjaxAdvancedSearch.php',
                        data: {
                            Price: $("#lower-value").text() + '-' + $("#upper-value").text(), <?php
                            if (isset($_GET['group'])) {
                                echo "group_id :  " . $_GET['group'];
                            } elseif (isset($_GET['tid'])) {
                                echo "supper_groups : '$TitleSupperGroups'";
                            } elseif (isset($_GET['sbgroup'])) {
                                echo "sub_group :  " . $_GET['sbgroup'];
                            } elseif (isset($_GET['spgroup'])) {
                                echo "supper_group :  " . $_GET['spgroup'];
                            } elseif (isset($_GET['brand'])) {
                                echo "brand : " . $_GET['brand'];
                            } elseif (isset($_GET['special_offers'])) {
                                echo "special_offers :  " . $_GET['special_offers'];
                            } elseif (isset($_GET['search_box'])) {
                                echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                            }
                            ?> },
                        success: function (data) {
                            $("#wait").css("display", "none");
                            $('#products').html(data);
                        }
                    });
                }, 1000);

            });
            var values = "";
            $(".checkboxCheck").change(function () {
                $("#wait").css("display", "block");
                if ($(this).is(":checked")) {
                    values += $(this).attr('value') + ",";
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/AjaxAdvancedSearch.php',
                        data: {
                            checked_box: values, <?php
                            if (isset($_GET['group'])) {
                                echo "group_id :  " . $_GET['group'];
                            } elseif (isset($_GET['tid'])) {
                                echo "supper_groups : '$TitleSupperGroups'";
                            } elseif (isset($_GET['sbgroup'])) {
                                echo "sub_group :  " . $_GET['sbgroup'];
                            } elseif (isset($_GET['spgroup'])) {
                                echo "supper_group :  " . $_GET['spgroup'];
                            } elseif (isset($_GET['brand'])) {
                                echo "brand : " . $_GET['brand'];
                            } elseif (isset($_GET['special_offers'])) {
                                echo "special_offers :  " . $_GET['special_offers'];
                            } elseif (isset($_GET['search_box'])) {
                                echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                            }
                            ?> },
                        success: function (data) {
                            $("#wait").css("display", "none");
                            $('#products').html(data);
                        }
                    });
                }
                else {
                    values = values.replace($(this).attr('value') + ',', '');
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/AjaxAdvancedSearch.php',
                        data: {
                            checked_box: values, <?php
                            if (isset($_GET['group'])) {
                                echo "group_id :  " . $_GET['group'];
                            } elseif (isset($_GET['tid'])) {
                                echo "supper_groups : '$TitleSupperGroups'";
                            } elseif (isset($_GET['sbgroup'])) {
                                echo "sub_group :  " . $_GET['sbgroup'];
                            } elseif (isset($_GET['spgroup'])) {
                                echo "supper_group :  " . $_GET['spgroup'];
                            } elseif (isset($_GET['brand'])) {
                                echo "brand : " . $_GET['brand'];
                            } elseif (isset($_GET['special_offers'])) {
                                echo "special_offers :  " . $_GET['special_offers'];
                            } elseif (isset($_GET['search_box'])) {
                                echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                            }
                            ?> },
                        success: function (data) {
                            $("#wait").css("display", "none");
                            $('#products').html(data);
                        }
                    });
                }
            });
            $("#Order1").change(function () {
                var order = $(this).val();
                $("#wait").css("display", "block");
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/AjaxAdvancedSearch.php',
                        data: {
                            order: order, <?php
                            if (isset($_GET['group'])) {
                                echo "group_id :  " . $_GET['group'];
                            } elseif (isset($_GET['tid'])) {
                                echo "supper_groups : '$TitleSupperGroups'";
                            } elseif (isset($_GET['sbgroup'])) {
                                echo "sub_group :  " . $_GET['sbgroup'];
                            } elseif (isset($_GET['spgroup'])) {
                                echo "supper_group :  " . $_GET['spgroup'];
                            } elseif (isset($_GET['brand'])) {
                                echo "brand : " . $_GET['brand'];
                            } elseif (isset($_GET['special_offers'])) {
                                echo "special_offers :  " . $_GET['special_offers'];
                            } elseif (isset($_GET['search_box'])) {
                                echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                            }
                            ?> },
                        success: function (data) {
                            $("#wait").css("display", "none");
                            $('#products').html(data);
                        }
                    });
                }, 1000);
            });
            $("#Order2").change(function () {
                var order = $(this).val();
                $("#wait").css("display", "block");
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/AjaxAdvancedSearch.php',
                        data: {
                            ordertype: order, <?php
                            if (isset($_GET['group'])) {
                                echo "group_id :  " . $_GET['group'];
                            } elseif (isset($_GET['tid'])) {
                                echo "supper_groups : '$TitleSupperGroups'";
                            } elseif (isset($_GET['sbgroup'])) {
                                echo "sub_group :  " . $_GET['sbgroup'];
                            } elseif (isset($_GET['spgroup'])) {
                                echo "supper_group :  " . $_GET['spgroup'];
                            } elseif (isset($_GET['brand'])) {
                                echo "brand : " . $_GET['brand'];
                            } elseif (isset($_GET['special_offers'])) {
                                echo "special_offers :  " . $_GET['special_offers'];
                            } elseif (isset($_GET['search_box'])) {
                                echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                            }
                            ?> },
                        success: function (data) {
                            $("#wait").css("display", "none");
                            $('#products').html(data);
                        }
                    });
                }, 1000);
            });
            $(".page-link").click(function (e) {
                $('html,body').animate({
                        scrollTop: $(".Products").offset().top
                    },
                    'slow');
                $("#wait").css("display", "block");
                e.preventDefault();
                $.ajax({
                    url: 'AjaxSearch/AjaxAdvancedSearch.php',
                    type: 'POST',
                    data: {
                        page: $(this).attr('id'), <?php
                        if (isset($_GET['group'])) {
                            echo "group_id :  " . $_GET['group'];
                        } elseif (isset($_GET['tid'])) {
                            echo "supper_groups : '$TitleSupperGroups'";
                        } elseif (isset($_GET['sbgroup'])) {
                            echo "sub_group :  " . $_GET['sbgroup'];
                        } elseif (isset($_GET['spgroup'])) {
                            echo "supper_group :  " . $_GET['spgroup'];
                        } elseif (isset($_GET['brand'])) {
                            echo "brand : " . $_GET['brand'];
                        } elseif (isset($_GET['special_offers'])) {
                            echo "special_offers :  " . $_GET['special_offers'];
                        } elseif (isset($_GET['search_box'])) {
                            echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                        }
                        ?>
                    },
                    success: function (result) {
                        $("#wait").css("display", "none");
                        $("#products").html(result);
                    },
                    error: function (result) {
                        alert("لطفا دوباره امتحان کنید!");
                    }
                });
            });
            $('#search_box2').on('input', function () {
                $("#wait").css("display", "block");
                delay(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'AjaxSearch/AjaxAdvancedSearch.php',
                        data: {
                            search_box: $('#search_box2').val(),
                            <?php
                            if (isset($_GET['group'])) {
                                echo "group_id :  " . $_GET['group'];
                            } elseif (isset($_GET['tid'])) {
                                echo "supper_groups : '$TitleSupperGroups'";
                            } elseif (isset($_GET['sbgroup'])) {
                                echo "sub_group :  " . $_GET['sbgroup'];
                            } elseif (isset($_GET['spgroup'])) {
                                echo "supper_group :  " . $_GET['spgroup'];
                            } elseif (isset($_GET['brand'])) {
                                echo "brand : " . $_GET['brand'];
                            } elseif (isset($_GET['special_offers'])) {
                                echo "special_offers :  " . $_GET['special_offers'];
                            } elseif (isset($_GET['search_box'])) {
                                echo "whole_search_box  : '" . $_GET['search_box'] . "'";
                            }
                            ?>
                        },
                        success: function (data) {
                            $("#wait").css("display", "none");
                            $('#products').html(data);
                        }

                    });
                }, 1000);
            });


        });
    </script>
<?php
include_once "Template/bottom.php";
    