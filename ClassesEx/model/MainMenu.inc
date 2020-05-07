<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Group.inc';

/**
 * Class MainMenu
 */
class MainMenu
{

    /**
     * @var int
     */
    public $MainMenuId;
    /**
     * @var Group
     */
    public $Group;
    /**
     * @var int
     */
    public $Number;
    /**
     * @var int
     */
    public $Disabled;

    /**
     * @return int
     */
    public function getMainMenuId()
    {
        return $this->MainMenuId;
    }

    /**
     * @param int $MainMenuId
     */
    public function setMainMenuId($MainMenuId)
    {
        $this->MainMenuId = $MainMenuId;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->Group;
    }

    /**
     * @param Group $Group
     */
    public function setGroup($Group)
    {
        $this->Group = $Group;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->Number;
    }

    /**
     * @param int $Number
     */
    public function setNumber($Number)
    {
        $this->Number = $Number;
    }

    /**
     * @return int
     */
    public function getDisabled()
    {
        return $this->Disabled;
    }

    /**
     * @param int $Disabled
     */
    public function setDisabled($Disabled)
    {
        $this->Disabled = $Disabled;
    }


    /**
     * MainMenu constructor.
     */
    public function __construct()
    {
        $this->MainMenuId = 0;
        $this->Group = new Group();
        $this->Number = 0;
        $this->Disabled = 0;
    }

}
