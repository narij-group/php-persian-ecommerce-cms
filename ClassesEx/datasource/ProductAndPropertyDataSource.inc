<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/ProductAndProperty.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ProductAndPropertyDataSource
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

    public function Insert(ProductAndProperty $productAndProperty)
    {
        $SQL = "Insert Into productandproperties (Product,ProductProperty,Value)Values (" . $productAndProperty->Product . "," . $productAndProperty->ProductProperty->ProductPropertyId . " , '" . $productAndProperty->Value . "')";
        $this->da->exec($SQL);
    }

    public function Update(ProductAndProperty $productAndProperty)
    {
        $SQL = "Update productandproperties Set `Product`=" . $productAndProperty->Product . ",ProductProperty=" . $productAndProperty->ProductProperty->ProductPropertyId . ",Value='" . $productAndProperty->Value . "' Where ProductAndPropertyId= " . $productAndProperty->ProductAndPropertyId;
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From productandproperties Where ProductAndPropertyId= " . $id;
        $this->da->exec($SQL);
    }

    public function DeletePropertiesRelatedToProduct($productId)
    {
        $SQL = "DELETE  FROM  `productandproperties` Where productandproperties.Product = " . $productId;
        $this->da->exec($SQL);
    }


    public function FindValue($product, $PPId)
    {
        $SQL = "SELECT productandproperties.Value
        FROM  `productandproperties`         
        INNER JOIN `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId
        Where productandproperties.Product=" . $product . " And productandproperties.ProductProperty = " . $PPId;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Value'];
        }
    }

    public function FindOneProductAndPropertyBasedOnId($id)
    {
        $SQL = "SELECT productandproperties.ProductAndPropertyId,productandproperties.Product, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, productandproperties.ProductProperty
        FROM  `productandproperties`         
        INNER JOIN `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId
        Where ProductAndPropertyId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $pap = new ProductAndProperty();
            $pap->ProductAndPropertyId = $row['ProductAndPropertyId'];
            $pap->Value = $row['Value'];
            $pap->Product = $row['Product'];
            $pap->ProductProperty->ProductPropertyId = $row['ProductPropertyId'];
            $pap->ProductProperty->Name = $row['ProductPropertyName'];
            return $pap;
        }
    }

    public function doesPPExist($id, $id2)
    {
        $SQL = "SELECT productandproperties.ProductAndPropertyId,productandproperties.Product, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, productandproperties.ProductProperty
        FROM  `productandproperties`         
        INNER JOIN `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId
        Where ProductProperty=" . $id . " And Product = " . $id2;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['ProductAndPropertyId'];
        }
        return FALSE;
    }

    public function FindSpeceficProperty($name, $spgroup)
    {
        $SQL = "SELECT productandproperties.ProductAndPropertyId,productandproperties.Product, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, productandproperties.ProductProperty
        FROM  `productandproperties`         
        INNER JOIN `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId
        Where productproperties.Name='" . $name . "' AND productproperties.Group = " . $spgroup . "";
        $i = 0;
        $paps = array();
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $pap = new ProductAndProperty();
            $pap->ProductAndPropertyId = $row['ProductAndPropertyId'];
            $pap->Value = $row['Value'];
            $pap->Product = $row['Product'];
            $pap->ProductProperty->ProductPropertyId = $row['ProductPropertyId'];
            $pap->ProductProperty->Name = $row['ProductPropertyName'];
            $paps[$i] = $pap;
            $i++;
        }
        return $paps;
    }

    public function Fill()
    {
        $SQL = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty
        FROM  `productandproperties` 
        INNER JOIN  `products` ON productandproperties.Product = products.ProductId
        INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId";
        $results = $this->da->execSelect($SQL);
        $paps = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $pap = new ProductAndProperty();
            $pap->ProductAndPropertyId = $row['ProductAndPropertyId'];
            $pap->Value = $row['Value'];
            $pap->Product = $row['ProductId'];
            $pap->ProductProperty->ProductPropertyId = $row['ProductPropertyId'];
            $pap->ProductProperty->Name = $row['ProductPropertyName'];
            $paps[$i] = $pap;
            $i++;
        }
        return $paps;
    }

//    public function getOneProductWithProperties() {
//        $SQL = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty
//        FROM  `productandproperties` 
//        INNER JOIN  `products` ON productandproperties.Product = products.ProductId
//        INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId";
//        $db = new DataAccess();
//        $results = $db->executeSelect($SQL);
//        $productAndProperty = new ProductAndProperty();
//        $i = 0;
//        while ($row = mysqli_fetch_array($results)) {
//            $productAndProperty->ProductAndPropertyId = $row['ProductAndPropertyId'];
//            $productAndProperty->ProductProperty->ProductPropertyId = $row['ProductPropertyId'];
//            $productAndProperty->ProductProperty->Name = $row['ProductPropertyName'];
//            $product = new Product();
//            $product->ProductId = $row['ProductId'];
//            $product->Name = $row['ProductName'];
//            $productAndProperty->Product[$i] = $product;
//            $i++;
//        }
//        return $productAndProperty;
//    }

    public function GetPropertiesForOneProduct($productId)
    {
        $SQL = "SELECT productandproperties.ProductAndPropertyId,productandproperties.Product, productandproperties.Value, productproperties.ProductPropertyId,productproperties.Group ,productproperties.Name AS ProductPropertyName, productandproperties.ProductProperty
        FROM  `productandproperties`         
        INNER JOIN `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId
        Where productandproperties.Product = " . $productId;
        $results = $this->da->execSelect($SQL);
        $paps = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $pap = new ProductAndProperty();
            $pap->ProductAndPropertyId = $row['ProductAndPropertyId'];
            $pap->Value = $row['Value'];
            $pap->Product = $row['Product'];
            $pap->ProductProperty->ProductPropertyId = $row['ProductPropertyId'];
            $pap->ProductProperty->Name = $row['ProductPropertyName'];
            $pap->ProductProperty->Group = $row['Group'];
            $paps[$i] = $pap;
            $i++;
        }
        return $paps;
    }

    public function getSameProperties($pId1, $pId2)
    {
        $SQL = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty FROM  `productandproperties`  INNER JOIN  `products` ON productandproperties.Product = products.ProductId INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId Where productandproperties.Product = " . $pId1 . " Order By  productproperties.Name ASC";
        $results = $this->da->execSelect($SQL);
        $paps = array();
        $paps2 = array();
        $final = array();
        $SQL2 = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty FROM  `productandproperties`  INNER JOIN  `products` ON productandproperties.Product = products.ProductId INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId Where productandproperties.Product = " . $pId2 . " Order By  productproperties.Name ASC";
        $results2 = $this->da->execSelect($SQL2);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $pap = new ProductAndProperty();
            $pap->ProductProperty->Name = $row['ProductPropertyName'];
            $pap->Value = $row['Value'];
            $paps[$i] = $pap;
            $i++;
        }
        $i = 0;
        while ($row = mysqli_fetch_array($results2)) {
            $pap2 = new ProductAndProperty();
            $pap2->ProductProperty->Name = $row['ProductPropertyName'];
            $pap2->Value = $row['Value'];
            $paps2[$i] = $pap2;
            $i++;
        }
        $j = 0;
        foreach ($paps as $pp) {
            foreach ($paps2 as $pp2) {
                if ($pp->ProductProperty->Name == $pp2->ProductProperty->Name) {
                    $final[$j] = $pp;
                    $j++;
                }
            }
        }
        return $final;
    }

    public function getSameProperties2($pId1, $pId2, $pId3)
    {
        $SQL = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty FROM  `productandproperties`  INNER JOIN  `products` ON productandproperties.Product = products.ProductId INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId Where productandproperties.Product = " . $pId1 . " Order By  productproperties.Name ASC";
        $results = $this->da->execSelect($SQL);
        $paps = array();
        $paps2 = array();
        $paps3 = array();
        $final = array();
        $SQL2 = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty FROM  `productandproperties`  INNER JOIN  `products` ON productandproperties.Product = products.ProductId INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId Where productandproperties.Product = " . $pId2 . " Order By  productproperties.Name ASC";
        $results2 = $this->da->execSelect($SQL2);
        $SQL3 = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty FROM  `productandproperties`  INNER JOIN  `products` ON productandproperties.Product = products.ProductId INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId Where productandproperties.Product = " . $pId3 . " Order By  productproperties.Name ASC";
        $results3 = $this->da->execSelect($SQL3);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $pap = new ProductAndProperty();
            $pap->ProductProperty->Name = $row['ProductPropertyName'];
            $pap->Value = $row['Value'];
            $paps[$i] = $pap;
            $i++;
        }
        $i = 0;
        while ($row = mysqli_fetch_array($results2)) {
            $pap2 = new ProductAndProperty();
            $pap2->ProductProperty->Name = $row['ProductPropertyName'];
            $pap2->Value = $row['Value'];
            $paps2[$i] = $pap2;
            $i++;
        }
        $i = 0;
        while ($row = mysqli_fetch_array($results3)) {
            $pap3 = new ProductAndProperty();
            $pap3->ProductProperty->Name = $row['ProductPropertyName'];
            $pap3->Value = $row['Value'];
            $paps3[$i] = $pap3;
            $i++;
        }
        $j = 0;
        foreach ($paps as $pp) {
            foreach ($paps2 as $pp2) {
                foreach ($paps3 as $pp3) {
                    if ($pp->ProductProperty->Name == $pp2->ProductProperty->Name && $pp->ProductProperty->Name == $pp3->ProductProperty->Name && $pp2->ProductProperty->Name == $pp3->ProductProperty->Name) {
                        $final[$j] = $pp;
                        $j++;
                    }
                }
            }
        }
        return $final;
    }

}
