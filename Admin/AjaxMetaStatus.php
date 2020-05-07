<style>
    .meta-status2 {
        background-color: #222;
        border: 3px solid #000;
    <?php
    if ($_POST['chars'] < 80) {
        echo 'border-color: #ff4747;';
    } elseif ($_POST['chars'] >= 80 && $_POST['chars'] < 135) {
        echo 'border-color: #e3c856;';
    } elseif ($_POST['chars'] >= 135 && $_POST['chars'] <= 165) {
        echo 'border-color: #39b54a;';
    } else {
        echo 'border-color: #e3c856;';
    }
    ?> width: auto;
        height: 35px;
        line-height: 35px;
        border-radius: 40px;
        padding: 0 5px;
        text-align: left;
        margin-left: 260px;
        margin-bottom: 5px;
        float: left;

    }

    .meta-status2 span {
        float: left;
        margin-right: 10px;
    <?php
    if ($_POST['chars'] < 80) {
        echo 'color: #ff4747;';
    } elseif ($_POST['chars'] >= 80 && $_POST['chars'] < 135) {
        echo 'color: #e3c856;';
    } elseif ($_POST['chars'] >= 135 && $_POST['chars'] <= 165) {
        echo 'color: #39b54a;';
    } else {
        echo 'color: #e3c856;';
    }
    ?>
    }

    .black-circle2 {
        width: 25px;
        height: 25px;
        margin-top: 5px;
    <?php
    if ($_POST['chars'] < 80) {
        echo 'background-color: #ff4747;';
    } elseif ($_POST['chars'] >= 80 && $_POST['chars'] < 135) {
        echo 'background-color: #e3c856;';
    } elseif ($_POST['chars'] >= 135 && $_POST['chars'] <= 165) {
        echo 'background-color: #39b54a;';
    } else {
        echo 'background-color: #e3c856;';
    }
    ?> border-radius: 30px;
        float: right;
    }
</style>

<?php
if ($_POST['chars'] < 80) {
    ?>
    <span class="label label-danger"><?php echo $_POST['chars']; ?><b>/165</b></span>
    <?php
} elseif ($_POST['chars'] >= 80 && $_POST['chars'] < 135) {
    ?>
    <span class="label label-warning"><?php echo $_POST['chars']; ?><b>/165</b></span>
    <?php
} else {
    ?>
    <span class="label label-primary"><?php echo $_POST['chars']; ?><b>/165</b></span>
    <?php
}
?>
<!--<div class="meta-status2"><div class="black-circle2"></div><span>--><?php //echo $_POST['chars']; ?><!--<b>/165</b></span></div>-->

