<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CategoryDataSource.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && $_POST['id'] != 0) {

        $category = new Category();
        $category->CategoryId = $_POST['id'];
        $category->Name = $_POST['name'];
        $category->Description = $_POST['description'];
        $category->Parent = $_POST['parent'];

        $cds = new CategoryDataSource();
        $cds->open();
        $cds->Update($category);
        $cds->close();



    } else {
        $category = new Category();
        $category->Name = $_POST['name'];
        $category->Description = $_POST['description'];
        $category->Parent = $_POST['parent'];
        $category->User = $_POST['user'];
        $cds = new CategoryDataSource();
        $cds->open();
        $cds->Insert($category);
        $cds->close();


    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $category = new CategoryDataSource();
    $category->open();
    $category->Delete($_GET['id']);
    $category->close();

}


header('Location:Categories.php');


