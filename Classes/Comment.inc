<?php

require_once 'DataAccess.inc';
require_once 'Customer.inc';

class Comment {

    public $CommentId;
    public $Customer;
    public $Value;
    public $ReplyId;
    public $Date;
    public $ProductId;
    public $Activated;

    public function __construct() {
        $this->CommentId = 0;
        $this->Customer = new Customer();
        $this->Value = "";
        $this->ReplyId = 0;
        $this->Date = "";
        $this->ProductId = 0;
        $this->Activated = 0;
    }

    public function Insert() {
        $SQL = "Insert Into comments(`Customer`,Value,ReplyId,Date,ProductId) Values (" . $this->Customer . ",'" . $this->Value . "' , " . $this->ReplyId . " ,'" . $this->Date . "' , " . $this->ProductId . ")";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Delete() {
        $SQL = "Delete From comments Where CommentId= " . $this->CommentId;
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function Activate() {
        $SQL = "Update comments Set Activated = 1 Where CommentId=" . $this->CommentId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function DissActivate() {
        $SQL = "Update comments Set Activated = 2 Where CommentId=" . $this->CommentId . "";
        $db = new DataAccess();
        $db->execute($SQL);
    }

    public function FindOneComment() {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer Where CommentId=" . $this->CommentId;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->CommentId = $row['CommentId'];
            
            $comment->Customer->CustomerId = $row['CustomerId'];
            $comment->Customer->Name = $row['Name'];
            $comment->Customer->Family = $row['Family'];    
            $comment->Value = $row['Value'];
            $comment->Date = $row['Date'];
            $comment->ReplyId = $row['ReplyId'];
            $comment->ProductId = $row['ProductId'];
            $comment->Activated = $row['Activated'];
            return $comment;
        }
    }

    public function GetCommentsForProduct($id) {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer Where ProductId=" . $id;
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $comments = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->CommentId = $row['CommentId'];            
            $comment->Value = $row['Value'];
            $comment->Customer->CustomerId = $row['CustomerId'];
            $comment->Customer->Name = $row['Name'];
            $comment->Customer->Family = $row['Family'];    
            $comment->Date = $row['Date'];
            $comment->ReplyId = $row['ReplyId'];
            $comment->ProductId = $row['ProductId'];
            $comment->Activated = $row['Activated'];
            $comments[$i] = $comment;
            $i++;
        }
        return $comments;
    }
    public function GetThisCustomerComments($id) {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer Where Customer=" . $id . " Order BY CommentId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $comments = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->CommentId = $row['CommentId'];
            $comment->Value = $row['Value'];
            $comment->Customer->CustomerId = $row['CustomerId'];
            $comment->Customer->Name = $row['Name'];
            $comment->Customer->Family = $row['Family'];
            $comment->Date = $row['Date'];
            $comment->ReplyId = $row['ReplyId'];
            $comment->ProductId = $row['ProductId'];
            $comment->Activated = $row['Activated'];
            $comments[$i] = $comment;
            $i++;
        }
        return $comments;
    }

    public function FindOneCommentReplies($id) {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer  Where ReplyId=" . $id . " AND Activated = 1";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->CommentId = $row['CommentId'];
            
            $comment->Customer->CustomerId = $row['CustomerId'];
            $comment->Customer->Name = $row['Name'];
            $comment->Customer->Family = $row['Family'];    
            $comment->Value = $row['Value'];
            $comment->Date = $row['Date'];
            $comment->ReplyId = $row['ReplyId'];
            $comment->ProductId = $row['ProductId'];
            $comment->Activated = $row['Activated'];
            $comments[$i] = $comment;
            $i++;
        }
        if (isset($comments) == true) {
            return $comments;
        }
    }

    public function Fill() {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer  ORDER BY CommentId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $comments = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->CommentId = $row['CommentId'];            
            $comment->Value = $row['Value'];
            $comment->Date = $row['Date'];
            $comment->Customer->CustomerId = $row['CustomerId'];
            $comment->Customer->Name = $row['Name'];
            $comment->Customer->Family = $row['Family'];            
            $comment->ReplyId = $row['ReplyId'];
            $comment->ProductId = $row['ProductId'];
            $comment->Activated = $row['Activated'];
            $comments[$i] = $comment;
            $i++;
        }
        return $comments;
    }
    public function CFill() {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer WHERE ProductId = ".$this->ProductId." AND Activated = 1 ORDER BY CommentId DESC";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $comments = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->CommentId = $row['CommentId'];
            $comment->Value = $row['Value'];
            $comment->Date = $row['Date'];
            $comment->Customer->CustomerId = $row['CustomerId'];
            $comment->Customer->Name = $row['Name'];
            $comment->Customer->Family = $row['Family'];
            $comment->ReplyId = $row['ReplyId'];
            $comment->ProductId = $row['ProductId'];
            $comment->Activated = $row['Activated'];
            $comments[$i] = $comment;
            $i++;
        }
        return $comments;
    }

    public function LimitedFill($limit) {
        $SQL = "Select * From comments Inner Join customers on CustomerId = Customer  ORDER BY CommentId DESC Limit $limit";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);
        $comments = array();
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {
            $comment = new Comment();
            $comment->CommentId = $row['CommentId'];            
            $comment->Value = $row['Value'];
            $comment->Date = $row['Date'];
            $comment->Customer->CustomerId = $row['CustomerId'];
            $comment->Customer->Name = $row['Name'];
            $comment->Customer->Family = $row['Family'];            
            $comment->ReplyId = $row['ReplyId'];
            $comment->ProductId = $row['ProductId'];
            $comment->Activated = $row['Activated'];
            $comments[$i] = $comment;
            $i++;
        }
        return $comments;
    }

      public function Notification() {
        $SQL = "Select Activated From comments where Activated = 0 ";
        $db = new DataAccess();
        $results = $db->executeSelect($SQL);        
        $i = 0;
        while ($row = mysqli_fetch_array($results)) {            
            $i++;
        }
        return $i;
    }

}
