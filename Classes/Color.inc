<?php

require_once 'DataAccess.inc';

class Color {

    public $ColorId;
    public $Green;
    public $DarkBlue;
    public $LightBlue;    

    public function __construct() {
        $this->ColorId = 0;
        $this->Green = " ";
        $this->DarkBlue = " ";
        $this->LightBlue = " ";        
    }

    public function Update() {
        $SQL = "Update colors Set `Green`= '" . $this->Green . "' , `DarkBlue`='" . $this->DarkBlue . "' , `LightBlue` = '" . $this->LightBlue . "'  Where ColorId = 1";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Fill() {
        $SQL = "Select * from `colors` where ColorId=1 ";                
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        while ($row = mysqli_fetch_array($results)) {
            $color = new Color();
            $color->ColorId = $row['ColorId'];
            $color->Green = $row['Green'];
            $color->DarkBlue = $row['DarkBlue'];
            $color->LightBlue = $row['LightBlue'];                               
        }
        return $color;
    }

}
