<?php

require_once 'DataAccess.inc';

class Stat
{

    public $StatId;
    public $UserIP;
    public $Page;
    public $Visit;
    public $Date;
    public $Product;

    public function __construct()
    {
        $this->StatId = 0;
        $this->UserIP = "";
        $this->Page = "";
        $this->Visit = 0;
        date_default_timezone_set("Asia/Tehran");
        $this->Date = date("Y-m-d H:i:s", time());
        $this->Product = 0;
    }


    public function Insert()
    {
        $SQL = "Insert Into stats(`Product`,UserIP,Page,Visit,Date) Values (" . $this->Product . ",'" . $this->UserIP . "' , '" . $this->Page . "','" . $this->Visit . "', '" . $this->Date . "')";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update stats Set Visit=" . $this->Visit . ",Date=Date Where StatId=" . $this->StatId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function UpdateIP()
    {
        $SQL = "Update stats Set UserIP ='" . $this->UserIP . "' , Date = Date Where StatId=" . $this->StatId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From stats Where StatId= " . $this->StatId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneStat()
    {
        $SQL = "Select * From stats Where StatId=" . $this->StatId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function Fill()
    {
        $SQL = "Select * From stats ORDER BY StatId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function isVisited()
    {
        $stat = new Stat();
        $SQL = "Select * From stats Where UserIP = '" . $this->UserIP . "' AND Date Like '%" . date("Y-m-d") . "%' AND Page = '" . $this->Page . "'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function getDates()
    {
        $SQL = "Select `Date` From stats ORDER BY Date ASC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function getDatesForProduct()
    {
        $SQL = "Select `Date` From stats where Product = " . $this->Product;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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

    public function findVisitsOfDate($date)
    {
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats where Date Like '%" . $date . "%'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function findVisitsOfProduct($date)
    {
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats where Date Like '%" . $date . "%' AND Product = " . $this->Product;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function findVisitorsOfDate($date)
    {
        $SQL = "Select UserIP From stats where Date Like '%" . $date . "%'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $visitors = 0;
        $visitors2 = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $visitors2[$i] = $row['UserIP'];
            $i++;
        }
        return count(array_unique($visitors2));
    }

    public function todayVisists()
    {
        $SQL = "Select * From stats where Date Like '%" . date('Y-m-d') . "%'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            $visits = $visits + $row['Visit'];
        }
        return $visits;
    }

    public function UpdateFreshIP($expired_ip, $fresh_ip)
    {
        $SQL = "Select StatId , UserIP From stats where UserIP='" . $expired_ip . "'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            $stat = new Stat();
            $stat->StatId = $row['StatId'];
            $stat->UserIP = $fresh_ip;
            $stat->UpdateIP();
        }
    }

    public function todayVisistors()
    {
        $SQL = "Select * From stats where Date Like '%" . date('Y-m-d') . "%' ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $stat = new Stat();
        $dates = array_unique($stat->getDates());
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'] / count($dates);
        }
    }

    public function dailyVisistors()
    {
        $visitors2 = 0;
        $j = 0;
        $stat = new Stat();
        $dates = array_unique($stat->getDates());
        foreach ($dates as $d) {
            $visitors = $stat->findVisitorsOfDate($d);
            $visitors2 += $visitors;
            $j++;
        }
        return $visitors2/count($dates);

    }

    public function allVisits()
    {
        $SQL = "Select IFNULL(Sum(Visit),0) as Visits From stats";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $visits = 0;
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function allVisitors()
    {
        $SQL = "Select UserIP From stats";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['Visits'];
        }
    }

    public function monthVisitors()
    {
        $SQL = "Select UserIP From stats where Date Like '%" . date('Y-m-') . "%'";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
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
        $dates = $stat->getDates();
        $max = 0;
        foreach ($dates as $d) {
            $visits = $stat->findVisitsOfDate($d);
            if ($max < $visits) {
                $max = $visits;
            }
        }
        return $max;
    }

    public function theMostVisitorDay()
    {
        $stat = new Stat();
        $dates = $stat->getDates();
        $max = 0;
        foreach ($dates as $d) {
            $visits = $stat->findVisitorsOfDate($d);
            if ($max < $visits) {
                $max = $visits;
            }
        }
        return $max;
    }

}
