<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Color.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class ColorDataSource
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


    public function Update(Color $color)
    {
        $SQL = "Update colors Set `Green`= '" . $color->getGreen() . "' , `DarkBlue`='" . $color->getDarkBlue() . "' , `LightBlue` = '" . $color->getLightBlue() . "'  Where ColorId = 1";
        $this->da->exec($SQL);
    }

    public function Fill()
    {
        $SQL = "Select * from `colors` where ColorId=1 ";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $color = new Color();
            $color->setColorId($row['ColorId']);
            $color->setGreen($row['Green']);
            $color->setDarkBlue($row['DarkBlue']);
            $color->setLightBlue($row['LightBlue']);
        }
        return $color;
    }

}
