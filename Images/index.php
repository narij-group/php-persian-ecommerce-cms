<?php

$result = array("success" => $_FILES["file"]["name"] );
$file_path = $_REQUEST['product'] . "/". basename($_FILES['file']['name']);
if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
    $file_name = explode("/",$file_path);
    rename($file_path ,$file_name[0] . "/" . time() . $file_name[1]);
    $result = array("success" => " تصویر با موفقیت آپلود شد.");
} else{
    $result = array("success" => " آپلود فایل با مشکل همراه بود لطفا دوباره امتحان کنید.");
}
echo json_encode($result, JSON_PRETTY_PRINT);

?>