<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/LinkboxTitle.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class LinkboxTitleDataSource
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

    public function Insert(LinkboxTitle $linkboxTitle)
    {
        $SQL = "Insert Into linkboxtitles(Name) Values ('" . $linkboxTitle->Name . "')";
        $this->da->exec($SQL);
    }

    public function Update(LinkboxTitle $linkboxTitle)
    {
        $SQL = "Update linkboxtitles Set `Name` = '" . $linkboxTitle->Name . "' Where LinkboxTitleId=" . $linkboxTitle->LinkboxTitleId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From linkboxtitles Where LinkboxTitleId = " . $id;
        $this->da->exec($SQL);


    }

    public function K_Delete($id)
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'LinkBoxDataSource.inc';
        $SQL = "Delete From linkboxtitles Where LinkboxTitleId = " . $id;
        $this->da->exec($SQL);

        $lds = new LinkBoxDataSource();
        $lds->open();
        $lds->DeleteBasedOnLinkBoxTitle($_GET['id']);
        $lds->close();

    }

    public function Fill()
    {
        $SQL = "Select * from linkboxtitles";
        $results = $this->da->execSelect($SQL);
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

    public function FindOneLinkboxTitleBasedOnId($id)
    {
        $SQL = "Select * from linkboxtitles where LinkboxTitleId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $linkboxtitle = new LinkboxTitle();
            $linkboxtitle->LinkboxTitleId = $row['LinkboxTitleId'];
            $linkboxtitle->Name = $row['Name'];
            return $linkboxtitle;
        }
    }

}
