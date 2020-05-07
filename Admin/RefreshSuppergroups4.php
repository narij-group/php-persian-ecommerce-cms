<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#suppergroup").select2({
            placeholder: "زیر زیرمنو را انتخاب کنید...",
            dir: "rtl"
        });
    });
</script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
$submenu = new SubMenuDataSource();
$submenu->open();
$m = $submenu->FindOneSubMenuBasedOnId($_POST['submenu']);
$submenu->close();
$suppergroup = new SupperGroupDataSource();
$suppergroup->open();
$suppergroups = $suppergroup->FillBySubgroup($m->SubGroup->SubGroupId);
$suppergroup->close();
echo "<select ";
echo "class='width-80' required name='suppergroup' id='suppergroup' >";
echo "<option></option>";
//echo "<option value='0' >ندارد</option>";
if ($_POST['submenu'] != 0) {
    foreach ($suppergroups as $sg) {
        echo "<option value = '$sg->SupperGroupId'";
        echo ">" . $sg->Name . "</option>";
    }
}
echo "</select>";
