<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductDataSource.inc';

$pds = new ProductDataSource();
$pds->open();
//$product = new Product();
//$product->User = time();
$id = $pds->InsertBlank();
$pds->close();

//-----------Update JSON------------------
if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'localhost') !== false) {
    $route = "/DigitalShopV1/PostImages/";
} else {
    $route = "/PostImages/";
}
$file_path = "fileman2/conf.json";
$current = file_get_contents($file_path);
$data_to_write = '
{
"FILES_ROOT":          "' . $route . '",
"RETURN_URL_PREFIX":   "",
"SESSION_PATH_KEY":    "' . $route . '",
"THUMBS_VIEW_WIDTH":   "140",
"THUMBS_VIEW_HEIGHT":  "120",
"PREVIEW_THUMB_WIDTH": "100",
"PREVIEW_THUMB_HEIGHT":"100",
"MAX_IMAGE_WIDTH":     "4000",
"MAX_IMAGE_HEIGHT":    "4000",
"INTEGRATION":         "custom",
"DIRLIST":             "php/dirtree.php",
"CREATEDIR":           "php/createdir.php",
"DELETEDIR":           "php/deletedir.php",
"MOVEDIR":             "php/movedir.php",
"COPYDIR":             "php/copydir.php",
"RENAMEDIR":           "php/renamedir.php",
"FILESLIST":           "php/fileslist.php",
"UPLOAD":              "php/upload.php",
"DOWNLOAD":            "php/download.php",
"DOWNLOADDIR":         "php/downloaddir.php",
"DELETEFILE":          "php/deletefile.php",
"MOVEFILE":            "php/movefile.php",
"COPYFILE":            "php/copyfile.php",
"RENAMEFILE":          "php/renamefile.php",
"GENERATETHUMB":       "php/thumb.php",
"DEFAULTVIEW":         "list",
"FORBIDDEN_UPLOADS":   "zip js jsp jsb mhtml mht xhtml xht php phtml php3 php4 php5 phps shtml jhtml pl sh py cgi exe application gadget hta cpl msc jar vb jse ws wsf wsc wsh ps1 ps2 psc1 psc2 msh msh1 msh2 inf reg scf msp scr dll msi vbs bat com pif cmd vxd cpl htpasswd htaccess",
"ALLOWED_UPLOADS":     "",
"FILEPERMISSIONS":     "0644",
"DIRPERMISSIONS":      "0755",
"LANG":                "auto",
"DATEFORMAT":          "dd/MM/yyyy HH:mm",
"OPEN_LAST_DIR":       "yes"
}';
file_put_contents($file_path, $data_to_write);
//-----------Update JSON------------------

if (file_exists("../Images/$id") == false) {
    mkdir("../Images/$id");
}
header('Location:Product.php?newid=' . $id);
