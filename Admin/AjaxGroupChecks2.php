<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
?>
    <script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.ppgroupcheck').change(function () {
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: 'AjaxSubGroupChecks2.php',
                        type: 'POST',
                        data: {
                            checkedgroupId: $(this).attr('value')
                        },
                        success: function (result) {
                            $('#productproperty-subgroups').html(result);
                            $('#productproperty-suppergroups').html('');
                            <?php
                            $_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS] = "";
                            ?>

                        }
                    });
                }
                else {
                    $.ajax({
                        url: 'AjaxSubGroupChecks2.php',
                        type: 'POST',
                        data: {
                            uncheckedgroupId: $(this).attr('value')
                        },
                        success: function (result) {
                            $('#productproperty-subgroups').html(result);
                        }
                    });
                    $.ajax({
                        url: 'AjaxSupperGroupChecks2.php',
                        type: 'POST',
                        data: {uncheckedgroupId: $(this).attr('value')},
                        success: function (result) {
                            $('#productproperty-suppergroups').html(result);
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
                                     for="ppg<?php echo $g->GroupId; ?>"><?php echo $g->Name; ?></label>
        <div class='checkboxFour'><input class="ppgroupcheck" type="checkbox"
                                         id="ppg<?php echo $g->GroupId; ?>" name="ppgroupcheck_list[]"
                                         value="<?php echo $g->GroupId; ?>"/><label
                    for='ppg<?php echo $g->GroupId; ?>'></label></div>
    </div>
    <?php
    $i++;
}