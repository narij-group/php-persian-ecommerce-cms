<?php
date_default_timezone_set("Asia/Tehran");

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Order.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class OrderDataSource
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

    public function Insert(Order $order)
    {
        $SQL = "Insert Into orders(Customer,Content,SupperGroup,File,Date,Status,Replay) Values (" . $order->getCustomer() . ",'" . $order->getContent() . "','" . $order->getSupperGroup() . "','" . $order->getFile() . "','" . $order->getDate() . "','" . $order->getStatus() . "','" . $order->getReplay() . "')";
        return $this->da->exec($SQL);
    }

    public function Update(Order $order)
    {
        $SQL = "Update orders Set Customer=" . $order->getCustomer() . " , Content='" . $order->getContent() . "' , SupperGroup='" . $order->getSupperGroup() . "' , File='" . $order->getFile() . "' , Date='" . $order->getDate() . "' , Status='" . $order->getStatus() . "' , Replay='" . $order->getReplay() . "' Where OrderId=" . $order->OrderId . "";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From orders Where OrderId = " . $id;
        $this->da->exec($SQL);
    }

    public function FirstId()
    {
        $Id = "SELECT MIN(OrderId) from orders";
        $results = $this->da->execSelect($Id);
        while ($row = mysqli_fetch_array($results)) {
            return $row['MIN(OrderId)'];
        }
    }

    public function Fill()
    {
        $SQL = "Select orders.OrderId , orders.Customer ,orders.Content , orders.SupperGroup , orders.File , orders.Date , orders.Status , orders.Replay , suppergroups.SupperGroupId , suppergroups.Name as SpName , suppergroups.LatinName as SpLatinName ,customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address from orders Inner Join suppergroups on suppergroups.SupperGroupId = orders.SupperGroup Inner Join customers On orders.Customer = customers.CustomerId ";
        $results = $this->da->execSelect($SQL);
        $orders = array();
        while ($row = mysqli_fetch_array($results)) {
            $order = new Order();
            $order->setOrderId($row['OrderId']);
            $order->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $order->getSupperGroup()->setLatinName($row['SpLatinName']);
            $order->getSupperGroup()->setName($row['SpName']);
            $order->getCustomer()->setCustomerId($row['CustomerId']);
            $order->getCustomer()->setName($row['CustomerName']);
            $order->getCustomer()->setFamily($row['Family']);
            $order->getCustomer()->setEmail($row['Email']);
            $order->getCustomer()->setCity($row['City']);
            $order->getCustomer()->setNationalityCode($row['NationalityCode']);
            $order->getCustomer()->setAddress($row['Address']);
            $order->getCustomer()->setEstate($row['Estate']);
            $order->setContent($row['Content']);
            $order->setFile($row['File']);
            $order->setDate($row['Date']);
            $order->setStatus($row['Status']);
            $order->setReplay($row['Replay']);
            $orders[] = $order;
        }
        return $orders;
    }

    public function FillBySupperGroup($supperGroup)
    {
        $SQL = "Select orders.OrderId , orders.Customer ,orders.Content , orders.SupperGroup , orders.File , orders.Date , orders.Status , orders.Replay , suppergroups.SupperGroupId , suppergroups.Name as SpName , suppergroups.LatinName as SpLatinName,customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address from orders Inner Join suppergroups on suppergroups.SupperGroupId = orders.SupperGroup Inner Join customers On orders.Customer = customers.CustomerId Where orders.SupperGroup = $supperGroup";
        $results = $this->da->execSelect($SQL);
        $orders = array();
        while ($row = mysqli_fetch_array($results)) {
            $order = new Order();
            $order->setOrderId($row['OrderId']);
            $order->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $order->getSupperGroup()->setLatinName($row['SpLatinName']);
            $order->getSupperGroup()->setName($row['SpName']);
            $order->getCustomer()->setCustomerId($row['CustomerId']);
            $order->getCustomer()->setName($row['CustomerName']);
            $order->getCustomer()->setFamily($row['Family']);
            $order->getCustomer()->setEmail($row['Email']);
            $order->getCustomer()->setCity($row['City']);
            $order->getCustomer()->setNationalityCode($row['NationalityCode']);
            $order->getCustomer()->setAddress($row['Address']);
            $order->getCustomer()->setEstate($row['Estate']);
            $order->setContent($row['Content']);
            $order->setFile($row['File']);
            $order->setDate($row['Date']);
            $order->setStatus($row['Status']);
            $order->setReplay($row['Replay']);
            $orders[] = $order;
        }
        return $orders;
    }

    public function FindOneOrderBasedOnId($id)
    {
        $SQL = "Select orders.OrderId , orders.Customer ,orders.Content , orders.SupperGroup , orders.File , orders.Date , orders.Status , orders.Replay , suppergroups.SupperGroupId , suppergroups.Name as SpName , suppergroups.LatinName as SpLatinName,customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address from orders Inner Join suppergroups on suppergroups.SupperGroupId = orders.SupperGroup Inner Join customers On orders.Customer = customers.CustomerId where OrderId = " . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $order = new Order();
            $order->setOrderId($row['OrderId']);
            $order->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $order->getSupperGroup()->setLatinName($row['SpLatinName']);
            $order->getSupperGroup()->setName($row['SpName']);
            $order->getCustomer()->setCustomerId($row['CustomerId']);
            $order->getCustomer()->setName($row['CustomerName']);
            $order->getCustomer()->setFamily($row['Family']);
            $order->getCustomer()->setEmail($row['Email']);
            $order->getCustomer()->setCity($row['City']);
            $order->getCustomer()->setNationalityCode($row['NationalityCode']);
            $order->getCustomer()->setAddress($row['Address']);
            $order->getCustomer()->setEstate($row['Estate']);
            $order->setContent($row['Content']);
            $order->setFile($row['File']);
            $order->setDate($row['Date']);
            $order->setStatus($row['Status']);
            $order->setReplay($row['Replay']);
            return $order;
        }
    }

    public function FindOneOrderBasedOnCustomer($id)
    {
        $SQL = "Select orders.OrderId , orders.Customer ,orders.Content , orders.SupperGroup , orders.File , orders.Date , orders.Status , orders.Replay , suppergroups.SupperGroupId , suppergroups.Name as SpName , suppergroups.LatinName as SpLatinName ,customers.CustomerId , customers.Name as CustomerName,customers.Family,customers.Email,customers.Password,customers.City,customers.NationalityCode,customers.Estate,customers.Address from orders Inner Join suppergroups on suppergroups.SupperGroupId = orders.SupperGroup Inner Join customers On orders.Customer = customers.CustomerId where orders.Customer = " . $id;
        $results = $this->da->execSelect($SQL);
        $orders = array();
        while ($row = mysqli_fetch_array($results)) {
            $order = new Order();
            $order->setOrderId($row['OrderId']);
            $order->getSupperGroup()->setSupperGroupId($row['SupperGroupId']);
            $order->getSupperGroup()->setLatinName($row['SpLatinName']);
            $order->getSupperGroup()->setName($row['SpName']);
            $order->getCustomer()->setCustomerId($row['CustomerId']);
            $order->getCustomer()->setName($row['CustomerName']);
            $order->getCustomer()->setFamily($row['Family']);
            $order->getCustomer()->setEmail($row['Email']);
            $order->getCustomer()->setCity($row['City']);
            $order->getCustomer()->setNationalityCode($row['NationalityCode']);
            $order->getCustomer()->setAddress($row['Address']);
            $order->getCustomer()->setEstate($row['Estate']);
            $order->setContent($row['Content']);
            $order->setFile($row['File']);
            $order->setDate($row['Date']);
            $order->setStatus($row['Status']);
            $order->setReplay($row['Replay']);
            $orders[] = $order;
        }
        return $orders;
    }

    function DeleteFolder($path)
    {
        if (is_dir($path) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if (in_array($file->getBasename(), array('.', '..')) !== true) {
                    if ($file->isDir() === true) {
                        rmdir($file->getPathName());
                    } else if (($file->isFile() === true) || ($file->isLink() === true)) {
                        unlink($file->getPathname());
                    }
                }
            }
            return rmdir($path);
        } else if ((is_file($path) === true) || (is_link($path) === true)) {
            return unlink($path);
        }

        return false;
    }


}
