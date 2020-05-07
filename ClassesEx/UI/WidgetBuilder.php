<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../datasource/ProductDataSource.inc';

/**
 * Created by PhpStorm.
 * User: kami
 * Date: 11/29/2017
 * Time: 2:00 AM
 */
class WidgetBuilder
{
    public static function createProductThumbWidget(Product $product, $tax)
    {
        $_GET['PRODUCT'] = serialize($product);
        $_GET['TAX'] = $tax;
        include __DIR__ . DIRECTORY_SEPARATOR . '../../Widgets/ProductThumb.widget';
    }

    public static function createProductThumbWidgetInstantPurchase(Product $product, $tax)
    {
        $_GET['PRODUCT'] = serialize($product);
        $_GET['TAX'] = $tax;
        include __DIR__ . DIRECTORY_SEPARATOR . '../../Widgets/ProductThumbInstantPurchase.widget';
    }

    public static function createProductTableRowDetailViewAdmin(Product $product, Role $role)
    {
        $_GET['PRODUCT'] = serialize($product);
        $_GET['ROLE'] = serialize($role);
        include __DIR__ . DIRECTORY_SEPARATOR . '../../Widgets/ProductTableRowDetailViewForAdmin.widget';
    }

    public static function createProductThumbViewHomePageInstantPurchase(Product $product, $tax)
    {
        $_GET['PRODUCT'] = serialize($product);
        $_GET['TAX'] = $tax;
        include __DIR__ . DIRECTORY_SEPARATOR . '../../Widgets/ProductThumbViewHomePageInstantPurchase.widget';
    }

    public static function createProductThumbViewHomePage(Product $product, $tax)
    {
        $_GET['PRODUCT'] = serialize($product);
        $_GET['TAX'] = $tax;
        include __DIR__ . DIRECTORY_SEPARATOR . '../../Widgets/ProductThumbViewHomePage.widget';
    }


}