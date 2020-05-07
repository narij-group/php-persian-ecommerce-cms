<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#subgroup").select2({
            placeholder: "زیر منو را انتخاب کنید...",
            dir: "rtl"
        });
    });
</script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$m = $mainmenu->FindOneMainMenuBasedOnId($_POST['mainmenu']);
$mainmenu->close();

$subgroup = new SubGroupDataSource();
$subgroup->open();
$subgroups = $subgroup->FillByGroup($m->Group->GroupId);
$subgroup->close();
echo "<select ";
echo "class='form-control m-b' required name='subgroup' id='subgroup' style='width: 100%' >";
echo "<option></option>";
if ($_POST['mainmenu'] != 0) {
    foreach ($subgroups as $sg) {
        echo "<option value = '$sg->SubGroupId'";
        echo ">" . $sg->Name . "</option>";

    }
}
echo "</select>";

