<?php

require_once 'DataAccess.inc';
require_once 'ColorList.inc';

class ProductColor
{

    public $ProductColorId;
    public $Product;
    public $Color;
    public $Quantity;

    public function __construct()
    {
        $this->ProductColorId = 0;
        $this->Product = 0;
        $this->Color = new ColorList();
        $this->Quantity = 0;
    }

    public function Insert()
    {

        $SQL = "Insert Into productcolors(`Product`,Color,Quantity) Values (" . $this->Product . "," . $this->Color . " , " . $this->Quantity . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update productcolors Set Color=" . $this->Color . " , Quantity=" . $this->Quantity . " Where ProductColorId=" . $this->ProductColorId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function UpdateQuantity()
    {
        $SQL = "Update productcolors Set Quantity=" . $this->Quantity . " Where ProductColorId=" . $this->ProductColorId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From `productcolors` Where ProductColorId= " . $this->ProductColorId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneProductColor()
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color Where ProductColorId=" . $this->ProductColorId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $productcolor = new ProductColor();
            $productcolor->ProductColorId = $row['ProductColorId'];
            $productcolor->Product = $row['Product'];
            $productcolor->Color->ColorListId = $row['ColorListId'];
            $productcolor->Color->Name = $row['Name'];
            $productcolor->Color->Sample = $row['Sample'];
            $productcolor->Quantity = $row['Quantity'];
            return $productcolor;
        }
    }

    public function FindOneProductColor2($color, $product)
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color Where `Name` ='" . $color . "' AND Product = " . $product;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $productcolor = new ProductColor();
            $productcolor->ProductColorId = $row['ProductColorId'];
            $productcolor->Product = $row['Product'];
            $productcolor->Color->ColorListId = $row['ColorListId'];
            $productcolor->Color->Name = $row['Name'];
            $productcolor->Color->Sample = $row['Sample'];
            $productcolor->Quantity = $row['Quantity'];
            return $productcolor;
        }
    }

    public function FindOneColorQuantity()
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color Where Color='" . $this->Color . "' And Product=" . $this->Product;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Quantity'];
        }
    }

    public function Fill()
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $productcolors = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productcolor = new ProductColor();
            $productcolor->ProductColorId = $row['ProductColorId'];
            $productcolor->Product = $row['Product'];
            $productcolor->Color->ColorListId = $row['ColorListId'];
            $productcolor->Color->Name = $row['Name'];
            $productcolor->Color->Sample = $row['Sample'];
            $productcolor->Quantity = $row['Quantity'];
            $productcolors[$i] = $productcolor;
            $i++;
        }
        return $productcolors;
    }

    public function getUniqueProducts()
    {
        $SQL = "SELECT ProductColorId, (Select Sum(Quantity) from productcolors where Product = Products.ProductId) as Quantity,Product FROM `productcolors` Inner Join Products on ProductId = Product ORDER BY Quantity =0, ProductId DESC ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $productcolors = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productcolors[$i] = $row['Product'];
            $i++;
        }
        return array_unique($productcolors);
    }

    public function GetProductColorsForOneProduct($productId)
    {
        $SQL = "Select * From productcolors Inner Join colorlists on ColorListId = Color Where Product=" . $productId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $productcolors = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productcolor = new ProductColor();
            $productcolor->ProductColorId = $row['ProductColorId'];
            $productcolor->Product = $row['Product'];
            $productcolor->Color->ColorListId = $row['ColorListId'];
            $productcolor->Color->Name = $row['Name'];
            $productcolor->Color->Sample = $row['Sample'];
            $productcolor->Quantity = $row['Quantity'];
            $productcolors[$i] = $productcolor;
            $i++;
        }
        return $productcolors;
    }

    public function GetProductsOfColor($colorid)
    {
        $SQL = "Select * From productcolors Inner Join colorlists on ColorListId = Color Where Color = " . $colorid ." Order By Product DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $productcolors = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productcolor = new ProductColor();
            $productcolor->ProductColorId = $row['ProductColorId'];
            $productcolor->Product = $row['Product'];
            $productcolor->Color->ColorListId = $row['ColorListId'];
            $productcolor->Color->Name = $row['Name'];
            $productcolor->Color->Sample = $row['Sample'];
            $productcolor->Quantity = $row['Quantity'];
            $productcolors[$i] = $productcolor;
            $i++;
        }
        return $productcolors;
    }

    public function FindColor($productId, $color)
    {
        $SQL = "Select * From productcolors Inner Join colorlists on ColorListId = Color Where Product=" . $productId . " AND Color = " . $color;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $productcolor = new ProductColor();
            $productcolor->ProductColorId = $row['ProductColorId'];
            $productcolor->Product = $row['Product'];
            $productcolor->Color = $row['ColorListId'];
            $productcolor->Quantity = $row['Quantity'];
            return $productcolor;
        }
    }

    public function FindQuantity($productId, $color)
    {
        $SQL = "Select * From productcolors Inner Join colorlists on ColorListId = Color Where Product=" . $productId . " AND  ProductColorId= " . $color;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Quantity'];
        }
    }

}
