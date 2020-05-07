<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<script>
    $("#subgroup").change(function() {
        $("#wait").css("display", "block");
        var subgroup = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajaxSearch.php',
            data: {subgroup: subgroup},
            success: function(result) {
                $("#db").html(result);
                $("#wait").css("display", "none");
            }
        });
        $.ajax({
            type: 'POST',
            url: 'RefreshSuppergroups2.php',
            data: {subgroup: subgroup , group : <?php echo $_POST['group']; ?>},
            success: function(data) {
                $('#suppergroup-td').html(data);                
            }
        });
    });
</script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/SubGroupDataSource.inc';
$subgroup = new SubGroupDataSource();
$subgroup ->open();
$subgroups = $subgroup->FillByGroup($_POST['group']);
$subgroup ->close();
echo '<select id="subgroup" class="form-control m-b" name="subgroup">';
echo '<option value="0" >زیر مجموعه...</option>';
if ($_POST['group'] != 0) {
    foreach ($subgroups as $g) {
        echo '<option ';
        echo ' value="' . $g->SubGroupId . '" >';
        echo $g->Name;
        echo '</option>';
    }
}
echo "</select>";
echo '<img  id="loader2" style="display: none; float: left; margin-top: 5px;" src="Template/Images/gifs/loading.gif" width="40" height="40" />';
