<?php

require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeListDataSource.inc';

$guaranteelist = new GuaranteeListDataSource();
$guaranteelist->open();
$guaranteelists = $guaranteelist->Fill();
$guaranteelist->close();
echo '<option></option>';
foreach ($guaranteelists as $g) {
    echo "<option value = '$g->GuaranteeListId' >" . $g->Name . "-" . $g->Duration . ":" . $g->Price . " تومان  </option>";
}
