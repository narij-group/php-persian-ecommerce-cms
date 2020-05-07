<?php

require_once 'DataAccess.inc';

class Slide {

    public $SlideId;
    public $Image;
    public $Name;
    public $Link;

    public function __construct() {
        $this->SlideId = 0;
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->Name = "";
        $this->Link = "";
    }

    public function Insert() {

        $SQL = "Insert Into slides(`Image`,Link,`Name`) Values ('" . $this->Image . "','" . $this->Link . "','" . $this->Name . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update slides Set `Image`='" . $this->Image . "',`Link`='" . $this->Link . "',`Name`='" . $this->Name . "' Where SlideId=" . $this->SlideId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From slides Where SlideId = " . $this->SlideId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select * from slides ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $slides = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $slide = new Slide();
            $slide->SlideId = $row['SlideId'];
            $slide->Image = $row['Image'];
            $slide->Name = $row['Name'];
            $slide->Link = $row['Link'];
            $slides[$i] = $slide;
            $i++;
        }
        return $slides;
    }

    public function FindOneSlide() {
        $SQL = "Select * from slides where SlideId = " . $this->SlideId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $slide = new Slide();
            $slide->SlideId = $row['SlideId'];
            $slide->Image = $row['Image'];
            $slide->Name = $row['Name'];
            $slide->Link = $row['Link'];
            return $slide;
        }
    }

}
