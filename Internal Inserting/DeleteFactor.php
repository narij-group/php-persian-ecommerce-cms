


<?php



// TODO ERROR
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/FactorProductDataSource.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/ProductColorDataSource.inc";

$pr = new ProductColorDataSource();
$pr->open();

$fp = new FactorProductDataSource();
$fp->open();
$fps = $fp->FillByCode($_GET['code']);
foreach ($fps as $f) {
    if ($f->Status == 0) {
        $prs = $pr->GetProductColorsForOneProduct($f->Product->ProductId);
        foreach ($prs as $p) {
            if ($p->Color->Name == $f->Color) {
                $p->Quantity = $p->Quantity + $f->Count;
                $pr->UpdateQuantity($p);
            }
        }
        $fp->CDelete($f->FactorProductId);
    }
}
$pr->close();
$pr->close();
header('location:../UserProfile.php');