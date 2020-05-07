<?php
require_once 'DataAccess.inc';

class User
{
    public $UserId;
    public $Name;
    public $Family;
    public $Password;
    public $Email;
    public $Username;
    public $Activate;
    public $ActiveCode;
    public $Role;

    public function __construct()
    {
        $this->UserId = 0;
        $this->Name = "";
        $this->Family = "";
        $this->Email = "";
        $this->Password = "";
        $this->Username = "";
        $this->Activate = 0;
        $this->Role = 0;
    }

    public function Insert()
    {
        $SQL = "Insert Into users(`Name`,Family,Email,`Password`,Username,Activate,ActiveCode,Role) Values('" . $this->Name . "' , '" . $this->Family . "' , '" . $this->Email . "' , '" . $this->Password . "' , '" . $this->Username . "' , " . $this->Activate . " , " . $this->ActiveCode . " , " . $this->Role . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Update()
    {
        $SQL = "Update users Set `Name`='" . $this->Name . "',Family='" . $this->Family . "',Email='" . $this->Email . "',`Password`='" . $this->Password . "',Username='" . $this->Username . "' , Activate=" . $this->Activate . " , ActiveCode=" . $this->ActiveCode . ", Role=" . $this->Role . " Where UserId=" . $this->UserId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete()
    {
        $SQL = "Delete From users Where UserId=" . $this->UserId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneUser()
    {
        $SQL = "Select * From users Where UserId=" . $this->UserId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $user = new User();
            $user->UserId = $row['UserId'];
            $user->Name = $row['Name'];
            $user->Family = $row['Family'];
            $user->Email = $row['Email'];
            $user->Password = $row['Password'];
            $user->Username = $row['Username'];
            $user->Activate = $row['Activate'];
            $user->ActiveCode = $row['ActiveCode'];
            $user->Role = $row['Role'];
            return $user;
        }
    }

    public function Fill()
    {
        $SQL = "Select * From users ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $users = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $user = new User();
            $user->UserId = $row['UserId'];
            $user->Name = $row['Name'];
            $user->Family = $row['Family'];
            $user->Email = $row['Email'];
            $user->Password = $row['Password'];
            $user->Username = $row['Username'];
            $user->Activate = $row['Activate'];
            $user->ActiveCode = $row['ActiveCode'];
            $user->Role = $row['Role'];
            $users[$i] = $user;
            $i++;
        }
        return $users;
    }

    public function FindAdmins()
    {
        $SQL = "Select * From users Where Role = 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $users = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $user = new User();
            $user->Email = $row['Email'];
            $users[$i] = $user;
            $i++;
        }
        return $users;
    }

    public function GetThisRoleUsers($roleid)
    {
        $SQL = "Select * From users WHERE Role = $roleid";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $users = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $user = new User();
            $user->UserId = $row['UserId'];
            $user->Name = $row['Name'];
            $user->Family = $row['Family'];
            $user->Email = $row['Email'];
            $user->Password = $row['Password'];
            $user->Username = $row['Username'];
            $user->Activate = $row['Activate'];
            $user->ActiveCode = $row['ActiveCode'];
            $user->Role = $row['Role'];
            $users[$i] = $user;
            $i++;
        }
        return $users;
    }

    public function IsUserAllowed()
    {
        $SQL = "Select * From users Where BINARY Username='" . $this->Username . "' And BINARY Password='" . $this->Password . "' And Activate = 1 ";
        //echo $SQL;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function IsUserAllowed2()
    {
        $SQL = "Select * From users INNER JOIN roles on RoleId = Role Where Username='" . $this->Username . "' And Password='" . $this->Password . "' And Activate = 1 And roles.InsertProduct = 1 ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function GetUserId()
    {
        $SQL = "Select UserId From users Where Username='" . $this->Username . "' And Password='" . $this->Password . "' And Activate = 1 ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            return $row['UserId'];
        }
    }

}
