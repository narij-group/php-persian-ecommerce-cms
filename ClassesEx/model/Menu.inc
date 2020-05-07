<?php

require_once __DIR__ . DIRECTORY_SEPARATOR. 'MainMenu.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR.'SubMenu.inc';
require_once  __DIR__ . DIRECTORY_SEPARATOR.'SupperMenu.inc';

/**
 * Class Menu
 */
class Menu {

    /**
     * @var int
     */
    public $MenuId;
    /**
     * @var SupperMenu
     */
    public $SupperMenu;
    /**
     * @var SubMenu
     */
    public $SubMenu;
    /**
     * @var MainMenu
     */
    public $MainMenu;
    /**
     * @var int
     */
    public $Product;

    /**
     * @return int
     */
    public function getMenuId()
    {
        return $this->MenuId;
    }

    /**
     * @param int $MenuId
     */
    public function setMenuId($MenuId)
    {
        $this->MenuId = $MenuId;
    }

    /**
     * @return SupperMenu
     */
    public function getSupperMenu()
    {
        return $this->SupperMenu;
    }

    /**
     * @param SupperMenu $SupperMenu
     */
    public function setSupperMenu($SupperMenu)
    {
        $this->SupperMenu = $SupperMenu;
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
     * @return int
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * @param int $Product
     */
    public function setProduct($Product)
    {
        $this->Product = $Product;
    }

    /**
     * Menu constructor.
     */
    public function __construct() {
        $this->MenuId = 0;
        $this->SupperMenu = new SupperMenu();
        $this->SubMenu = new SubMenu();
        $this->MainMenu = new MainMenu();
        $this->Product = 0;
    }

}
