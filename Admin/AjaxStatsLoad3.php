<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/StatDataSource.inc';
$stat = new StatDataSource();
$stat->open();
?>
    <td class='DatabaseField2' style="display: inline-block;padding: 0;">
        <?php
        echo $stat->theMostVisitorDay() . " نفر";
        ?>
    </td>
<?php
$stat->close();
?>
