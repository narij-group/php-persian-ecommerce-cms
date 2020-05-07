<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
?>
    <script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.ppsubgroupcheck').change(function () {
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: 'AjaxSupperGroupChecks2.php',
                        type: 'POST',
                        data: {checkedsubgroupId: $(this).attr('value')},
                        success: function (result) {
                            $('#productproperty-suppergroups').html(result);
                        }
                    });
                }
                else {
                    $.ajax({
                        url: 'AjaxSupperGroupChecks2.php',
                        type: 'POST',
                        data: {uncheckedsubgroupId: $(this).attr('value')},
                        success: function (result) {
                            $('#productproperty-suppergroups').html(result);
                        }
                    });
                }
            });
        });
    </script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
session_start();
if (isset($_POST['checkedgroupId'])) {
    if (strpos($_SESSION[SESSION_STRING_P_P_SELECTED_GROUPS], $_POST['checkedgroupId']) == FALSE) {
        $_SESSION[SESSION_STRING_P_P_SELECTED_GROUPS] .= "," . $_POST['checkedgroupId'];
    }
} elseif (isset($_POST['uncheckedgroupId'])) {
    if (strpos($_SESSION[SESSION_STRING_P_P_SELECTED_GROUPS], $_POST['uncheckedgroupId']) != FALSE) {
        $_SESSION[SESSION_STRING_P_P_SELECTED_GROUPS] = str_replace("," . $_POST['uncheckedgroupId'], "", $_SESSION[SESSION_STRING_P_P_SELECTED_GROUPS]);
    }
}
$groupIds = array();
if (trim($_SESSION[SESSION_STRING_P_P_SELECTED_GROUPS]) != "") {
    $groupIds = explode(",", $_SESSION[SESSION_STRING_P_P_SELECTED_GROUPS]);
    foreach ($groupIds as $gid) {
        if (trim($gid) != "") {
            $subgroup = new SubGroupDataSource();
            $subgroup->open();
            $subgroups = $subgroup->FillByGroup($gid);
            $subgroup->close();
            $i = 0;
            foreach ($subgroups as $sg) {
                if (($i % 3) == 0) {
                    echo '<br>';
                }
                ?>
                <div class="check-option"><label class="check-text"
                                                 for="ppsg<?php echo $sg->SubGroupId; ?>"><?php echo $sg->Name; ?></label>
                    <div class='checkboxFour'><input class="ppsubgroupcheck" type="checkbox"
                                                     id="ppsg<?php echo $sg->SubGroupId; ?>"
                                                     name="ppsubgroupcheck_list[]"
                                                     value="<?php echo $sg->SubGroupId; ?>"/><label
                                for='ppsg<?php echo $sg->SubGroupId; ?>'></label></div>
                </div>
                <?php
                $i++;
            }
        }
    }
}

