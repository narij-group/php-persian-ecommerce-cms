<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/UserCoupon.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class UserCouponDataSource
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

    public function Insert(UserCoupon $userCoupon)
    {
        $SQL = "Insert Into usercoupons(Value,Customer,Date,Time) Values (" . $userCoupon->Value . " , " . $userCoupon->Customer . ", '" . $userCoupon->Date . "' , " . $userCoupon->Time . " )";
//        echo $SQL;
        $this->da->exec($SQL);
    }

    public function Update(UserCoupon $userCoupon)
    {
        $SQL = "Update usercoupons Set Value = " . $userCoupon->Value . "  , Customer = " . $userCoupon->Customer . " , Date = '" . $userCoupon->Date . "', Time = " . $userCoupon->Time . " Where UserCouponId=" . $userCoupon->UserCouponId . "";
        $this->da->exec($SQL);
    }

    public function UpdateValue(UserCoupon $userCoupon)
    {
        $SQL = "Update usercoupons Set Value = " . $userCoupon->Value . "   Where UserCouponId=" . $userCoupon->UserCouponId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From usercoupons Where UserCouponId= " . $id;
        $this->da->exec($SQL);
    }

    public function DeleteUserCouponsRelatedToCustomer($customer)
    {
        $SQL = "DELETE FROM  Where Customer=" . $customer;
        $this->da->exec($SQL);
    }


    public function FindOneUserCouponBasedOnId($id)
    {
        $SQL = "Select usercoupons.UserCouponId , usercoupons.Time , usercoupons.Date, usercoupons.Value , customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address From usercoupons Inner Join customers On usercoupons.Customer = customers.CustomerId Where UserCouponId=" . $id;
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
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
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $usercoupon = new UserCoupon();
            $usercoupon->UserCouponId = $row['UserCouponId'];
        }
        return $usercoupon;
    }

}
