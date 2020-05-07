<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/LinkBox.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class LinkBoxDataSource
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

    public function Insert(LinkBox $linkBox)
    {

        $SQL = "Insert Into linkboxes(`Name`,Link,LinkboxTitle,Content,User,HaveForm) Values ('" . $linkBox->Name . "','" . $linkBox->Link . "' , " . $linkBox->LinkboxTitle . ", '" . $linkBox->Content . "' , " . $linkBox->User . ", " . $linkBox->HaveForm . ")";
        $this->da->exec($SQL);
    }

    public function Update(LinkBox $linkBox)
    {
        $SQL = "Update linkboxes Set `Name`='" . $linkBox->Name . "',Link='" . $linkBox->Link . "' , LinkboxTitle=" . $linkBox->LinkboxTitle . " Where LinkBoxId=" . $linkBox->LinkBoxId . "";
        $this->da->exec($SQL);
    }

    public function UpdateContent(LinkBox $linkBox)
    {
        $SQL = "Update linkboxes Set Content='" . $linkBox->Content . "',HaveForm=" . $linkBox->HaveForm . " Where LinkBoxId=" . $linkBox->LinkBoxId . "";
        $this->da->exec($SQL);
    }


    public function Delete($id)
    {
        $SQL = "Delete From linkboxes Where LinkBoxId= " . $id;
//        echo $SQL;
        $this->da->exec($SQL);
    }

    public function DeleteBasedOnLinkBoxTitle($id)
    {
        $SQL = "Delete From linkboxes Where LinkboxTitle= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneLinkBoxBasedOnId($id)
    {
        $SQL = "Select linkboxes.LinkBoxId , linkboxes.Name as LinkBoxName , linkboxes.Link, linkboxes.Content, linkboxes.HaveForm, linkboxes.LinkboxTitle , linkboxtitles.Name as LinkboxTitleName , linkboxtitles.LinkboxTitleId , users.UserId , users.Name, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `linkboxes` Inner Join users On linkboxes.User = users.UserId Inner Join linkboxtitles on linkboxes.LinkboxTitle = linkboxtitles.LinkboxTitleId Where LinkBoxId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $linkbox = new LinkBox();
            $linkbox->LinkBoxId = $row['LinkBoxId'];
            $linkbox->HaveForm = $row['HaveForm'];
            $linkbox->Name = $row['LinkBoxName'];
            $linkbox->LinkboxTitle->Name = $row['LinkboxTitleName'];
            $linkbox->LinkboxTitle->LinkboxTitleId = $row['LinkboxTitleId'];
            $linkbox->Link = $row['Link'];
            $linkbox->Content = $row['Content'];
            $linkbox->User->UserId = $row['UserId'];
            $linkbox->User->Name = $row['Name'];
            $linkbox->User->Family = $row['Family'];
            $linkbox->User->Username = $row['Username'];
            return $linkbox;
        }
    }

    public function Fill()
    {
        $SQL = "Select linkboxes.LinkBoxId , linkboxes.Name as LinkBoxName , linkboxes.Link, linkboxes.Content, linkboxes.HaveForm , linkboxes.LinkboxTitle , linkboxtitles.Name as LinkboxTitleName , linkboxtitles.LinkboxTitleId , users.UserId , users.Name, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `linkboxes` Inner Join users On linkboxes.User = users.UserId Inner Join linkboxtitles on linkboxes.LinkboxTitle = linkboxtitles.LinkboxTitleId Order by LinkBoxId DESC";
        $results = $this->da->execSelect($SQL);
        $linkboxes = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $linkbox = new LinkBox();
            $linkbox->LinkBoxId = $row['LinkBoxId'];
            $linkbox->Name = $row['LinkBoxName'];
            $linkbox->HaveForm = $row['HaveForm'];
            $linkbox->Link = $row['Link'];
            $linkbox->Content = $row['Content'];
            $linkbox->LinkboxTitle->Name = $row['LinkboxTitleName'];
            $linkbox->LinkboxTitle->LinkboxTitleId = $row['LinkboxTitleId'];
            $linkbox->User->UserId = $row['UserId'];
            $linkbox->User->Name = $row['Name'];
            $linkbox->User->Family = $row['Family'];
            $linkbox->User->Username = $row['Username'];
            $linkboxes[$i] = $linkbox;
            $i++;
        }
        return $linkboxes;
    }

    public function GetOneTitleLinks($id)
    {
        $SQL = "Select linkboxes.LinkBoxId , linkboxes.Name as LinkBoxName , linkboxes.Link, linkboxes.Content, linkboxes.HaveForm , linkboxes.LinkboxTitle , linkboxtitles.Name as LinkboxTitleName , linkboxtitles.LinkboxTitleId , users.UserId , users.Name, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `linkboxes` Inner Join users On linkboxes.User = users.UserId Inner Join linkboxtitles on linkboxes.LinkboxTitle = linkboxtitles.LinkboxTitleId where linkboxes.LinkboxTitle = $id";
        $results = $this->da->execSelect($SQL);
        $linkboxes = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $linkbox = new LinkBox();
            $linkbox->LinkBoxId = $row['LinkBoxId'];
            $linkbox->Name = $row['LinkBoxName'];
            $linkbox->Link = $row['Link'];
            $linkbox->HaveForm = $row['HaveForm'];
            $linkbox->Content = $row['Content'];
            $linkbox->LinkboxTitle->Name = $row['LinkboxTitleName'];
            $linkbox->LinkboxTitle->LinkboxTitleId = $row['LinkboxTitleId'];
            $linkbox->User->UserId = $row['UserId'];
            $linkbox->User->Name = $row['Name'];
            $linkbox->User->Family = $row['Family'];
            $linkbox->User->Username = $row['Username'];
            $linkboxes[$i] = $linkbox;
            $i++;
        }
        return $linkboxes;
    }

    public function WritableLinks()
    {
        $SQL = "Select linkboxes.LinkBoxId , linkboxes.Name as LinkBoxName , linkboxes.Link, linkboxes.Content, linkboxes.HaveForm , linkboxes.LinkboxTitle , linkboxtitles.Name as LinkboxTitleName , linkboxtitles.LinkboxTitleId , users.UserId , users.Name, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `linkboxes` Inner Join users On linkboxes.User = users.UserId Inner Join linkboxtitles on linkboxes.LinkboxTitle = linkboxtitles.LinkboxTitleId where linkboxes.Link = ''";
        $results = $this->da->execSelect($SQL);
        $linkboxes = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $linkbox = new LinkBox();
            $linkbox->LinkBoxId = $row['LinkBoxId'];
            $linkbox->Name = $row['LinkBoxName'];
            $linkbox->HaveForm = $row['HaveForm'];
            $linkbox->Link = $row['Link'];
            $linkbox->Content = $row['Content'];
            $linkbox->LinkboxTitle->Name = $row['LinkboxTitleName'];
            $linkbox->LinkboxTitle->LinkboxTitleId = $row['LinkboxTitleId'];
            $linkbox->User->UserId = $row['UserId'];
            $linkbox->User->Name = $row['Name'];
            $linkbox->User->Family = $row['Family'];
            $linkbox->User->Username = $row['Username'];
            $linkboxes[$i] = $linkbox;
            $i++;
        }
        return $linkboxes;
    }


}
