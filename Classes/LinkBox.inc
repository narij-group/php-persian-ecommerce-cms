<?php

require_once 'DataAccess.inc';
require_once 'User.inc';
require_once 'LinkboxTitle.inc';

class LinkBox {

    public $LinkBoxId;
    public $Name;
    public $Link;
    public $LinkboxTitle;
    public $Content;
    public $User;
    public $HaveForm;


    public function __construct() {
        $this->LinkBoxId = 0;
        $this->HaveForm = 0;
        $this->Name = "";
        $this->Link = "";
        $this->LinkboxTitle = new LinkboxTitle();
        $this->Content = "";
        $this->User = new User();
    }

    public function Insert() {

        $SQL = "Insert Into linkboxes(`Name`,Link,LinkboxTitle,Content,User,HaveForm) Values ('" . $this->Name . "','" . $this->Link . "' , " . $this->LinkboxTitle . ", '" . $this->Content . "' , " . $this->User . ", " . $this->HaveForm . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update linkboxes Set `Name`='" . $this->Name . "',Link='" . $this->Link . "' , LinkboxTitle=" . $this->LinkboxTitle . " Where LinkBoxId=" . $this->LinkBoxId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }
    
        public function UpdateContent() {
        $SQL = "Update linkboxes Set Content='" . $this->Content . "',HaveForm=" . $this->HaveForm. " Where LinkBoxId=" . $this->LinkBoxId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }


    public function Delete() {
        $SQL = "Delete From linkboxes Where LinkBoxId= " . $this->LinkBoxId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneLinkBox() {
        $SQL = "Select linkboxes.LinkBoxId , linkboxes.Name as LinkBoxName , linkboxes.Link, linkboxes.Content, linkboxes.HaveForm, linkboxes.LinkboxTitle , linkboxtitles.Name as LinkboxTitleName , linkboxtitles.LinkboxTitleId , users.UserId , users.Name, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `linkboxes` Inner Join users On linkboxes.User = users.UserId Inner Join linkboxtitles on linkboxes.LinkboxTitle = linkboxtitles.LinkboxTitleId Where LinkBoxId=" . $this->LinkBoxId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $linkbox = new LinkBox();
            $linkbox->LinkBoxId = $row['LinkBoxId'];
            $linkbox->HaveForm= $row['HaveForm'];
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

    public function Fill() {
        $SQL = "Select linkboxes.LinkBoxId , linkboxes.Name as LinkBoxName , linkboxes.Link, linkboxes.Content, linkboxes.HaveForm , linkboxes.LinkboxTitle , linkboxtitles.Name as LinkboxTitleName , linkboxtitles.LinkboxTitleId , users.UserId , users.Name, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `linkboxes` Inner Join users On linkboxes.User = users.UserId Inner Join linkboxtitles on linkboxes.LinkboxTitle = linkboxtitles.LinkboxTitleId Order by LinkBoxId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $linkboxes = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $linkbox = new LinkBox();
            $linkbox->LinkBoxId = $row['LinkBoxId'];
            $linkbox->Name = $row['LinkBoxName'];
            $linkbox->HaveForm= $row['HaveForm'];
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
    
    public function GetOneTitleLinks($id) {
        $SQL = "Select linkboxes.LinkBoxId , linkboxes.Name as LinkBoxName , linkboxes.Link, linkboxes.Content, linkboxes.HaveForm , linkboxes.LinkboxTitle , linkboxtitles.Name as LinkboxTitleName , linkboxtitles.LinkboxTitleId , users.UserId , users.Name, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `linkboxes` Inner Join users On linkboxes.User = users.UserId Inner Join linkboxtitles on linkboxes.LinkboxTitle = linkboxtitles.LinkboxTitleId where linkboxes.LinkboxTitle = $id";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $linkboxes = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $linkbox = new LinkBox();
            $linkbox->LinkBoxId = $row['LinkBoxId'];
            $linkbox->Name = $row['LinkBoxName'];
            $linkbox->Link = $row['Link'];
            $linkbox->HaveForm= $row['HaveForm'];
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
    
    public function WritableLinks() {
        $SQL = "Select linkboxes.LinkBoxId , linkboxes.Name as LinkBoxName , linkboxes.Link, linkboxes.Content, linkboxes.HaveForm , linkboxes.LinkboxTitle , linkboxtitles.Name as LinkboxTitleName , linkboxtitles.LinkboxTitleId , users.UserId , users.Name, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `linkboxes` Inner Join users On linkboxes.User = users.UserId Inner Join linkboxtitles on linkboxes.LinkboxTitle = linkboxtitles.LinkboxTitleId where linkboxes.Link = ''";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $linkboxes = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $linkbox = new LinkBox();
            $linkbox->LinkBoxId = $row['LinkBoxId'];
            $linkbox->Name = $row['LinkBoxName'];
            $linkbox->HaveForm= $row['HaveForm'];
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
