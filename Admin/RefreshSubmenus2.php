<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<link href="select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#submenu").select2({
            placeholder: "زیر منو را انتخاب کنید...",
            dir: "rtl"
        });

        $("#submenu").change(function () {
            var submenu = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'RefreshTitles.php',
                data: {submenu: submenu},
                success: function (data) {
                    $('#title-td').html(data);
                }
            });
            $.ajax({
                type: 'POST',
                url: 'RefreshSuppergroups4.php',
                data: {submenu: submenu},
                success: function (data) {
                    $('#suppergroup-td').html(data);
                }
            });
        });
    });
</script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/SubMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/MainMenuDataSource.inc';
$mainmenu = new MainMenuDataSource();
$mainmenu ->open();
$m = $mainmenu->FindOneMainMenuBasedOnId($_POST['mainmenu']);
$mainmenu ->close();
$submenu = new SubMenuDataSource();
$submenu ->open();
$submenus = $submenu->getOneMainMenuSubMenus($_POST['mainmenu']);
$submenu ->close();
echo "<select ";
echo "class='width-80' required name='submenu' id='submenu' >";
echo "<option></option>";
if ($_POST['mainmenu'] != 0) {
    foreach ($submenus as $sb) {
        echo "<option value = '$sb->SubMenuId'";
        echo ">" . $sb->SubGroup->Name . "</option>";

    }
}
echo "</select>";
