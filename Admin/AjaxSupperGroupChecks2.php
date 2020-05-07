<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
session_start();
if (isset($_POST['checkedsubgroupId'])) {
    if (strpos($_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS], $_POST['checkedsubgroupId']) == FALSE) {
        $_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS] .= "," . $_POST['checkedsubgroupId'];
    }
} elseif (isset($_POST['uncheckedsubgroupId'])) {
    if (strpos($_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS], $_POST['uncheckedsubgroupId']) != FALSE) {
        $_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS] = str_replace("," . $_POST['uncheckedsubgroupId'], "", $_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS]);
    }
}
if (isset($_POST['uncheckedgroupId'])) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubGroupDataSource.inc';
    $subgroup = new SubGroupDataSource();
    $subgroup->open();
    $sbgs = $subgroup->FillByGroup($_POST['uncheckedgroupId']);
    $subgroup->close();
    foreach ($sbgs as $sbg) {
        $_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS] = str_replace($sbg->SubGroupId, "", $_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS]);
    }
}
$subgroupIds = array();
if (trim($_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS]) != "") {
    $subgroupIds = explode(",", $_SESSION[SESSION_STRING_P_P_SELECTED_SUB_GROUPS]);
    foreach ($subgroupIds as $sgid) {
        if (trim($sgid) != "") {
            $suppergroup = new SupperGroupDataSource();
            $suppergroup->open();
            $suppergroups = $suppergroup->FillBySubgroup($sgid);
            $suppergroup->close();
            $i = 0;
            foreach ($suppergroups as $sg) {

                if (($i % 5) == 0) {
                    echo '<br>';
                }
                ?>
                <div class="check-option"><label class="check-text"
                                                 for="psg<?php echo $sg->SupperGroupId; ?>"><?php echo $sg->Name; ?></label>
                    <div class='checkboxFour'><input class="ppsuppergroupcheck"
                                                     type="checkbox" id="psg<?php echo $sg->SupperGroupId; ?>"
                                                     name="subgroupcheck_list2[]"
                                                     value="<?php echo $sg->SupperGroupId; ?>"/><label
                                for='psg<?php echo $sg->SupperGroupId; ?>'></label>
                    </div>
                </div>

                <?php
                $i++;
            }
        }
    }
}
