<?php

require_once 'DataAccess.inc';
require_once 'ProductProperty.inc';
require_once 'Product.inc';

class ProductAndProperty
{

    public $ProductAndPropertyId;
    public $Product;
    public $ProductProperty;
    public $Value;

    public function __construct()
    {
        $this->ProductAndPropertyId = 0;
        $this->Product = 0;
        $this->ProductProperty = new ProductProperty();
        $this->Value = "";
    }

    public function Insert()
    {
        $SQL = "Insert Into productandproperties (Product,ProductProperty,Value)Values (" . $this->Product . "," . $this->ProductProperty->ProductPropertyId . " , '" . $this->Value . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update productandproperties Set `Product`=" . $this->Product . ",ProductProperty=" . $this->ProductProperty->ProductPropertyId . ",Value='" . $this->Value . "' Where ProductAndPropertyId= " . $this->ProductAndPropertyId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From productandproperties Where ProductAndPropertyId= " . $this->ProductAndPropertyId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindValue($product, $PPId)
    {
        $SQL = "SELECT productandproperties.Value
        FROM  `productandproperties`         
        INNER JOIN `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId
        Where productandproperties.Product=" . $product . " And productandproperties.ProductProperty = " . $PPId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Value'];
        }
    }

    public function FindOneProductAndProperty()
    {
        $SQL = "SELECT productandproperties.ProductAndPropertyId,productandproperties.Product, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, productandproperties.ProductProperty
        FROM  `productandproperties`         
        INNER JOIN `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId
        Where ProductAndPropertyId=" . $this->ProductAndPropertyId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $i = 0;
        $paps = array();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $paps = array();
        $paps2 = array();
        $final = array();
        $SQL2 = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty FROM  `productandproperties`  INNER JOIN  `products` ON productandproperties.Product = products.ProductId INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId Where productandproperties.Product = " . $pId2 . " Order By  productproperties.Name ASC";
        $db2 = new DataAccess();
        $results2 = $db2->executeSelect($SQL2);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $paps = array();
        $paps2 = array();
        $paps3 = array();
        $final = array();
        $SQL2 = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty FROM  `productandproperties`  INNER JOIN  `products` ON productandproperties.Product = products.ProductId INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId Where productandproperties.Product = " . $pId2 . " Order By  productproperties.Name ASC";
        $db2 = new DataAccess();
        $db3 = new DataAccess();
        $results2 = $db2->executeSelect($SQL2);
        $SQL3 = "SELECT productandproperties.ProductAndPropertyId, productandproperties.Value, productproperties.ProductPropertyId, productproperties.Name AS ProductPropertyName, products.Name AS ProductName, products.ProductId, productandproperties.ProductProperty FROM  `productandproperties`  INNER JOIN  `products` ON productandproperties.Product = products.ProductId INNER JOIN  `productproperties` ON productandproperties.ProductProperty = productproperties.ProductPropertyId Where productandproperties.Product = " . $pId3 . " Order By  productproperties.Name ASC";
        $db3 = new DataAccess();
        $results3 = $db3->executeSelect($SQL3);
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
