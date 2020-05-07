<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CommentDataSource.inc';

require_once '../Template/CustomeDate/jdatetime.class.php';
$comment = new Comment();
$comment->Customer = $_POST['customer'];
$comment->Value = nl2br($_POST['value']);
$comment->Email = $_POST['email'];
$date = new jDateTime(true, true, 'Asia/Tehran');
$comment->Date = $date->date("l j F Y");
if (isset($_POST['commentId'])) {
    $comment->ReplyId = $_POST['commentId'];
}
$comment->ProductId = $_POST['productId'];
setcookie(COOKIE_MESSAGE_2, 'CSuccess()', time() + 15, '/');

$cds = new CommentDataSource();
$cds->open();
$cds->Insert($comment);
$cds->close();
header("Location:../Post.php?id=$comment->ProductId");
