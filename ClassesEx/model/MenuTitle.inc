<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'SubMenu.inc';

/**
 * Class MenuTitle
 */
class MenuTitle
{

    /**
     * @var int
     */
    public $MenuTitleId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var SubMenu
     */
    public $SubMenu;
    /**
     * @var int
     */
    public $Column;

    /**
     * @return int
     */
    public function getMenuTitleId()
    {
        return $this->MenuTitleId;
    }

    /**
     * @param int $MenuTitleId
     */
    public function setMenuTitleId($MenuTitleId)
    {
        $this->MenuTitleId = $MenuTitleId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
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
     * @return int
     */
    public function getColumn()
    {
        return $this->Column;
    }

    /**
     * @param int $Column
     */
    public function setColumn($Column)
    {
        $this->Column = $Column;
    }


    /**
     * MenuTitle constructor.
     */
    public function __construct()
    {
        $this->MenuTitleId = 0;
        $this->Name = "";
        $this->SubMenu = new SubMenu();
        $this->Column = 0;
    }


}
