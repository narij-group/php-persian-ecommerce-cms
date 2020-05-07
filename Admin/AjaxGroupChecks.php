<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
?>
    <script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.groupcheck').change(function () {
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: 'AjaxSubGroupChecks.php',
                        type: 'POST',
                        data: {
                            checkedgroupId: $(this).attr('value')
                        },
                        success: function (result) {
                            $('#product-subgroups').html(result);
                            $('#product-suppergroups').html('');
                            <?php
                            $_SESSION[SESSION_STRING_SELECTED_SUB_GROUPS] = "";
                            ?>

                        }
                    });
                }
                else {
                    $.ajax({
                        url: 'AjaxSubGroupChecks.php',
                        type: 'POST',
                        data: {
                            uncheckedgroupId: $(this).attr('value')
                        },
                        success: function (result) {
                            $('#product-subgroups').html(result);
                        }
                    });
                    $.ajax({
                        url: 'AjaxSupperGroupChecks.php',
                        type: 'POST',
                        data: {uncheckedgroupId: $(this).attr('value')},
                        success: function (result) {
                            $('#product-suppergroups').html(result);
                        }
                    });
                }
            });
        });
    </script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GroupDataSource.inc';

$group = new GroupDataSource();
$group->open();
$groups = $group->Fill();
$group->close();
$i = 0;
foreach ($groups as $g) {
    if (($i % 3) == 0) {
        echo '<br>';
    }
    ?>
    <div class="check-option"><label class="check-text"
                                     for="g<?php echo $g->GroupId; ?>"><?php echo $g->Name; ?></label>
        <div class='checkboxFour'><input class="groupcheck" type="checkbox"
                                         id="g<?php echo $g->GroupId; ?>" name="groupcheck_list[]"
                                         value="<?php echo $g->GroupId; ?>"/><label
                    for='g<?php echo $g->GroupId; ?>'></label></div>
    </div>
    <?php
    $i++;
}