<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {

        $("#suppergroup").change(function () {
            $("#wait").css("display", "block");
            var suppergroup = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'ajaxSearch.php',
                data: {suppergroup: suppergroup},
                success: function (result) {
                    $("#db").html(result);
                    $("#wait").css("display", "none");
                }
            });
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
echo '<select id="suppergroup"  class="WideText" name="suppergroup">';
echo '<option value="0" >زیر زیر مجموعه...</option>';
foreach ($suppergroups as $g) {
    echo '<option ';
    echo ' value="' . $g->SupperGroupId . '" >';
    echo $g->Name;
    echo '</option>';
}
echo "</select>";
