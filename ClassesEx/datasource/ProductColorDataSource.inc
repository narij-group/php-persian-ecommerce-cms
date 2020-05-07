<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/ProductColor.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ProductColorDataSource
{

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


    public function Insert(ProductColor $productColor)
    {

        $SQL = "Insert Into productcolors(`Product`,Color,Quantity) Values (" . $productColor->Product . "," . $productColor->Color . " , " . $productColor->Quantity . ")";
        $this->da->exec($SQL);
    }

    public function Update(ProductColor $productColor)
    {
        $SQL = "Update productcolors Set Color=" . $productColor->Color . " , Quantity=" . $productColor->Quantity . " Where ProductColorId=" . $productColor->ProductColorId . "";
        $this->da->exec($SQL);
    }

    public function UpdateQuantity(ProductColor $productColor)
    {
        $SQL = "Update productcolors Set Quantity=" . $productColor->Quantity . " Where ProductColorId=" . $productColor->ProductColorId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From `productcolors` Where ProductColorId= " . $id;
        $this->da->exec($SQL);
    }

    public function DeleteProductColorsRelatedToProduct($productId)
    {
        $SQL = "DELETE productcolors.* From productcolors Inner Join colorlists on ColorListId = Color Where Product=" . $productId;
        $this->da->exec($SQL);
    }

    public function DeleteProductColorsRelatedToColorList($colorid)
    {
        $SQL = "DELETE From productcolors Where Color = " . $colorid;
        $this->da->exec($SQL);
    }


    public function FindOneProductColorBasedOnId($id)
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color Where ProductColorId=" . $id;
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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

    public function FindOneColorQuantity(ProductColor $productColor)
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color Where Color='" . $productColor->Color . "' And Product=" . $productColor->Product;
//        echo $SQL;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Quantity'];
        }
    }

    public function FindOneColorQuantity2($product, $color)
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color Where Color='" . $color . "' And Product=" . $product;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Quantity'];
        }
    }

    public function FindAllColorsOfOneProduct($product)
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color Where Product=" . $product;
        $results = $this->da->execSelect($SQL);
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

    public function Fill()
    {
        $SQL = "Select * From `productcolors` Inner Join colorlists on ColorListId = Color";
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
//        echo $SQL;
//        echo "<br>";
        $results = $this->da->execSelect($SQL);
        $productcolors = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productcolor = new ProductColor();
            $productcolor->ProductColorId = $row['ProductColorId'];
//            echo $row['ProductColorId'];
//            echo "<br>";
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
        $SQL = "Select * From productcolors Inner Join colorlists on ColorListId = Color Where Color = " . $colorid . " Order By Product DESC";
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Quantity'];
        }
    }

}
