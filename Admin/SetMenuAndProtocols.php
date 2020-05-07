<?php

require_once 'Template/top2.php';
//--------------------------menu----------------------
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';

$muds = new MenuDataSource();
$muds->open();
$menu = new Menu();
$menu->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$menu->MainMenu = $_POST['mainmenu'];
$menu->SubMenu = $_POST['submenu'];
if (trim($_POST['suppermenu']) == "") {
    $menu->SupperMenu = 0;
} else {
    $menu->SupperMenu = $_POST['suppermenu'];
}
if (trim($menu->MainMenu) != "" || trim($menu->SubMenu) != "") {
    $muds->Insert($menu);
}

$muds->close();
//--------------------------guarantee----------------------
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';

$guarantee = new Guarantee();
$guarantee->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$guarantee->Name = $_POST['guarantee-name'];
$guarantee->Price = $_POST['guarantee-price'];
$guarantee->ExpireTime = $_POST['guarantee-expiretime'];
$guarantee->Date = date("Y/m/d");

$grds = new GuaranteeDataSource();
$grds->open();
$grds->Insert($guarantee);
$grds->close();
//--------------------------price----------------------
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/PriceDataSource.inc';

$price = new Price();
$price->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
$price->Value = $_POST['product-price'];
$price->User = $_POST['user'];
$price->Date = date("Y/m/d");

$prds = new PriceDataSource();
$prds->open();
$prds->Insert($price);
$prds->close();

//-----------------protocols---------------------
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolListDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProtocolDataSource.inc';

$protocollist = new ProtocolListDataSource();
$protocollist->open();
$protocollists = $protocollist->Fill();
$protocollist->close();

foreach ($protocollists as $p) {
    if (isset($_POST[$p->ProtocolListId])) {
        $protocol = new Protocol();
        $protocol->Product = $_SESSION[SESSION_INT_PRODUCT_ID];
        $protocol->ProtocolList = $p->ProtocolListId;

        $pds = new ProtocolDataSource();
        $pds->open();
        $pds->Insert($protocol);
        $pds->close();
    }
}

header('Location:ProductMeta.php');
