<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../model/Comment.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../dataaccess/DataAccessEx.inc";

class CommentDataSource
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

    public function Insert(Comment $comment)
    {
        $SQL = "Insert Into comments(`Customer`,Value,ReplyId,Date,ProductId) Values (" . $comment->getCustomer() . ",'" . $comment->getValue() . "' , " . $comment->getReplyId() . " ,'" . $comment->getDate() . "' , " . $comment->getProductId() . ")";
        $this->da->exec($SQL);
    }

    public function Delete($id)
    {
        $SQL = "Delete From comments Where CommentId= " . $id;
        $this->da->exec($SQL);
    }

    public function DeleteCommentsRelatedToProduct($id)
    {
        $SQL = "DELETE From comments Where ProductId=" . $id;
        $this->da->exec($SQL);
    }

    public function DeleteCommentsRelatedToCustomer($id)
    {
        $SQL = "DELETE From comments Where Customer=" . $id ;
        $this->da->exec($SQL);
    }


    public function Activate($id)
    {
        $SQL = "Update comments Set Activated = 1 Where CommentId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function DissActivate($id)
    {
        $SQL = "Update comments Set Activated = 2 Where CommentId=" . $id . "";
        $this->da->exec($SQL);
    }

    public function FindOneCommentBasedOnId($id)
    {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer Where CommentId=" . $id;
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->setCommentId($row['CommentId']);
            $comment->getCustomer()->setCustomerId($row['CustomerId']);
            $comment->getCustomer()->setName($row['Name']);
            $comment->getCustomer()->setFamily($row['Family']);
            $comment->setValue($row['Value']);
            $comment->setDate($row['Date']);
            $comment->setReplyId($row['ReplyId']);
            $comment->setProductId($row['ProductId']);
            $comment->setActivated($row['Activated']);
            return $comment;
        }
    }

    public function GetCommentsForProduct($id)
    {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer Where ProductId=" . $id;
        $results = $this->da->execSelect($SQL);
        $comments = array();
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->setCommentId($row['CommentId']);
            $comment->getCustomer()->setCustomerId($row['CustomerId']);
            $comment->getCustomer()->setName($row['Name']);
            $comment->getCustomer()->setFamily($row['Family']);
            $comment->setValue($row['Value']);
            $comment->setDate($row['Date']);
            $comment->setReplyId($row['ReplyId']);
            $comment->setProductId($row['ProductId']);
            $comment->setActivated($row['Activated']);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function GetThisCustomerComments($id)
    {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer Where Customer=" . $id . " Order BY CommentId DESC";
        $results = $this->da->execSelect($SQL);
        $comments = array();
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->setCommentId($row['CommentId']);
            $comment->getCustomer()->setCustomerId($row['CustomerId']);
            $comment->getCustomer()->setName($row['Name']);
            $comment->getCustomer()->setFamily($row['Family']);
            $comment->setValue($row['Value']);
            $comment->setDate($row['Date']);
            $comment->setReplyId($row['ReplyId']);
            $comment->setProductId($row['ProductId']);
            $comment->setActivated($row['Activated']);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function FindOneCommentReplies($id)
    {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer  Where ReplyId=" . $id . " AND Activated = 1";
        $results = $this->da->execSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->setCommentId($row['CommentId']);
            $comment->getCustomer()->setCustomerId($row['CustomerId']);
            $comment->getCustomer()->setName($row['Name']);
            $comment->getCustomer()->setFamily($row['Family']);
            $comment->setValue($row['Value']);
            $comment->setDate($row['Date']);
            $comment->setReplyId($row['ReplyId']);
            $comment->setProductId($row['ProductId']);
            $comment->setActivated($row['Activated']);
            $comments[] = $comment;
        }
        if (isset($comments) == true) {
            return $comments;
        }
    }

    public function Fill()
    {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer  ORDER BY CommentId DESC";
        $results = $this->da->execSelect($SQL);
        $comments = array();
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->setCommentId($row['CommentId']);
            $comment->getCustomer()->setCustomerId($row['CustomerId']);
            $comment->getCustomer()->setName($row['Name']);
            $comment->getCustomer()->setFamily($row['Family']);
            $comment->setValue($row['Value']);
            $comment->setDate($row['Date']);
            $comment->setReplyId($row['ReplyId']);
            $comment->setProductId($row['ProductId']);
            $comment->setActivated($row['Activated']);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function CFill(Comment $comment)
    {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer WHERE ProductId = " . $comment->getProductId() . " AND Activated = 1 ORDER BY CommentId DESC";
        $results = $this->da->execSelect($SQL);
        $comments = array();
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->setCommentId($row['CommentId']);
            $comment->getCustomer()->setCustomerId($row['CustomerId']);
            $comment->getCustomer()->setName($row['Name']);
            $comment->getCustomer()->setFamily($row['Family']);
            $comment->setValue($row['Value']);
            $comment->setDate($row['Date']);
            $comment->setReplyId($row['ReplyId']);
            $comment->setProductId($row['ProductId']);
            $comment->setActivated($row['Activated']);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function LimitedFill($limit)
    {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer  ORDER BY CommentId DESC Limit $limit";
        $results = $this->da->execSelect($SQL);
        $comments = array();
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->setCommentId($row['CommentId']);
            $comment->getCustomer()->setCustomerId($row['CustomerId']);
            $comment->getCustomer()->setName($row['Name']);
            $comment->getCustomer()->setFamily($row['Family']);
            $comment->setValue($row['Value']);
            $comment->setDate($row['Date']);
            $comment->setReplyId($row['ReplyId']);
            $comment->setProductId($row['ProductId']);
            $comment->setActivated($row['Activated']);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function Notification()
    {
        $SQL = "Select Activated From comments where Activated = 0 ";
        $results = $this->da->execSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $i++;
        }
        return $i;
    }

}
