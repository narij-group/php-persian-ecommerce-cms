<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>
<script>
    $("#submenu").select2({
        placeholder: "زیر منو را انتخاب کنید...",
        dir: "rtl"
    });
    $("#submenu").change(function () {
        var submenu = $(this).val();
        $('#loader3').fadeIn(0);
        $.ajax({
            type: 'POST',
            url: 'RefreshSuppermenus.php',
            data: {submenu: submenu},
            success: function (data) {
                $('#suppermenu-td').html(data);
                $('#loader3').fadeOut(0);
            }
        });
    });
    $("#suppermenu").change(function () {
        $("#btnAddMenu").removeAttr("disabled", "");
    });
</script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
$submenu = new SubMenuDataSource();
$submenu->open();
$submenus = $submenu->getOneMainMenuSubMenus($_POST['mainmenu']);
$submenu->close();
echo '<select class = "js-example-basic-single width-80" id="submenu" name="submenu">';
echo '<option></option>';
foreach ($submenus as $g) {
    echo '<option ';
    echo ' value=' . $g->SubMenuId . '>';
    echo $g->Name;
    echo '</option>';
}
echo "</select>";
