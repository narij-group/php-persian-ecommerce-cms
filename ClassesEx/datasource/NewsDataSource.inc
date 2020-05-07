<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/News.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class NewsDataSource
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

    public function Insert(News $news)
    {

        $SQL = "Insert Into news(Title,Content,Image,Keywords,User,MetaDescription,Status,date,Summary) Values ('" . $news->Title . "' , '" . $news->Content . "', '" . $news->Image . "', '" . $news->Keywords . "', " . $news->User . ", '" . $news->MetaDescription . "', " . $news->Status . ", '" . $news->Date . "', '" . $news->Summary . "')";
        $this->da->exec($SQL);
    }

    public function Update(News $news)
    {
        $SQL = "Update news Set Title='" . $news->Title . "' , Content='" . $news->Content . "', Keywords='" . $news->Keywords . "', Image='" . $news->Image . "', User=" . $news->User . ", MetaDescription='" . $news->MetaDescription . "', Summary='" . $news->Summary . "', Status=" . $news->Status . " Where NewsId=" . $news->NewsId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From `news` Where NewsId= " . $id;
        $this->da->exec($SQL);
    }

    public function FindOneNewsBasedOnId($id)
    {
        $SQL = "Select * From `news` INNER JOIN users on UserId= `User` Where NewsId=" . $id;
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['NewsId'];
        }
    }

    public function RandomFill()
    {
        $SQL = "Select NewsId,Title,Image,Date From `news` INNER JOIN users on UserId = User WHERE Status = 1 ORDER BY RAND() LIMIT 10";
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
