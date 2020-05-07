<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->Fill();
$mainmenu->close();
echo '<option></option>';
foreach ($mainmenus as $g) {
    echo "<option value = '$g->MainMenuId'>" . $g->Name . "</option>";
}
