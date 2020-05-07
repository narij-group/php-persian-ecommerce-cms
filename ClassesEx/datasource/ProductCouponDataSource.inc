<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/ProductCoupon.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ProductCouponDataSource {


    public $da;

    function __construct()
    {
        $this->da = new DataAccessEx();
    }

    public function open()
    {
        $this->da->open();
    }

    public function close()
    {
        $this->da->close();
    }

    public function Insert(ProductCoupon $productCoupon) {

        $SQL = "Insert Into productcoupons(`Date`,Value,Product,User) Values ('" . $productCoupon->Date . "'," . $productCoupon->Value . "," . $productCoupon->Product . " , " . $productCoupon->User . ")";
        $this->da->exec($SQL);
    }

    public function Update(ProductCoupon $productCoupon) {
        $SQL = "Update productcoupons Set `Date`='" . $productCoupon->Date . "',Value = " . $productCoupon->Value . " Where ProductCouponId=" . $productCoupon->ProductCouponId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id) {
        $SQL = "Delete From productcoupons Where ProductCouponId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneProductCouponBasedOnId($id) {
        $SQL = "Select productcoupons.ProductCouponId , productcoupons.Date , productcoupons.Value ,products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as Name1 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `productcoupons` Inner Join users On productcoupons.User = users.UserId Inner Join products On productcoupons.Product = products.ProductId  Where ProductCouponId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $productcoupon = new ProductCoupon();
            $productcoupon->ProductCouponId = $row['ProductCouponId'];
            $productcoupon->Date = $row['Date'];
            $productcoupon->Value = $row['Value'];
            $productcoupon->Product->ProductId = $row['ProductId'];
            $productcoupon->Product->Name = $row['ProductName'];
            $productcoupon->Product->LatinName = $row['LatinName'];
            $productcoupon->Product->Description = $row['Description'];
            $productcoupon->Product->Image = $row['Image'];
            $productcoupon->User->UserId = $row['UserId'];
            $productcoupon->User->Name = $row['Name1'];
            $productcoupon->User->Family = $row['Family'];
            $productcoupon->User->Username = $row['Username'];
            return $productcoupon;
        }
    }

    public function FindOneProductCoupons($product) {
        $SQL = "Select productcoupons.ProductCouponId , productcoupons.Date , productcoupons.Value ,products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as Name1 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `productcoupons` Inner Join users On productcoupons.User = users.UserId Inner Join products On productcoupons.Product = products.ProductId Where productcoupons.Product=" . $product;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $productcoupon = new ProductCoupon();
            $productcoupon->ProductCouponId = $row['ProductCouponId'];
            $productcoupon->Date = $row['Date'];
            $productcoupon->Value = $row['Value'];
            $productcoupon->Product->ProductId = $row['ProductId'];
            $productcoupon->Product->Name = $row['ProductName'];
            $productcoupon->Product->LatinName = $row['LatinName'];
            $productcoupon->Product->Description = $row['Description'];
            $productcoupon->Product->Image = $row['Image'];
            $productcoupon->User->UserId = $row['UserId'];
            $productcoupon->User->Name = $row['Name1'];
            $productcoupon->User->Family = $row['Family'];
            $productcoupon->User->Username = $row['Username'];
            return $productcoupon;
        }
    }
    
    public function FindOneProductCoupons2($product) {
        $SQL = "Select productcoupons.ProductCouponId , productcoupons.Value from productcoupons Where Product=" . $product ." Order by ProductCouponId DESC LIMIT 1";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {                                    
            return $row['Value'];
        }
    }
    public function GetLastProductCouponsForOneProductInfo($product) {
        $SQL = "Select productcoupons.ProductCouponId,productcoupons.Value from productcoupons Where Product=" . $product ." Order by ProductCouponId DESC LIMIT 1";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {                                    
            $productcoupon = new ProductCoupon();
            $productcoupon->ProductCouponId = $row['ProductCouponId'];
            $productcoupon->Value = $row['Value'];
            return $productcoupon;
        }        
    }

    public function Fill() {
        $SQL = "Select productcoupons.ProductCouponId , productcoupons.Date , productcoupons.Value ,products.ProductId , products.Name as ProductName , products.LatinName , products.Description , products.Image , users.UserId , users.Name as Name1 , users.Family , users.Username , users.Password, users.Email, users.Activate, users.ActiveCode From `productcoupons` Inner Join users On productcoupons.User = users.UserId Inner Join products On productcoupons.Product = products.ProductId ";
        $results = $this->da->execSelect($SQL);
        $productcoupons = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productcoupon = new ProductCoupon();
            $productcoupon->ProductCouponId = $row['ProductCouponId'];
            $productcoupon->Date = $row['Date'];
            $productcoupon->Value = $row['Value'];
            $productcoupon->Product->ProductId = $row['ProductId'];
            $productcoupon->Product->Name = $row['ProductName'];
            $productcoupon->Product->LatinName = $row['LatinName'];
            $productcoupon->Product->Description = $row['Description'];
            $productcoupon->Product->Image = $row['Image'];
            $productcoupon->User->UserId = $row['UserId'];
            $productcoupon->User->Name = $row['Name1'];
            $productcoupon->User->Family = $row['Family'];
            $productcoupon->User->Username = $row['Username'];
            $productcoupons[$i] = $productcoupon;
            $i++;
        }
        return $productcoupons;
    }

}
