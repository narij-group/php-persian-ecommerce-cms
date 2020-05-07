<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/User.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class UserDataSource
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


    public function Insert(User $user)
    {
        $sql = "Insert Into users(`Name`,Family,Email,`Password`,Username,Activate,ActiveCode,Role) Values('" . $user->getName() . "' , '" . $user->getFamily() . "' , '" . $user->getEmail() . "' , '" . $user->getPassword() . "' , '" . $user->getUsername() . "' , " . $user->getActivate() . " , " . $user->getActiveCode() . " , " . $user->getRole() . ")";
        $this->da->exec($sql);
    }

    public function Update(User $user)
    {
        $sql = "Update users Set `Name`='" . $user->getName() . "',Family='" . $user->getFamily() . "',Email='" . $user->getEmail() . "',`Password`='" . $user->getPassword() . "',Username='" . $user->getUsername() . "' , Activate=" . $user->getActivate() . " , ActiveCode=" . $user->getActiveCode() . ", Role=" . $user->getRole() . " Where UserId=" . $user->getUserId();
        $this->da->exec($sql);
    }

    public function Delete($id)
    {
        $sql = "Delete From users Where UserId=" . $id;
        $this->da->exec($sql);
    }

    public function FindOneUserBasedOnId($id)
    {
        $sql = "Select * From users Where UserId=" . $id;
        $results = $this->da->execSelect($sql);
        while ($row = mysqli_fetch_array($results)) {
            $user = new User();
            $user->setUserId($row['UserId']);
            $user->setName($row['Name']);
            $user->setFamily($row['Family']);
            $user->setEmail($row['Email']);
            $user->setPassword($row['Password']);
            $user->setUsername($row['Username']);
            $user->setActivate($row['Activate']);
            $user->setActiveCode($row['ActiveCode']);
            $user->setRole($row['Role']);
            return $user;
        }
    }

    public function Fill()
    {
        $sql = "Select * From users ";
        $results = $this->da->execSelect($sql);
        $users = array();
        while ($row = mysqli_fetch_array($results)) {
            $user = new User();
            $user->setUserId($row['UserId']);
            $user->setName($row['Name']);
            $user->setFamily($row['Family']);
            $user->setEmail($row['Email']);
            $user->setPassword($row['Password']);
            $user->setUsername($row['Username']);
            $user->setActivate($row['Activate']);
            $user->setActiveCode($row['ActiveCode']);
            $user->setRole($row['Role']);
            $users[] = $user;
        }
        return $users;
    }

    public function FindAdmins()
    {
        $sql = "Select * From users Where Role = 1";
        $results = $this->da->execSelect($sql);
        $users = array();
        while ($row = mysqli_fetch_array($results)) {
            $user = new User();
            $user->setEmail($row['Email']);
            $users[] = $user;
        }
        return $users;
    }

    public function GetThisRoleUsers($roleid)
    {
        $sql = "Select * From users WHERE Role = $roleid";
        $results = $this->da->execSelect($sql);
        $users = array();
        while ($row = mysqli_fetch_array($results)) {
            $user = new User();
            $user->setUserId($row['UserId']);
            $user->setName($row['Name']);
            $user->setFamily($row['Family']);
            $user->setEmail($row['Email']);
            $user->setPassword($row['Password']);
            $user->setUsername($row['Username']);
            $user->setActivate($row['Activate']);
            $user->setActiveCode($row['ActiveCode']);
            $user->setRole($row['Role']);
            $users[] = $user;
        }
        return $users;
    }

    public function IsUserAllowed(User $user)
    {
        $sql = "Select * From users Where BINARY Username='" . $user->getUsername() . "' And BINARY Password='" . $user->getPassword() . "' And Activate = 1 ";
        echo $sql;
        $results = $this->da->execSelect($sql);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function IsUserAllowed2(User $user)
    {
        $sql = "Select * From users INNER JOIN roles on RoleId = Role Where BINARY  Username='" . $user->getUsername() . "' And BINARY Password='" . $user->getPassword() . "' And Activate = 1 And roles.InsertProduct = 1 ";
        $results = $this->da->execSelect($sql);
        if (mysqli_num_rows($results) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function GetUserId(User $user)
    {
        $sql = "Select UserId From users Where BINARY Username='" . $user->getUsername() . "' And BINARY Password='" . $user->getPassword() . "' And Activate = 1 ";
        $results = $this->da->execSelect($sql);
        while ($row = mysqli_fetch_array($results)) {
            return $row['UserId'];
        }
    }

}
