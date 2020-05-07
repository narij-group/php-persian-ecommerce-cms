<?php

require_once 'DataAccess.inc';
require_once 'User.inc';

class News
{

    public $NewsId;
    public $Title;
    public $Content;
    public $Image;
    public $Keywords;
    public $User;
    public $MetaDescription;
    public $Status;
    public $Summary;

    public function __construct()
    {
        $this->Status = 0;
        $this->NewsId = 0;
        $this->Title = "";
        $this->Content = "";
        $this->User = new User();
        $this->Image = "";
        $this->Keywords = "";
        $this->MetaDescription = "";
        $this->Summary = "";
        $this->Date = date('Y/m/d');
    }

    public function Insert()
    {

        $SQL = "Insert Into news(Title,Content,Image,Keywords,User,MetaDescription,Status,date,Summary) Values ('" . $this->Title . "' , '" . $this->Content . "', '" . $this->Image . "', '" . $this->Keywords . "', " . $this->User . ", '" . $this->MetaDescription . "', " . $this->Status . ", '" . $this->Date . "', '" . $this->Summary . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update news Set Title='" . $this->Title . "' , Content='" . $this->Content . "', Keywords='" . $this->Keywords . "', Image='" . $this->Image . "', User=" . $this->User . ", MetaDescription='" . $this->MetaDescription . "', Summary='" . $this->Summary . "', Status=" . $this->Status . " Where NewsId=" . $this->NewsId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From `news` Where NewsId= " . $this->NewsId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneNews()
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId= `User` Where NewsId=" . $this->NewsId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $news = new News();
            $news->NewsId = $row['NewsId'];
            $news->Title = $row['Title'];
            $news->Content = $row['Content'];
            $news->Keywords = $row['Keywords'];
            $news->MetaDescription = $row['MetaDescription'];
            $news->Image = $row['Image'];
            $news->Status = $row['Status'];
            $news->Date = $row['Date'];
            $news->Summary = $row['Summary'];

            $news->User->UserId = $row['UserId'];
            $news->User->Name = $row['Name'];
            $news->User->Family = $row['Family'];
            return $news;
        }
    }

    public function mres($value)
    {
        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
        return str_replace($search, $replace, $value);
    }

    public function Fill()
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId = User ORDER BY NewsId DESC ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $news2 = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $news = new News();
            $news->NewsId = $row['NewsId'];
            $news->Title = $row['Title'];
            $news->Content = $row['Content'];
            $news->Keywords = $row['Keywords'];
            $news->MetaDescription = $row['MetaDescription'];
            $news->Image = $row['Image'];
            $news->Status = $row['Status'];
            $news->Date = $row['Date'];
            $news->Summary = $row['Summary'];

            $news->User->UserId = $row['UserId'];
            $news->User->Name = $row['Name'];
            $news->User->Family = $row['Family'];
            $news2[$i] = $news;
            $i++;
        }
        return $news2;
    }
    public function GetThisUserNews($user)
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId = `User` WHERE `User` = $user ORDER BY NewsId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $news2 = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $news = new News();
            $news->NewsId = $row['NewsId'];
            $news->Title = $row['Title'];
            $news->Image = $row['Image'];
            $news2[$i] = $news;
            $i++;
        }
        return $news2;
    }

    public function CFill()
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId = User WHERE Status = 1 ORDER BY NewsId DESC Limit 4";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $news2 = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $news = new News();
            $news->NewsId = $row['NewsId'];
            $news->Title = $row['Title'];
            $news->Content = $row['Content'];
            $news->Keywords = $row['Keywords'];
            $news->MetaDescription = $row['MetaDescription'];
            $news->Image = $row['Image'];
            $news->Status = $row['Status'];
            $news->Date = $row['Date'];
            $news->Summary = $row['Summary'];

            $news->User->UserId = $row['UserId'];
            $news->User->Name = $row['Name'];
            $news->User->Family = $row['Family'];
            $news2[$i] = $news;
            $i++;
        }
        return $news2;
    }

    public function Fill2()
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId = User WHERE Status = 1 ORDER BY NewsId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $news2 = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $news = new News();
            $news->NewsId = $row['NewsId'];
            $news->Title = $row['Title'];
            $news->Content = $row['Content'];
            $news->Keywords = $row['Keywords'];
            $news->MetaDescription = $row['MetaDescription'];
            $news->Image = $row['Image'];
            $news->Status = $row['Status'];
            $news->Date = $row['Date'];
            $news->Summary = $row['Summary'];

            $news->User->UserId = $row['UserId'];
            $news->User->Name = $row['Name'];
            $news->User->Family = $row['Family'];
            $news2[$i] = $news;
            $i++;
        }
        return $news2;
    }

    public function FirstId()
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId = User WHERE Status = 1 ORDER BY NewsId ASC Limit 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['NewsId'];
        }
    }

    public function LastId()
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId = User WHERE Status = 1 ORDER BY NewsId DESC Limit 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['NewsId'];
        }
    }

    public function RandomFill()
    {
        $SQL = "Select NewsId,Title,Image,Date From `news` INNER JOIN users on UserId = User WHERE Status = 1 ORDER BY RAND() LIMIT 10";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $news2 = array();
        $i = 0;
        $selectedIDS = array();
        while ($row = mysqli_fetch_array($results)) {
            $news = new News();
            $news->NewsId = $row['NewsId'];
            $news->Title = $row['Title'];
            $news->Image = $row['Image'];
            $news->Date = $row['Date'];

            $news2[$i] = $news;
            $i++;
        }
        return $news2;
    }

    public function Search($key)
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId = User WHERE Title Like '%" . $key . "%' OR Keywords Like '%" . $key . "%' OR MetaDescription Like '%" . $key . "%' OR Date Like '%" . $key . "%' OR (Name Like '%" . $key . "%' OR Family Like '%" . $key . "%' ) ORDER BY NewsId DESC ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $news2 = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $news = new News();
            $news->NewsId = $row['NewsId'];
            $news->Title = $row['Title'];
            $news->Content = $row['Content'];
            $news->Keywords = $row['Keywords'];
            $news->MetaDescription = $row['MetaDescription'];
            $news->Image = $row['Image'];
            $news->Status = $row['Status'];
            $news->Date = $row['Date'];
            $news->Summary = $row['Summary'];

            $news->User->UserId = $row['UserId'];
            $news->User->Name = $row['Name'];
            $news->User->Family = $row['Family'];
            $news2[$i] = $news;
            $i++;
        }
        return $news2;
    }

    public function Search2($key)
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId = User WHERE Title Like '%" . $key . "%' OR Keywords Like '%" . $key . "%' OR MetaDescription Like '%" . $key . "%' OR Date Like '%" . $key . "%' OR (Name Like '%" . $key . "%' OR Family Like '%" . $key . "%' ) AND Status = 1 ORDER BY NewsId DESC ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $news2 = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $news = new News();
            $news->NewsId = $row['NewsId'];
            $news->Title = $row['Title'];
            $news->Content = $row['Content'];
            $news->Keywords = $row['Keywords'];
            $news->MetaDescription = $row['MetaDescription'];
            $news->Image = $row['Image'];
            $news->Status = $row['Status'];
            $news->Date = $row['Date'];
            $news->Summary = $row['Summary'];

            $news->User->UserId = $row['UserId'];
            $news->User->Name = $row['Name'];
            $news->User->Family = $row['Family'];
            $news2[$i] = $news;
            $i++;
        }
        return $news2;
    }
}
