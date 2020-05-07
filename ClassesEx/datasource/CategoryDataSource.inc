<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Category.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class CategoryDataSource
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

    public function Insert(Category $category)
    {

        $sql = "Insert Into categories(`Name`,Description,Parent,User) Values ('" . $category->getName() . "','" . $category->getDescription() . "' , " . $category->getParent() . " , " . $category->getUser() . ")";
        $this->da->exe($sql);
    }

    public function Update(Category $category)
    {
        $sql = "Update categories Set `Name`='" . $category->getName() . "',Description='" . $category->getDescription() . "' , Parent=" . $category->getParent() . " Where CategoryId=" . $category->getCategoryId() . "";
        $this->da->exec($sql);
    }

    public function Delete($id)
    {
        $sql = "Delete From categories Where CategoryId= " . $id;
        $this->da->exec($sql);
    }

    public function FindOneCategoryBsedOnId($id)
    {
        $sql = "Select categories.CategoryId , categories.Name as CName , categories.Description , categories.Parent , users.UserId , users.Name as UName, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `categories` Inner Join users On categories.User = users.UserId Where CategoryId=" . $id;
        $results = $this->da->execSelect($sql);
        while ($row = mysqli_fetch_array($results)) {
            $category = new Category();
            $category->setCategoryId($row['CategoryId']);
            $category->setName($row['CName']);
            $category->setDescription($row['Description']);
            $category->setParent($row['Parent']);
            $category->getUser()->setUserId($row['UserId']);
            $category->getUser()->setName($row['UName']);
            $category->getUser()->setFamily($row['Family']);
            $category->getUser()->setUsername($row['Username']);
            return $category;
        }
    }

    public function Fill()
    {
        $sql = "Select categories.CategoryId , categories.Name as CName , categories.Description , categories.Parent , users.UserId , users.Name as UName, users.Family, users.Username, users.Password, users.Email, users.Activate, users.ActiveCode From `categories` Inner Join users On categories.User = users.UserId ";
        $results = $this->da->execSelect($sql);
        $categories = array();
        while ($row = mysqli_fetch_array($results)) {
            $category = new Category();
            $category->setCategoryId($row['CategoryId']);
            $category->setName($row['CName']);
            $category->setDescription($row['Description']);
            $category->setParent($row['Parent']);
            $category->getUser()->setUserId($row['UserId']);
            $category->getUser()->setName($row['UName']);
            $category->getUser()->setFamily($row['Family']);
            $category->getUser()->setUsername($row['Username']);
            $categories[] = $category;
        }
        return $categories;
    }

}
