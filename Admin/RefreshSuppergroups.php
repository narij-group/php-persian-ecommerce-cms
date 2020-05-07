<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {

        $("#suppergroup").select2({
            placeholder: "زیر زیر مجموعه را انتخاب کنید...",
            dir: "rtl"
        });

        $("#suppergroup").change(function () {
            var suppergroup = $(this).val();

            $.ajax({
                url: 'AjaxEnablePropertiesBox.php',
                type: 'POST',
                data: {suppergroup: suppergroup},
                success: function (data) {
                    $('#properties').html(data);
                }
            });
            if ($('#syncer').is(':checked')) {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSyncMenu.php',
                    data: {suppermenu: suppergroup},
                    success: function (data) {
                        $('#suppermenu-td').html(data);
                        $("#btnAddMenu").removeAttr("disabled", "");
                    }
                });
            }
        });

    });
</script>

<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
$suppergroup = new SupperGroupDataSource();
$suppergroup->open();
$suppergroups = $suppergroup->FillByGroupAndSubgroup($_POST['group'], $_POST['subgroup']);
$suppergroup->close();
echo '<select required class = "js-example-basic-single width-80" id="suppergroup" name="suppergroup">';
echo '<option></option>';
if ($role->ProductGroupLimit) {
    foreach ($suppergroups as $g) {
        if (strpos($role->AllowedProductSupperGroups, $g->SupperGroupId) != false) {
            echo '<option ';
            echo ' value="' . $g->SupperGroupId . '" >';
            echo "( " . $g->Name . " ) " . $g->LatinName;
            echo '</option>';
        }
    }
} else {
    foreach ($suppergroups as $g) {
        echo '<option ';
        echo ' value="' . $g->SupperGroupId . '" >';
        echo "( " . $g->Name . " ) " . $g->LatinName;
        echo '</option>';
    }
}
echo "</select>";
