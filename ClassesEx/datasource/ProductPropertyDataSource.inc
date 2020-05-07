<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/ProductProperty.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ProductPropertyDataSource
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

    public function Insert(ProductProperty $productProperty)
    {
        $SQL = "Insert Into productproperties(`Name`,Value,`Group`) Values ('" . $productProperty->Name . "','" . $productProperty->Value . "'," . $productProperty->Group . ")";
        echo $SQL;
        $this->da->exec($SQL);
    }

    public function Update(ProductProperty $productProperty)
    {
        $SQL = "Update productproperties Set `Name`='" . $productProperty->Name . "',Value='" . $productProperty->Value . "' Where ProductPropertyId=" . $productProperty->ProductPropertyId . "";
        $this->da->exec($SQL);
    }

    public function UpdateSearch($id, $search_value)
    {
        $SQL = "Update productproperties Set Search=" . $search_value . " Where ProductPropertyId=" . $id;
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From productproperties Where ProductPropertyId= " . $id;
//        echo $SQL;
        $this->da->exec($SQL);
    }

    public function FindOneProductPropertyBasedOnId($id)
    {
        $SQL = "Select productproperties.ProductPropertyId,productproperties.Name,productproperties.Search,productproperties.Value , suppergroups.SupperGroupId,suppergroups.Name as GName,suppergroups.LatinName From productproperties Inner Join suppergroups on productproperties.Group = SupperGroupId Where ProductPropertyId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $productpropery = new ProductProperty();
            $productpropery->ProductPropertyId = $row['ProductPropertyId'];
            $productpropery->Name = $row['Name'];
            $productpropery->Value = $row['Value'];
            $productpropery->Search = $row['Search'];

            $productpropery->Group->SupperGroupId = $row['SupperGroupId'];
            $productpropery->Group->Name = $row['GName'];
            $productpropery->Group->LatinName = $row['LatinName'];

            return $productpropery;
        }
    }

    public function Fill()
    {
        $SQL = "Select productproperties.ProductPropertyId,productproperties.Name,productproperties.Search,productproperties.Value , suppergroups.SupperGroupId,suppergroups.Name as GName,suppergroups.LatinName From productproperties Inner Join suppergroups on productproperties.Group = SupperGroupId ";
        $results = $this->da->execSelect($SQL);
        $productproperies = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productpropery = new ProductProperty();
            $productpropery->ProductPropertyId = $row['ProductPropertyId'];
            $productpropery->Name = $row['Name'];
            $productpropery->Value = $row['Value'];
            $productpropery->Search = $row['Search'];

            $productpropery->Group->SupperGroupId = $row['SupperGroupId'];
            $productpropery->Group->Name = $row['GName'];
            $productpropery->Group->LatinName = $row['LatinName'];

            $productproperies[$i] = $productpropery;
            $i++;
        }
        return $productproperies;
    }

    public function FindOneSupperGroupRecords($suppergroup)
    {
        $SQL = "Select productproperties.ProductPropertyId,productproperties.Name,productproperties.Search,productproperties.Value , suppergroups.SupperGroupId,suppergroups.Name as GName,suppergroups.LatinName From productproperties Inner Join suppergroups on productproperties.Group = SupperGroupId Where productproperties.Group = $suppergroup ORDER BY productproperties.Name ASC";
        $results = $this->da->execSelect($SQL);
        $productproperies = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productpropery = new ProductProperty();
            $productpropery->ProductPropertyId = $row['ProductPropertyId'];
            $productpropery->Name = $row['Name'];
            $productpropery->Value = $row['Value'];
            $productpropery->Search = $row['Search'];

            $productpropery->Group->SupperGroupId = $row['SupperGroupId'];
            $productpropery->Group->Name = $row['GName'];
            $productpropery->Group->LatinName = $row['LatinName'];

            $productproperies[$i] = $productpropery;
            $i++;
        }
        return $productproperies;
    }

    public function CFindOneSupperGroupRecords($suppergroup)
    {
        $SQL = "Select productproperties.ProductPropertyId,productproperties.Name,productproperties.Search,productproperties.Value , suppergroups.SupperGroupId,suppergroups.Name as GName,suppergroups.LatinName From productproperties Inner Join suppergroups on productproperties.Group = SupperGroupId Where productproperties.Group = $suppergroup AND productproperties.Search = 1 ORDER BY productproperties.Name ASC";
        $results = $this->da->execSelect($SQL);
        $productproperies = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $productpropery = new ProductProperty();
            $productpropery->ProductPropertyId = $row['ProductPropertyId'];
            $productpropery->Name = $row['Name'];
            $productpropery->Value = $row['Value'];
            $productpropery->Search = $row['Search'];

            $productpropery->Group->SupperGroupId = $row['SupperGroupId'];
            $productpropery->Group->Name = $row['GName'];
            $productpropery->Group->LatinName = $row['LatinName'];

            $productproperies[$i] = $productpropery;
            $i++;
        }
        return $productproperies;
    }

}
