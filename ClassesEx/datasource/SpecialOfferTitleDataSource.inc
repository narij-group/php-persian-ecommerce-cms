<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/SpecialOfferTitle.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class SpecialOfferTitleDataSource
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

    public function Insert(SpecialOfferTitle $specialOfferTitle)
    {

        $SQL = "Insert Into specialoffertitles(Title,Activated) Values ('" . $specialOfferTitle->Title . "', " . $specialOfferTitle->Activated . ")";
        $this->da->exec($SQL);
    }

    public function Update(SpecialOfferTitle $specialOfferTitle)
    {
        $SQL = "Update specialoffertitles Set Title='" . $specialOfferTitle->Title . "', Activated=" . $specialOfferTitle->Activated . " Where SpecialOfferTitleId=" . $specialOfferTitle->SpecialOfferTitleId . "";
        $this->da->exec($SQL);
    }


    public function Delete($id)
    {
        $SQL = "Delete From specialoffertitles Where SpecialOfferTitleId= " . $id;
        $this->da->exec($SQL);
    }

    public function SwitchStatus(SpecialOfferTitle $specialOfferTitle)
    {
        $SQL = "Update specialoffertitles Set Activated=" . $specialOfferTitle->Activated . " Where SpecialOfferTitleId=" . $specialOfferTitle->SpecialOfferTitleId . "";
        $this->da->exec($SQL);
    }

    public function FindOneSpecialOfferTitleBasedOnId($id)
    {
        $SQL = "Select * From specialoffertitles Where SpecialOfferTitleId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $specialOfferTitle = new SpecialOfferTitle();
            $specialOfferTitle->SpecialOfferTitleId = $row['SpecialOfferTitleId'];
            $specialOfferTitle->Title = $row['Title'];
            $specialOfferTitle->Activated = $row['Activated'];
            return $specialOfferTitle;
        }
    }

    public function Fill()
    {
        $SQL = "Select * From specialoffertitles";
        $results = $this->da->execSelect($SQL);
        $specialOfferTitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $specialOfferTitle = new SpecialOfferTitle();
            $specialOfferTitle->SpecialOfferTitleId = $row['SpecialOfferTitleId'];
            $specialOfferTitle->Title = $row['Title'];
            $specialOfferTitle->Activated = $row['Activated'];
            $specialOfferTitles[$i] = $specialOfferTitle;
            $i++;
        }
        return $specialOfferTitles;
    }

    public function FillByActive()
    {
        $SQL = "Select * From specialoffertitles Where Activated= 1";
        $results = $this->da->execSelect($SQL);
        $specialOfferTitles = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $specialOfferTitle = new SpecialOfferTitle();
            $specialOfferTitle->SpecialOfferTitleId = $row['SpecialOfferTitleId'];
            $specialOfferTitle->Title = $row['Title'];
            $specialOfferTitle->Activated = $row['Activated'];
            $specialOfferTitles[$i] = $specialOfferTitle;
            $i++;
        }
        return $specialOfferTitles;
    }

    //-----------------------------------------------------------------------------------------------------------------

    public function InsertSpecialOffer($productId, $specialOfferTitleId)
    {
        $SQL = "Insert Into specialoffers(Product,SpecialOfferTitle) Values ('" . $productId . "','" . $specialOfferTitleId . "')";
        $this->da->exec($SQL);
    }

    public function DeleteSpecialOfferBaseToProductAndSpecialOfferTitle($productId, $specialOfferTitleIid)
    {
        $SQL = "Delete From specialoffers Where Product= " . $productId . " AND SpecialOfferTitle= " . $specialOfferTitleIid;
        $this->da->exec($SQL);
    }

    public function DeleteSpecialOfferBaseToSpecialOfferTitle( $specialOfferTitleIid)
    {
        $SQL = "Delete From specialoffers Where SpecialOfferTitle= " . $specialOfferTitleIid;
        $this->da->exec($SQL);
    }

    public function ExistSpecialOffer($productId, $specialOfferTitleId)
    {
        $SQL = "Select * From specialoffers  Where Product = " . $productId . " AND SpecialOfferTitle= " . $specialOfferTitleId;
        $results = $this->da->execSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function IsSpecialOfferByProduct($productId)
    {
        $SQL = "Select * From specialoffers  Where Product = " . $productId ;
        $results = $this->da->execSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
