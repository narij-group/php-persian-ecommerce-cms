<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Slide.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class SlideDataSource {

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

    public function Insert(Slide $slide) {

        $SQL = "Insert Into slides(`Image`,Link,`Name`) Values ('" . $slide->Image . "','" . $slide->Link . "','" . $slide->Name . "')";
        $this->da->exec($SQL);
    }

    public function Update(Slide $slide) {
        $SQL = "Update slides Set `Image`='" . $slide->Image . "',`Link`='" . $slide->Link . "',`Name`='" . $slide->Name . "' Where SlideId=" . $slide->SlideId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id) {
        $SQL = "Delete From slides Where SlideId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill() {
        $SQL = "Select * from slides ";
        $results = $this->da->execSelect($SQL);
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

    public function FindOneSlideBasedOnId($id) {
        $SQL = "Select * from slides where SlideId = " . $id;
        $results = $this->da->execSelect($SQL);
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
