<?php

require_once 'DataAccess.inc';
require_once 'SupperGroup.inc';

class ProductProperty {

    public $ProductPropertyId;
    public $Name;
    public $Value;
    public $Group;
    public $Search;

    public function __construct() {
        $this->ProductPropertyId = 0;
        $this->Group = new SupperGroup();
        $this->Name = "";
        $this->Value = "";
        $this->Search = 0;
    }

    public function Insert() {
        $SQL = "Insert Into productproperties(`Name`,Value,`Group`) Values ('" . $this->Name . "','" . $this->Value . "'," . $this->Group . ")";                
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update productproperties Set `Name`='" . $this->Name . "',Value='" . $this->Value . "' Where ProductPropertyId=" . $this->ProductPropertyId."";
        $db = new DataAccess();
        $db->execute($SQL);
    }
    public function UpdateSearch($id,$search_value) {
        $SQL = "Update productproperties Set Search=" . $search_value . " Where ProductPropertyId=" . $id;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From productproperties Where ProductPropertyId= " . $this->ProductPropertyId;
        echo $SQL;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneProductProperty() {
        $SQL = "Select productproperties.ProductPropertyId,productproperties.Name,productproperties.Search,productproperties.Value , suppergroups.SupperGroupId,suppergroups.Name as GName,suppergroups.LatinName From productproperties Inner Join suppergroups on productproperties.Group = SupperGroupId Where ProductPropertyId=" . $this->ProductPropertyId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function Fill() {
        $SQL = "Select productproperties.ProductPropertyId,productproperties.Name,productproperties.Search,productproperties.Value , suppergroups.SupperGroupId,suppergroups.Name as GName,suppergroups.LatinName From productproperties Inner Join suppergroups on productproperties.Group = SupperGroupId ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
    
    public function FindOneSupperGroupRecords($suppergroup) {
        $SQL = "Select productproperties.ProductPropertyId,productproperties.Name,productproperties.Search,productproperties.Value , suppergroups.SupperGroupId,suppergroups.Name as GName,suppergroups.LatinName From productproperties Inner Join suppergroups on productproperties.Group = SupperGroupId Where productproperties.Group = $suppergroup ORDER BY productproperties.Name ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
    public function CFindOneSupperGroupRecords($suppergroup) {
        $SQL = "Select productproperties.ProductPropertyId,productproperties.Name,productproperties.Search,productproperties.Value , suppergroups.SupperGroupId,suppergroups.Name as GName,suppergroups.LatinName From productproperties Inner Join suppergroups on productproperties.Group = SupperGroupId Where productproperties.Group = $suppergroup AND productproperties.Search = 1 ORDER BY productproperties.Name ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
