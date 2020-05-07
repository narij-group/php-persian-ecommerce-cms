<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<script>
    $("#subgroup2").change(function () {
        var subgroup = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'RefreshSuppergroups3.php',
            data: {subgroup: subgroup, group: <?php echo $_POST['group']; ?>},
            success: function (data) {
                $('#suppergroup-td2').html(data);
            }
        });
    });
</script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
$subgroup = new SubGroupDataSource();
$subgroup->open();
$subgroups = $subgroup->FillByGroup($_POST['group']);
$subgroup->close();
echo '<select id="subgroup2" name="subgroup2" class="form-control m-b" style="padding: 0">';
echo '<option value="0" >زیر مجموعه...</option>';
if ($_POST['group'] != 0) {
    if ($role->ProductGroupLimit) {
        foreach ($subgroups as $g) {
            if (strpos($role->AllowedProductSubGroups, $g->SubGroupId) != false) {
                echo '<option ';
                echo ' value="' . $g->SubGroupId . '" >';
                echo $g->Name;
                echo '</option>';
            }
        }
    } else {
        foreach ($subgroups as $g) {
            echo '<option ';
            echo ' value="' . $g->SubGroupId . '" >';
            echo $g->Name;
            echo '</option>';
        }
    }
}
echo "</select>";
