<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#title").select2({
            placeholder: "عنوان را انتخاب کنید...",
            dir: "rtl"
        });
    });
</script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/MenuTitleDataSource.inc';

$title = new MenuTitleDataSource();
$title ->open();
$titles = $title->getOneSubMenuTitles($_POST['submenu']);
$title ->close();
echo "<select ";
echo "class='width-80' required name='title' id='title' >";
echo "<option></option>";
if ($_POST['submenu'] != 0 && $title != null) {
    foreach ($titles as $sg) {
        echo "<option value = '$sg->MenuTitleId'";
        echo ">" . $sg->Name . "</option>";
    }
}
echo "</select>";
