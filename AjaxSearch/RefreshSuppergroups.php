<link href="Admin/select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="Admin/select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {

        $("#suppergroup").select2({
            placeholder: "زیر زیر مجموعه را انتخاب کنید...",
            dir: "rtl"
        });

    });
</script>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
$suppergroup = new SupperGroupDataSource();
$suppergroup->open();
$suppergroups = $suppergroup->FillByGroupAndSubgroup($_POST['group'], $_POST['subgroup']);
$suppergroup->close();
echo '<select required class = "js-example-basic-single width-80" id="suppergroup" name="suppergroup" style="width: 80%">';
echo '<option></option>';
foreach ($suppergroups as $g) {
    echo '<option ';
    echo ' value="' . $g->SupperGroupId . '" >';
    echo "( " . $g->Name . " ) " . $g->LatinName;
    echo '</option>';
}
echo "</select>";
