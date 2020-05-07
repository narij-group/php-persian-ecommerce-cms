<link href="select2/dist/css/select2.min.css" rel="stylesheet"/>
<script src="select2/dist/js/select2.min.js"></script>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
if (isset($_POST['mainmenu'])) {
    ?>
    <script>
        $("#mainmenu").select2({
            placeholder: "منو اصلی را انتخاب کنید...",
            dir: "rtl"
        });
        $("#mainmenu").change(function () {
            $("#btnAddMenu").attr("disabled", "");
            $('#loader2').fadeIn(0);
            var mainmenu = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'RefreshSubmenus.php',
                data: {mainmenu: mainmenu},
                success: function (data) {
                    $('#submenu-td').html(data);
                    $('#suppermenu').html("<option></option>");
                    $('#loader2').fadeOut(0);
                }
            });
        });
    </script>
    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/GroupDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/MainMenuDataSource.inc";

    $gp = new GroupDataSource();
    $gp->open();
    $gpp = $gp->FindOneGroupBasedOnId($_POST['mainmenu']);
    $gp->close();

    $mnu = new MainMenuDataSource();
    $mnu->open();
    $mainmenus = $mnu->Fill();
    $mnu->close();

    ?>
    <select class="js-example-basic-single width-80" id="mainmenu" disabled name="mainmenu">
        <option></option>
        <?php
        foreach ($mainmenus as $g) {
            echo "<option value = '$g->MainMenuId' ";
            if (trim($g->Name) == trim($gpp->Name)) {
                echo ' selected ';
            }
            echo " >" . $g->Name . "</option>";
        }
        ?>
    </select>
    <?php
}
?>


<?php
if (isset($_POST['submenu'])) {
    ?>
    <script>
        $("#submenu").select2({
            placeholder: "زیر منو را انتخاب کنید...",
            dir: "rtl"
        });
    </script>
    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SubGroupDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SubMenuDataSource.inc";
    $sgp = new SubGroupDataSource();
    $sgp->open();
    $sgpp = $sgp->FindOneSubGroupBasedOnId($_POST['submenu']);
    $sgp->close();

    $smnu = new SubMenuDataSource();
    $smnu->open();
    $submenus = $smnu->Fill();
    $smnu->close();
    ?>
    <select class="js-example-basic-single width-80" id="submenu" disabled name="submenu">
        <option></option>
        <?php
        foreach ($submenus as $sg) {
            echo "<option value = '$sg->SubMenuId' ";
            if (trim($sg->Name) == trim($sgpp->Name)) {
                echo ' selected ';
            }
            echo " >" . $sg->Name . "</option>";
        }
        ?>
    </select>
    <?php
}
?>

<?php
if (isset($_POST['suppermenu'])) {
    ?>
    <script>
        $("#suppermenu").select2({
            placeholder: "زیر منو را انتخاب کنید...",
            dir: "rtl"
        });
    </script>
    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SupperGroupDataSource.inc";
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SupperMenuDataSource.inc";
    $sgp = new SupperGroupDataSource();
    $sgp->open();
    $sgpp = $sgp->FindOneSupperGroupBasedOnId($_POST['suppermenu']);
    $sgp->close();

    $smnu = new SupperMenuDataSource();
    $smnu->open();
    $suppermenus = $smnu->Fill();
    $smnu->close();
    ?>
    <select class="js-example-basic-single width-80" id="suppermenu" disabled name="suppermenu">
        <option></option>
        <?php
        foreach ($suppermenus as $sg) {
            echo "<option value = '$sg->SupperMenuId' ";
            if (trim($sg->Name) == trim($sgpp->Name)) {
                echo ' selected ';
            }
            echo " >" . $sg->Name . "</option>";
        }
        ?>
    </select>
    <?php
}
?>
