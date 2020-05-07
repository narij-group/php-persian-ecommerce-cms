<?php

require_once 'DataAccess.inc';
require_once 'User.inc';

class Category {

    public $CategoryId;
    public $Name;
    public $Description;
    public $Parent;
    public $User;

    public function __construct() {
        $this->CategoryId = 0;
        $this->Name = "";
        $this->Description = "";
        $this->Parent = 0;
        $this->User = new User;
    }

    public function Insert() {

        $SQL = "Insert Into categories(`Name`,Description,Parent,User) Values ('" . $this->Name . "','" . $this->Description . "' , " . $this->Parent . " , ".$this->User.")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update() {
        $SQL = "Update categories Set `Name`='" . $this->Name . "',Description='" . $this->Description . "' , Parent=" . $this->Parent . " Where CategoryId=" . $this->CategoryId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From categories Where CategoryId= " . $this->CategoryId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneCategory() {
        $SQL = "Select categories.CategoryId , categories.Name as CName , categories.Description , categories.Parent , users.UserId , users.Name as UName, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `categories` Inner Join users On categories.User = users.UserId Where CategoryId=" . $this->CategoryId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $category = new Category();
            $category->CategoryId = $row['CategoryId'];
            $category->Name = $row['CName'];
            $category->Description = $row['Description'];
            $category->Parent = $row['Parent'];
            $category->User->UserId = $row['UserId'];
            $category->User->Name = $row['UName'];
            $category->User->Family = $row['Family'];
            $category->User->Username = $row['Username'];
            return $category;
        }
    }

    public function Fill() {
        $SQL = "Select categories.CategoryId , categories.Name as CName , categories.Description , categories.Parent , users.UserId , users.Name as UName, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `categories` Inner Join users On categories.User = users.UserId " ;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $categories = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $category = new Category();
            $category->CategoryId = $row['CategoryId'];
            $category->Name = $row['CName'];
            $category->Description = $row['Description'];
            $category->Parent = $row['Parent'];
            $category->User->UserId = $row['UserId'];
            $category->User->Name = $row['UName'];
            $category->User->Family = $row['Family'];
            $category->User->Username = $row['Username'];
            $categories[$i] = $category;
            $i++;
        }
        return $categories;
    }

}
