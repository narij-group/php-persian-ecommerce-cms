<?php


require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/NewsDataSource.inc";
$nds = new NewsDataSource();
$nds->open();


$new = new News();

$new->Title = $_POST['newstitle'];
$new->MetaDescription = $_POST['metadescription'];
$new->Keywords = $_POST['keywords'];
$new->User = $_POST['user'];
$new->Status = $_POST['status'];

//$_POST['content'] = str_replace('<p>', '', $_POST['content']);
if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
    $_POST['content'] = str_replace('/DigitalShopV1/', '', $_POST['content']);
    $_POST['content'] = str_replace('../', '', $_POST['content']);
} else {
    $_POST['content'] = str_replace('http://', '', $_POST['content']);
}
//$_POST['content'] = str_replace('</p>', '', $_POST['content']);
$new->Content = $nds->mres($_POST['content']);
$_POST['image'] = str_replace('/DigitalShopV1/News', 'News', $_POST['image']);
$new->Image = $_POST['image'];
$new->Summary = $_POST['summary'];


$nds->Insert($new);
$nds->close();


header('Location:News.php');