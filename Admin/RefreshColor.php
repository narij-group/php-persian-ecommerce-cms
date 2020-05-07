<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ColorListDataSource.inc';
$colorlist = new ColorListDataSource();
$colorlist->open();
$colorlists = $colorlist->Fill();
$colorlist->close();
echo '<option></option>';
foreach ($colorlists as $g) {
    echo "<option value = '$g->ColorListId'>" . $g->Name . "</option>";
}
