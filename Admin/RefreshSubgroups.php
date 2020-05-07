<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {

        $("#subgroup").select2({
            placeholder: "زیر مجموعه را انتخاب کنید...",
            dir: "rtl"
        });

        $("#subgroup").change(function () {
            $('#loader3').fadeIn(0);
            var subgroup = $(this).val();
//            $.ajax({
//                url: 'AjaxEnablePropertiesBox.php',
//                type: 'POST',
//                data: {subgroup: subgroup},
//                success: function(data) {
//                    $('#properties').html(data);
//                }
//            });
            $.ajax({
                type: 'POST',
                url: 'RefreshSuppergroups.php',
                data: {group: <?php echo $_POST['group']; ?> , subgroup: subgroup},
                success: function (data) {
                    $('#suppergroup-td').html(data);
                    $('#loader3').fadeOut(0);
                }
            });
            if ($('#syncer').is(':checked')) {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxSyncMenu.php',
                    data: {submenu: subgroup},
                    success: function (data) {
                        $('#submenu-td').html(data);
                    }
                });
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
echo '<select required class = "js-example-basic-single width-80" id="subgroup" name="subgroup">';
echo '<option></option>';
if ($role->ProductGroupLimit) {
    foreach ($subgroups as $g) {
        if (strpos($role->AllowedProductSubGroups, $g->SubGroupId) != false) {
            echo '<option ';
            echo ' value="' . $g->SubGroupId . '" >';
            echo "( " . $g->Name . " ) " . $g->LatinName;
            echo '</option>';
        }
    }
} else {
    foreach ($subgroups as $g) {
        echo '<option ';
        echo ' value="' . $g->SubGroupId . '" >';
        echo "( " . $g->Name . " ) " . $g->LatinName;
        echo '</option>';
    }
}
echo "</select>";
