<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'MainMenu.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'SubGroup.inc';

/**
 * Class SubMenu
 */
class SubMenu
{

    /**
     * @var int
     */
    public $SubMenuId;
    /**
     * @var SubGroup
     */
    public $SubGroup;
    /**
     * @var string
     */
    public $Image;
    /**
     * @var MainMenu
     */
    public $MainMenu;
    /**
     * @var int
     */
    public $Number;
    /**
     * @var int
     */
    public $Disabled;

    /**
     * SubMenu constructor.
     */
    public function __construct()
    {
        $this->SubMenuId = 0;
        $this->Number = 0;
        $this->Disabled = 0;
        $this->SubGroup = new SubGroup();
        $this->Image = "جهت انتخاب تصویر اینجا را کلیک کنید...";
        $this->MainMenu = new MainMenu();
    }

    /**
     * @return int
     */
    public function getSubMenuId()
    {
        return $this->SubMenuId;
    }

    /**
     * @param int $SubMenuId
     */
    public function setSubMenuId($SubMenuId)
    {
        $this->SubMenuId = $SubMenuId;
    }

    /**
     * @return SubGroup
     */
    public function getSubGroup()
    {
        return $this->SubGroup;
    }

    /**
     * @param SubGroup $SubGroup
     */
    public function setSubGroup($SubGroup)
    {
        $this->SubGroup = $SubGroup;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->Image;
    }

    /**
     * @param string $Image
     */
    public function setImage($Image)
    {
        $this->Image = $Image;
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


}
