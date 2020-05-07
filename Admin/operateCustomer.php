<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CustomerDataSource.inc';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $cds = new CustomerDataSource();
        $cds->open();
        $customer = new Customer();
        $customer->CustomerId = $_POST['id'];
        $customer2 = $cds->FindOneCustomerBasedOnId($_POST['id']);
        $customer->Name = $_POST['name'];
        $customer->Family = $_POST['family'];
        $customer->Username = $_POST['username'];
//$customer->Password = md5($_POST['password']);
        if ($customer2->Password == $_POST['password']) {
            $customer->Password = $_POST['password'];
        } else {
            $customer->Password = md5($_POST['password']);
        }
        $customer->Email = $_POST['email'];
        $customer->Address = $_POST['address'];
        $customer->City = $_POST['city'];
        $customer->NationalityCode = $_POST['nationalitycode'];
        $customer->Estate = $_POST['estate'];
        $customer->Mobile = $_POST['mobile'];
        $customer->Phone = $_POST['phone'];
        $customer->PostCode = $_POST['postcode'];

        $cds->Update($customer);
        $cds->close();


    } else {
        $customer = new Customer();
        $customer->Name = $_POST['name'];
        $customer->Family = $_POST['family'];
        $customer->Username = $_POST['username'];
        $customer->Password = md5($_POST['password']);
        $customer->Email = $_POST['email'];
        $customer->Address = $_POST['address'];
        $customer->City = $_POST['city'];
        $customer->NationalityCode = $_POST['nationalitycode'];
        $customer->Estate = $_POST['estate'];
        $customer->Mobile = $_POST['mobile'];
        $customer->Phone = $_POST['phone'];
        $customer->PostCode = $_POST['postcode'];

        $cds = new CustomerDataSource();
        $cds->open();
        $cds->Insert($customer);
        $cds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($role->DeleteCustomer != 1) {
        header('Location:Index.php');
        die();
    }


    $cds = new CustomerDataSource();
    $cds->open();
    $cds->K_Delete($_GET['id']);
    $cds->close();


}
header('Location:Customers.php');





