<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Stat.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class StatDataSource
{

    public $da;

    function __construct()
    {
        $this->da = new DataAccessEx();
    }

    public function Insert(Stat $stat)
    {
        $SQL = "Insert Into stats(`Product`,UserIP,Page,Visit,Date) Values (" . $stat->Product . ",'" . $stat->UserIP . "' , '" . $stat->Page . "','" . $stat->Visit . "', '" . $stat->Date . "')";
        $this->da->exec($SQL);
    }

    public function Update(Stat $stat)
    {
        $SQL = "Update stats Set Visit=" . $stat->Visit . ",Date=Date Where StatId=" . $stat->StatId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From stats Where StatId= " . $id;
        $this->da->exec($SQL);
    }

    public function DeleteStatsRelatedToProduct($productId)
    {
        $SQL = "DELETE From stats Where Product=" . $productId;
        $this->da->exec($SQL);
    }

    public function FindOneStatBasedOnId($id)
    {
        $SQL = "Select * From stats Where StatId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $stat = new Stat();
            $stat->StatId = $row['StatId'];
            $stat->UserIP = $row['UserIP'];
            $stat->Page = $row['Page'];
            $stat->Date = $row['Date'];
            $stat->Visit = $row['Visit'];
            $stat->Product = $row['Product'];
            return $stat;
        }
    }

    public function GetStatsForOneProduct($productId)
    {
        $SQL = "Select * From stats Where Product=" . $productId . " ORDER BY StatId DESC";
        $results = $this->da->execSelect($SQL);
        $stats = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $stat = new Stat();
            $stat->StatId = $row['StatId'];
            $stat->UserIP = $row['UserIP'];
            $stat->Page = $row['Page'];
            $stat->Date = $row['Date'];
            $stat->Visit = $row['Visit'];
            $stat->Product = $row['Product'];
            $stats[$i] = $stat;
            $i++;
        }
        return $stats;
    }

    public function GetStatsCountForOneProduct($productId)
    {
        $SQL = "Select * From stats Where Product=" . $productId . " ORDER BY StatId DESC";
        $results = $this->da->execSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $i++;
        }
        return $i;
    }

    public function Fill()
    {
        $SQL = "Select * From stats ORDER BY StatId DESC";
        $results = $this->da->execSelect($SQL);
        $stats = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $stat = new Stat();
            $stat->StatId = $row['StatId'];
            $stat->UserIP = $row['UserIP'];
            $stat->Page = $row['Page'];
            $stat->Date = $row['Date'];
            $stat->Visit = $row['Visit'];
            $stat->Product = $row['Product'];
            $stats[$i] = $stat;
            $i++;
        }
        return $stats;
    }

    public function LimitedFill()
    {
        $SQL = "Select * From stats ORDER BY StatId DESC Limit 50";
        $results = $this->da->execSelect($SQL);
        $stats = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $stat = new Stat();
            $stat->StatId = $row['StatId'];
            $stat->UserIP = $row['UserIP'];
            $stat->Page = $row['Page'];
            $stat->Date = $row['Date'];
            $stat->Visit = $row['Visit'];
            $stat->Product = $row['Product'];
            $stats[$i] = $stat;
            $i++;
        }
        return $stats;
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function isVisited(Stat $stat)
    {
        $SQL = "Select * From stats Where UserIP = '" . $stat->UserIP . "' AND Date Like '%" . date("Y-m-d") . "%' AND Page = '" . $stat->Page . "'";
        $results = $this->da->execSelect($SQL);
        $stats = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $stat = new Stat();
            $stat->StatId = $row['StatId'];
            $stat->UserIP = $row['UserIP'];
            $stat->Page = $row['Page'];
            $stat->Date = $row['Date'];
            $stat->Visit = $row['Visit'];
            $stat->Product = $row['Product'];
            $stats[$i] = $stat;
            $i++;
        }
        return $stats;
    }

    public function getFirstDate()
    {
        $SQL = "Select `Date` From stats ";
        $results = $this->da->execSelect($SQL);
        $stats = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $stat = new Stat();
            $temp = explode(" ", $row['Date']);
            $j = 0;
            foreach ($temp as $t) {
                $dates[$j] = $t;
                $j++;
            }
            $stat->Date = $dates[0];
            $stats[$i] = $stat;
            $i++;
        }
        return $stats[0];
    }

    public function getDatesForProduct($productId)
    {
        $SQL = "Select `Date` From stats where Product = " . $productId;
        $results = $this->da->execSelect($SQL);
        $stats = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $temp = explode(" ", $row['Date']);
            $j = 0;
            foreach ($temp as $t) {
                $dates[$j] = $t;
                $j++;
            }
            $row['Date'] = $dates[0];
            $stats[$i] = $row['Date'];
            $i++;
        }
        return $stats;
    }

    public function findVisitsOfProduct($productId, $date)
    {
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats where Date Like '%" . $date . "%' AND Product = " . $productId;
        $results = $this->da->execSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function todayVisists()
    {
        $SQL = "Select * From stats where Date Like '%" . date('Y-m-d') . "%'";
        $results = $this->da->execSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            $visits = $visits + $row['Visit'];
        }
        return $visits;
    }

    public function UpdateFreshIP($expired_ip, $fresh_ip)
    {
        $SQL = "Select StatId , UserIP From stats where UserIP='" . $expired_ip . "'";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $stds = new StatDataSource();
            $stds->open();
            $stat = new Stat();
            $stat->StatId = $row['StatId'];
            $stat->UserIP = $fresh_ip;
            $stds->UpdateIP($stat);
            $stds->close();
        }
    }

    public function open()
    {
        $this->da->open();
    }

    public function UpdateIP(Stat $stat)
    {
        $SQL = "Update stats Set UserIP ='" . $stat->UserIP . "' , Date = Date Where StatId=" . $stat->StatId . "";
        $this->da->exec($SQL);
    }

    public function close()
    {
        $this->da->close();
    }

    public function todayVisistors()
    {
        $SQL = "Select * From stats where Date Like '%" . date('Y-m-d') . "%' ";
        $results = $this->da->execSelect($SQL);
        $i = 0;
        $v = array();
        while ($row = mysqli_fetch_array($results)) {
            $v[$i] = $row['UserIP'];
            $i++;
        }
        $visitors = array_unique($v);
        return count($visitors);
    }

    public function dailyVisists()
    {
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats";
        $results = $this->da->execSelect($SQL);
//        $stat = new Stat();
        $dates = array_unique($this->getDates());
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'] / count($dates);
        }
    }

    public function getDates()
    {
        $SQL = "Select `Date` From stats ORDER BY Date ASC";
        $results = $this->da->execSelect($SQL);
        $stats = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $temp = explode(" ", $row['Date']);
            $j = 0;
            foreach ($temp as $t) {
                $dates[$j] = $t;
                $j++;
            }
            $row['Date'] = $dates[0];
            $stats[$i] = $row['Date'];
            $i++;
        }
        return $stats;
    }

    public function dailyVisistors()
    {
        $visitors2 = 0;
        $j = 0;
        $stat = new Stat();
        $dates = array_unique($this->getDates());
        foreach ($dates as $d) {
            $visitors = $this->findVisitorsOfDate($d);
            $visitors2 += $visitors;
            $j++;
        }
        return $visitors2 / count($dates);

    }

    public function findVisitorsOfDate($date)
    {
        $SQL = "Select UserIP From stats where Date Like '%" . $date . "%'";
        $results = $this->da->execSelect($SQL);
        $visitors = 0;
        $visitors2 = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $visitors2[$i] = $row['UserIP'];
            $i++;
        }
        return count(array_unique($visitors2));
    }

    public function allVisits()
    {
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats";
        $results = $this->da->execSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function allVisitors()
    {
        $SQL = "Select UserIP From stats";
        $results = $this->da->execSelect($SQL);
        $visitors = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $visitors[$i] = $row['UserIP'];
            $i++;
        }
        return count(array_unique($visitors));
    }

    public function yesterdatVisists()
    {
        $date1 = explode("-", date('Y-m-d'));
        $date = $date1[0] . '-' . $date1[1] . '-' . sprintf("%02d", $date1[2] -= 1);
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats where Date Like '%" . $date . "%'";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function yesterdatVisistors()
    {
        $date1 = array();
        $date1 = explode("-", date('Y-m-d'));
        $date = $date1[0] . '-' . $date1[1] . '-' . sprintf("%02d", $date1[2] -= 1);
        $SQL = "Select * From stats where Date Like '%" . $date . "%'";
        $results = $this->da->execSelect($SQL);
        $i = 0;
        $visits = 0;
        $v = array();
        while ($row = mysqli_fetch_array($results)) {
            $v[$i] = $row['UserIP'];
            $i++;
        }
        return count(array_unique($v));
    }

    public function monthVisists()
    {
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats where Date Like '%" . date('Y-m-') . "%'";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function monthVisitors()
    {
        $SQL = "Select UserIP From stats where Date Like '%" . date('Y-m-') . "%'";
        $results = $this->da->execSelect($SQL);
        $j = 0;

        while ($row = mysqli_fetch_array($results)) {
            $v[$j] = $row['UserIP'];
            $j++;
        }
        return count(array_unique($v));
    }

    public function theMostVisitedDay()
    {
        $stat = new Stat();
        $dates = $this->getDates();
        $max = 0;
        foreach ($dates as $d) {
            $visits = $this->findVisitsOfDate($d);
            if ($max < $visits) {
                $max = $visits;
            }
        }
        return $max;
    }

    public function findVisitsOfDate($date)
    {
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats where Date Like '%" . $date . "%'";
        $results = $this->da->execSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function theMostVisitorDay()
    {
        $stat = new Stat();
        $dates = $this->getDates();
        $max = 0;
        foreach ($dates as $d) {
            $visits = $this->findVisitorsOfDate($d);
            if ($max < $visits) {
                $max = $visits;
            }
        }
        return $max;
    }

}
