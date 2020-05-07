<link href="Admin/select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="Admin/select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {

        $("#subgroup").select2({
            placeholder: "زیر مجموعه را انتخاب کنید...",
            dir: "rtl"
        });

        $("#subgroup").change(function () {
            var subgroup = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'AjaxSearch/RefreshSuppergroups.php',
                data: {group: <?php echo $_POST['group']; ?> , subgroup: subgroup},
                success: function (data) {
                    $('#suppergroup-td').html(data);
                }
            });
        });
    });
</script>

<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
$subgroup = new SubGroupDataSource();
$subgroup->open();
$subgroups = $subgroup->FillByGroup($_POST['group']);
$subgroup->close();
echo '<select required class = "js-example-basic-single" id="subgroup" name="subgroup" style="width: 80%">';
echo '<option></option>';
foreach ($subgroups as $g) {
    echo '<option ';
    echo ' value="' . $g->SubGroupId . '" >';
    echo "( " . $g->Name . " ) " . $g->LatinName;
    echo '</option>';
}
echo "</select>";
