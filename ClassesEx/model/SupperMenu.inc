<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'MainMenu.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'SubMenu.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'SupperGroup.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'MenuTitle.inc';

/**
 * Class SupperMenu
 */
class SupperMenu
{
    /**
     * @var int
     */
    public $SupperMenuId;
    /**
     * @var SupperGroup
     */
    public $SupperGroup;
    /**
     * @var MenuTitle
     */
    public $Title;
    /**
     * @var SubMenu
     */
    public $SubMenu;
    /**
     * @var MainMenu
     */
    public $MainMenu;

    /**
     * @return int
     */
    public function getSupperMenuId()
    {
        return $this->SupperMenuId;
    }

    /**
     * @param int $SupperMenuId
     */
    public function setSupperMenuId($SupperMenuId)
    {
        $this->SupperMenuId = $SupperMenuId;
    }

    /**
     * @return SupperGroup
     */
    public function getSupperGroup()
    {
        return $this->SupperGroup;
    }

    /**
     * @param SupperGroup $SupperGroup
     */
    public function setSupperGroup($SupperGroup)
    {
        $this->SupperGroup = $SupperGroup;
    }

    /**
     * @return MenuTitle
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param MenuTitle $Title
     */
    public function setTitle($Title)
    {
        $this->Title = $Title;
    }

    /**
     * @return SubMenu
     */
    public function getSubMenu()
    {
        return $this->SubMenu;
    }

    /**
     * @param SubMenu $SubMenu
     */
    public function setSubMenu($SubMenu)
    {
        $this->SubMenu = $SubMenu;
    }

    /**
     * @return MainMenu
     */
    public function getMainMenu()
    {
        return $this->MainMenu;
    }

    /**
     * @param MainMenu $MainMenu
     */
    public function setMainMenu($MainMenu)
    {
        $this->MainMenu = $MainMenu;
    }

    /**
     * SupperMenu constructor.
     */
    public function __construct()
    {
        $this->SupperMenuId = 0;
        $this->SupperGroup = new SupperGroup();
        $this->Title = new MenuTitle();
        $this->SubMenu = new SubMenu();
        $this->MainMenu = new MainMenu();
    }

}
