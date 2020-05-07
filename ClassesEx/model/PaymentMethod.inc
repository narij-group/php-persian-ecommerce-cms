<?php


/**
 * Class PaymentMethod
 */
class PaymentMethod {

    /**
     * @var int
     */
    public $PaymentMethodId;
    /**
     * @var string
     */
    public $Name;
    /**
     * @var int
     */
    public $Activated;

    /**
     * @return int
     */
    public function getPaymentMethodId()
    {
        return $this->PaymentMethodId;
    }

    /**
     * @param int $PaymentMethodId
     */
    public function setPaymentMethodId($PaymentMethodId)
    {
        $this->PaymentMethodId = $PaymentMethodId;
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
     * @return int
     */
    public function getActivated()
    {
        return $this->Activated;
    }

    /**
     * @param int $Activated
     */
    public function setActivated($Activated)
    {
        $this->Activated = $Activated;
    }

    /**
     * PaymentMethod constructor.
     */
    public function __construct() {
        $this->PaymentMethodId = 0;
        $this->Name = "";
        $this->Activated = 1;
    }


}
