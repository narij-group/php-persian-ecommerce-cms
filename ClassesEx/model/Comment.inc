<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "Customer.inc";

/**
 * Class Comment
 */
class Comment {

    /**
     * @var int
     */
    public $CommentId;
    /**
     * @var Customer
     */
    public $Customer;
    /**
     * @var string
     */
    public $Value;
    /**
     * @var int
     */
    public $ReplyId;
    /**
     * @var string
     */
    public $Date;
    /**
     * @var int
     */
    public $ProductId;
    /**
     * @var int
     */
    public $Activated;

    /**
     * @return int
     */
    public function getCommentId()
    {
        return $this->CommentId;
    }

    /**
     * @param int $CommentId
     */
    public function setCommentId($CommentId)
    {
        $this->CommentId = $CommentId;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * @param Customer $Customer
     */
    public function setCustomer($Customer)
    {
        $this->Customer = $Customer;
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
     * @return int
     */
    public function getReplyId()
    {
        return $this->ReplyId;
    }

    /**
     * @param int $ReplyId
     */
    public function setReplyId($ReplyId)
    {
        $this->ReplyId = $ReplyId;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param string $Date
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->ProductId;
    }

    /**
     * @param int $ProductId
     */
    public function setProductId($ProductId)
    {
        $this->ProductId = $ProductId;
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
     * Comment constructor.
     */
    public function __construct() {
        $this->CommentId = 0;
        $this->Customer = new Customer();
        $this->Value = "";
        $this->ReplyId = 0;
        $this->Date = "";
        $this->ProductId = 0;
        $this->Activated = 0;
    }

}
