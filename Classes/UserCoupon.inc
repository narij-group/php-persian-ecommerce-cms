<?php

require_once 'DataAccess.inc';
require_once 'Customer.inc';

class UserCoupon
{

    public $UserCouponId;
    public $Value;
    public $Customer;
    public $Date;
    public $Time;

    public function __construct()
    {
        $this->UserCouponId = 0;
        $this->Value = 0;
        $this->Time = 0;
        $this->Customer = new Customer();
        $this->Date = date("Y/m/d");
    }

    public function Insert()
    {
        $SQL = "Insert Into usercoupons(Value,Customer,Date,Time) Values (" . $this->Value . " , " . $this->Customer . ", '" . $this->Date . "' , " . $this->Time . " )";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update usercoupons Set Value = " . $this->Value . "  , Customer = " . $this->Customer . " , Date = '" . $this->Date . "', Time = " . $this->Time . " Where UserCouponId=" . $this->UserCouponId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function UpdateValue()
    {
        $SQL = "Update usercoupons Set Value = " . $this->Value . "   Where UserCouponId=" . $this->UserCouponId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From usercoupons Where UserCouponId= " . $this->UserCouponId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneUserCoupon()
    {
        $SQL = "Select usercoupons.UserCouponId , usercoupons.Time , usercoupons.Date, usercoupons.Value , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From usercoupons Inner Join customers On usercoupons.Customer = customers.CustomerId Where UserCouponId=" . $this->UserCouponId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $usercoupon = new UserCoupon();
            $usercoupon->UserCouponId = $row['UserCouponId'];
            $usercoupon->Value = $row['Value'];
            $usercoupon->Date = $row['Date'];
            $usercoupon->Time = $row['Time'];
            $usercoupon->Customer->CustomerId = $row['CustomerId'];
            $usercoupon->Customer->Name = $row['CustomerName'];
            $usercoupon->Customer->Family = $row['Family'];
            $usercoupon->Customer->Email = $row['Email'];
            $usercoupon->Customer->Password = $row['Password'];
            $usercoupon->Customer->City = $row['City'];
            $usercoupon->Customer->NationalityCode = $row['NationalityCode'];
            $usercoupon->Customer->Address = $row['Address'];
            $usercoupon->Customer->Estate = $row['Estate'];
            return $usercoupon;
        }
    }

    public function Fill()
    {
        $SQL = "Select usercoupons.UserCouponId , usercoupons.Date, usercoupons.Time , usercoupons.Value , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From usercoupons Inner Join customers On usercoupons.Customer = customers.CustomerId Order by UserCouponId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $usercoupons = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $usercoupon = new UserCoupon();
            $usercoupon->UserCouponId = $row['UserCouponId'];
            $usercoupon->Value = $row['Value'];
            $usercoupon->Date = $row['Date'];
            $usercoupon->Time = $row['Time'];
            $usercoupon->Customer->CustomerId = $row['CustomerId'];
            $usercoupon->Customer->Name = $row['CustomerName'];
            $usercoupon->Customer->Family = $row['Family'];
            $usercoupon->Customer->Email = $row['Email'];
            $usercoupon->Customer->Password = $row['Password'];
            $usercoupon->Customer->City = $row['City'];
            $usercoupon->Customer->NationalityCode = $row['NationalityCode'];
            $usercoupon->Customer->Address = $row['Address'];
            $usercoupon->Customer->Estate = $row['Estate'];
            $usercoupons[$i] = $usercoupon;
            $i++;
        }
        return $usercoupons;
    }

    public function FindOneUserCoupons($customer)
    {
        $SQL = "Select usercoupons.UserCouponId , usercoupons.Time , usercoupons.Date, usercoupons.Value , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From usercoupons Inner Join customers On usercoupons.Customer = customers.CustomerId Where Customer=" . $customer;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $usercoupons = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $usercoupon = new UserCoupon();
            $usercoupon->UserCouponId = $row['UserCouponId'];
            $usercoupon->Value = $row['Value'];
            $usercoupon->Date = $row['Date'];
            $usercoupon->Time = $row['Time'];
            $usercoupon->Customer->CustomerId = $row['CustomerId'];
            $usercoupon->Customer->Name = $row['CustomerName'];
            $usercoupon->Customer->Family = $row['Family'];
            $usercoupon->Customer->Email = $row['Email'];
            $usercoupon->Customer->Password = $row['Password'];
            $usercoupon->Customer->City = $row['City'];
            $usercoupon->Customer->NationalityCode = $row['NationalityCode'];
            $usercoupon->Customer->Address = $row['Address'];
            $usercoupon->Customer->Estate = $row['Estate'];
            $usercoupons[$i] = $usercoupon;
            $i++;
        }
        return $usercoupons;
    }

    public function SomeoneCouponsSome($customer)
    {
        $SQL = "Select * From usercoupons Where usercoupons.Customer=" . $customer . " ORDER BY UserCouponId ASC";
        //echo $SQL;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $usercoupon = new UserCoupon();
            $usercoupon->Value = $row['Value'];
            $i += $usercoupon->Value;
        }

        return $i;
    }

    public function SomeoneCouponsSome2($customer)
    {
        $SQL = "Select * From usercoupons Where usercoupons.Customer=" . $customer . " ORDER BY  UserCouponId DESC LIMIT 1 ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $usercoupon = new UserCoupon();
            $usercoupon->UserCouponId = $row['UserCouponId'];
        }
        return $usercoupon;
    }

}
