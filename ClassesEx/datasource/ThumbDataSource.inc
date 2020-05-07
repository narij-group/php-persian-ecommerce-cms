<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Thumb.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ThumbDataSource {

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

    public function Insert(Thumb $thumb) {

        $SQL = "Insert Into thumbs(Name,`Image`,`Link`) Values ('".$thumb->Name."' , '" . $thumb->Image . "' , '" . $thumb->Link . "')";
        $this->da->exec($SQL);
    }

    public function Update(Thumb $thumb) {
        $SQL = "Update thumbs Set `Name`='" . $thumb->Name . "' , `Image`='" . $thumb->Image . "' , Link = '".$thumb->Link."' Where ThumbId=" . $thumb->ThumbId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id) {
        $SQL = "Delete From thumbs Where ThumbId = " . $id;
        $this->da->exec($SQL);
    }

    public function Fill() {
        $SQL = "Select * from thumbs ";
        $results = $this->da->execSelect($SQL);
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

    public function FindOneThumbBasedOnId($id) {
        $SQL = "Select * from thumbs where ThumbId = " . $id;
        $results = $this->da->execSelect($SQL);
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
