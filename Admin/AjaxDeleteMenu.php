<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';

$menu = new MenuDataSource();
$menu->open();
$menu->Delete($_POST['menuId']);
$menus = $menu->GetMenusForOneProduct($_POST['Product']);
$menu->close();
foreach ($menus as $m) {
    echo "<div class='menuSample'>" . $m->MainMenu->Name . ">" . $m->SubMenu->SubMenuName . ">" . $m->SupperMenu->Name . "<a class='dltbtn'><img src='Template/Images/deleteHover.png' alt='' />$m->MenuId</a></div>";
}
?>
<script>
    $(document).ready(function () {
        $(".dltbtn").click(function () {
            if (confirm('آیا میخواهید این منو را حذف نمایید ؟')) {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxDeleteMenu.php',
                    data: {menuId: $(this).text(), Product:<?php echo $_POST['Product']; ?>},
                    success: function (data) {
                        $('#MenuSamples').html(data);
                    }
                });
            }
        });
    });
</script>