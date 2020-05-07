<?php

require_once __DIR__ . DIRECTORY_SEPARATOR. 'SupperGroup.inc';

/**
 * Class ProductProperty
 */
class ProductProperty {

    /**
     * @var int
     */
    public  $ProductPropertyId;
    /**
     * @var string
     */
    public  $Name;
    /**
     * @var string
     */
    public  $Value;
    /**
     * @var SupperGroup
     */
    public  $Group;
    /**
     * @var int
     */
    public  $Search;

    /**
     * @return int
     */
    public function getProductPropertyId()
    {
        return $this->ProductPropertyId;
    }

    /**
     * @param int $ProductPropertyId
     */
    public function setProductPropertyId($ProductPropertyId)
    {
        $this->ProductPropertyId = $ProductPropertyId;
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
     * @return string
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * @param string $Value
     */
    public function setValue($Value)
    {
        $this->Value = $Value;
    }

    /**
     * @return SupperGroup
     */
    public function getGroup()
    {
        return $this->Group;
    }

    /**
     * @param SupperGroup $Group
     */
    public function setGroup($Group)
    {
        $this->Group = $Group;
    }

    /**
     * @return int
     */
    public function getSearch()
    {
        return $this->Search;
    }

    /**
     * @param int $Search
     */
    public function setSearch($Search)
    {
        $this->Search = $Search;
    }


    /**
     * ProductProperty constructor.
     */
    public function __construct() {
        $this->ProductPropertyId = 0;
        $this->Group = new SupperGroup();
        $this->Name = "";
        $this->Value = "";
        $this->Search = 0;
    }


}
