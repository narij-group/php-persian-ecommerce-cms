<link href="select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="select2/dist/js/select2.min.js"></script>
<?php
require_once 'Template/top2.php';
if ($_POST['container'] == "submenu") {
    ?>
    <script>
        $("#submenu").select2({
            placeholder: "زیر مجموعه را انتخاب کنید...",
            dir: "rtl"
        });
    </script>
    <?php
    echo '<select disabled class = "js-example-basic-single width-80" id="submenu" name="submenu">';
    echo '<option></option>';
    echo '</select>';
} elseif ($_POST['container'] == "suppermenu") {
    ?>
    <script>
       $("#suppermenu").select2({
        placeholder: "زیر زیر مجموعه را انتخاب کنید...",
        dir: "rtl"
    });
    </script>
    <?php
    echo '<select disabled class = "js-example-basic-single width-80" id="suppermenu" name="suppermenu">';
    echo '<option></option>';
    echo '</select>';
}

