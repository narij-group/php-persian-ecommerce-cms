<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperGroupDataSource.inc';
$suppergroup = new SupperGroupDataSource();
$suppergroup->open();
$suppergroups = $suppergroup->FillByGroupAndSubgroup($_POST['group'], $_POST['subgroup']);
$suppergroup->close();
echo '<select id="suppergroup2"  class="WideText" name="suppergroup2">';
echo '<option value="0" >زیر زیر مجموعه...</option>';
if ($role->ProductGroupLimit) {
    foreach ($suppergroups as $g) {
        if (strpos($role->AllowedProductSupperGroups, $g->SupperGroupId) != false) {
            echo '<option ';
            echo ' value="' . $g->SupperGroupId . '" >';
            echo $g->Name;
            echo '</option>';
        }
    }
} else {
    foreach ($suppergroups as $g) {
        echo '<option ';
        echo ' value="' . $g->SupperGroupId . '" >';
        echo $g->Name;
        echo '</option>';
    }
}
echo "</select>";
