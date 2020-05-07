<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script>
    $("#suppermenu").select2({
        placeholder: "زیر زیر منو را انتخاب کنید...",
        dir: "rtl"
    });
    $("#suppermenu").change(function () {
        $("#btnAddMenu").removeAttr("disabled", "");
    });
</script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';
$suppermenu = new SupperMenuDataSource();
$suppermenu->open();
$suppermenus = $suppermenu->getOneSubMenuSupperMenus($_POST['submenu']);
$suppermenu->close();
echo '<select class = "js-example-basic-single width-80" id="suppermenu" name="suppermenu">';
echo '<option></option>';
foreach ($suppermenus as $g) {
    echo '<option ';
    echo ' value=' . $g->SupperMenuId . '>';
    echo $g->Name;
    echo '</option>';
}
echo '</select>';
