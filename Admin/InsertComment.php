<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';
$comment = new Comment();
$comment->Name = $_POST['name'];
$comment->Value = nl2br($_POST['value']);
$comment->Email = $_POST['email'];
//$comment->ReplyId = $_POST['replyId'];
$comment->ProductId = $_POST['productId'];
$cds = new CommentDataSource();
$cds->open();
$cds->Insert($comment);
$cds->close();
header("Location:../Post.php?id=$comment->ProductId");
