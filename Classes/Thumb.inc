<?php

require_once 'DataAccess.inc';

class Thumb {

    public $ThumbId;
    public $Name;
    public $Image;    
    public $Link;

    public function __construct() {
        $this->ThumbId = 0;
        $this->Name = "";
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Link = "";
    }

    public function Insert() {

        $SQL = "Insert Into thumbs(Name,`Image`,`Link`) Values ('".$this->Name."' , '" . $this->Image . "' , '" . $this->Link . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update thumbs Set `Name`='" . $this->Name . "' , `Image`='" . $this->Image . "' , Link = '".$this->Link."' Where ThumbId=" . $this->ThumbId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From thumbs Where ThumbId = " . $this->ThumbId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select * from thumbs ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $thumbs = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $thumb = new Thumb();
            $thumb->ThumbId = $row['ThumbId'];
            $thumb->Name = $row['Name'];
            $thumb->Image = $row['Image'];
            $thumb->Link = $row['Link'];
            $thumbs[$i] = $thumb;
            $i++;
        }
        return $thumbs;
    }

    public function FindOneThumb() {
        $SQL = "Select * from thumbs where ThumbId = " . $this->ThumbId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        while ($row = mysqli_fetch_array($results)) {
            $thumb = new Thumb();
            $thumb->ThumbId = $row['ThumbId'];
            $thumb->Name = $row['Name'];
            $thumb->Image = $row['Image'];
            $thumb->Link = $row['Link'];
            return $thumb;
        }                
    }

}
