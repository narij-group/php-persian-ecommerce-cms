<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
$word = explode(",", $_POST['value']);
$words = 0;
foreach ($word as $w) {
    $words++;
}
if (trim($_POST['value']) == "") {
    $words = 0;
}
?>

<style>
    .meta-status3 {
        background-color: #222;
        border: 3px solid #000;
    <?php
    if ($words < 5) {
        echo 'border-color: #ff4747;';
    } elseif ($words >= 5 && $words < 15) {
        echo 'border-color: #e3c856;';
    } else {
        echo 'border-color: #39b54a;';
    }
    ?> width: auto;
        height: 35px;
        line-height: 35px;
        border-radius: 40px;
        padding: 0 5px;
        text-align: left;
        margin-left: 280px;
        margin-bottom: 5px;
        float: left;

    }

    .meta-status3 span {
        float: left;
        margin-right: 10px;
    <?php
    if ($words < 5) {
        echo 'color: #ff4747;';
    } elseif ($words >= 5 && $words < 15) {
        echo 'color: #e3c856;';
    } else {
        echo 'color: #39b54a;';
    }
    ?>
    }

    .black-circle3 {
        width: 25px;
        height: 25px;
        margin-top: 5px;
    <?php
    if ($words < 5) {
        echo 'background-color: #ff4747;';
    } elseif ($words >= 5 && $words < 15) {
        echo 'background-color: #e3c856;';
    } else {
        echo 'background-color: #39b54a;';
    }
    ?> border-radius: 30px;
        float: right;
    }
</style>

<?php
if ($words < 5) {
    ?>
    <span class="label label-danger"><?php echo $words; ?><b>/20</b></span>
    <?php
} elseif ($words >= 5 && $words < 15) {
    ?>
    <span class="label label-warning"><?php echo $words; ?><b>/20</b></span>
    <?php
} else {
    ?>
    <span class="label label-primary"><?php echo $words; ?><b>/20</b></span>
    <?php
}
?>
<!--<div class="meta-status3"><div class="black-circle3"></div><span>--><?php //echo $words; ?><!--<b>/20</b></span></div>-->

