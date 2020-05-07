<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuDataSource.inc';

$menu = new Menu();
$menu->Product = $_POST['Product'];
$menu->MainMenu = $_POST['MainMenu'];
$menu->SubMenu = $_POST['SubMenu'];
$menu->SupperMenu = $_POST['SupperMenu'];
if ($_POST['MainMenu'] != NULL && $_POST['SubMenu'] != NULL && $_POST['SupperMenu'] != NULL) {

    $muds = new MenuDataSource();
    $muds->open();
    $muds->Insert($menu);
    $menus = $muds->GetMenusForOneProduct($_POST['Product']);
    $muds->close();
    foreach ($menus as $m) {
        echo "<div class='menuSample'>" . $m->MainMenu->Name . ">" . $m->SubMenu->SubMenuName . ">" . $m->SupperMenu->Name . "<a class='dltbtn'><img src='Template/Images/deleteHover.png' alt='' />$m->MenuId</a></div>";
    }
} else {
    echo "<div class='warnSample'>تمام گزینه هارا انتخاب کنید!</div>";
    $muds = new MenuDataSource();
    $muds->open();
    $menus = $muds->GetMenusForOneProduct($_POST['Product']);
    $muds->close();
    foreach ($menus as $m) {
        echo "<div class='menuSample'>" . $m->MainMenu->Name . ">" . $m->SubMenu->SubMenuName . ">" . $m->SupperMenu->Name . "<a class='dltbtn'><img src='Template/Images/deleteHover.png' alt='' />$m->MenuId</a></div>";
    }
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