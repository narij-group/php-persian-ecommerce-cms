<?php

require_once 'DataAccess.inc';

class LinkboxTitle {

    public $LinkboxTitleId;
    public $Name;

    public function __construct() {
        $this->LinkboxTitleId = 0;
        $this->Name = "";
    }

    public function Insert() {
        $SQL = "Insert Into linkboxtitles(Name) Values ('" . $this->Name . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update linkboxtitles Set `Name` = '" . $this->Name . "' Where LinkboxTitleId=" . $this->LinkboxTitleId . "";                
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From linkboxtitles Where LinkboxTitleId = " . $this->LinkboxTitleId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select * from linkboxtitles";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $linkboxtitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $linkboxtitle = new LinkboxTitle();
            $linkboxtitle->LinkboxTitleId = $row['LinkboxTitleId'];
            $linkboxtitle->Name = $row['Name'];
            $linkboxtitles[$i] = $linkboxtitle;
            $i++;
        }
        return $linkboxtitles;
    }        
    public function FindOneLinkboxTitle() {
        $SQL = "Select * from linkboxtitles where LinkboxTitleId = " . $this->LinkboxTitleId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $linkboxtitle = new LinkboxTitle();
            $linkboxtitle->LinkboxTitleId = $row['LinkboxTitleId'];
            $linkboxtitle->Name = $row['Name'];
            return $linkboxtitle;
        }
    }

}
