<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
$values = explode("-", $_POST['value']);
if ($values[0] == 'mainmenu') {
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/MainMenuDataSource.inc";
    $mainmenu = new MainMenuDataSource();
    $mainmenu->open();
    if ($values[1] == 'up' && $values[2] != 1) {
        $mnu = $mainmenu->FindByNum($values[2] - 1);
        $mnu2 = $mainmenu->FindByNum($values[2]);
        $mnu->Number = $values[2];
        $mnu2->Number = $values[2] - 1;
        $mainmenu->UpdateNum($mnu);
        $mainmenu->UpdateNum($mnu2);
    } elseif ($values[1] == 'down' && $values[2] != $mainmenu->MaxNumber()) {
        $mnu = $mainmenu->FindByNum($values[2] + 1);
        $mnu2 = $mainmenu->FindByNum($values[2]);
        $mnu->Number = $values[2];
        $mnu2->Number = $values[2] + 1;
        $mainmenu->UpdateNum($mnu);
        $mainmenu->UpdateNum($mnu2);
    }
    $mainmenus = $mainmenu->Fill();
//    $mainmenu->close();

    ?>
<thead>
<tr>
    <th class="up-down" data-sort-ignore="true"><img class="th-loader" src="Template/Images/gifs/loading.gif"/></th>
    <th>شناسه</th>
    <th>نام منو</th>
    <th data-hide="phone,tablet" data-sort-ignore="true"></th>
    <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
    <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
</tr>
</thead>
<tbody>
    <?php
    $postsCounter = 0;
    foreach ($mainmenus as $c) {
        $postsCounter++;
        echo "<tr>";
        echo "<td><div class='UP' ><a class='btn btn-success btn-circle' ";
        if ($c->Number == 1) {
            echo ' disabled ';
        }
        echo " ><i class='fa fa-arrow-up' style='font-size: 18px; padding-right: 5px'></i>mainmenu-up-$c->Number</a></div>";;


        echo "<div class='DOWN' ><a class='btn btn-success btn-circle' ";
        if ($c->Number == $mainmenu->MaxNumber()) {
            echo ' disabled ';
        }
        echo " ><i class='fa fa-arrow-down' style='font-size: 18px; padding-right: 5px'></i>mainmenu-down-$c->Number</a></div></td>";
        echo "<td><div class='DatabaseField' >" . $c->MainMenuId . "</div></td>";
        echo "<td><div class='DatabaseField' >" . $c->Group->Name . "</div></td>";
        echo "<td><div class='DatabaseField' ><a href='SwitchMainMenu.php?id=" . $c->MainMenuId . "'>";
        if ($c->Disabled == 0) {
            echo "<i title='فعال' class='fa fa-check text-navy'></i>";
        } else {
            echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
        }
        echo "</a></div></td>";
        echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='MainMenu.php?id=" . $c->MainMenuId . "'>" . "ویرایش" . "</a></button></td>";
        echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='DeleteMainMenu.php?id=" . $c->MainMenuId . "'>" . "حذف" . "</a></button></td>";
        echo "</tr>";
    }
    ?>
</tbody>
    <!--                        <tfoot  style="direction: ltr">-->
    <!--                        <tr>-->
    <!--                            <td colspan="5">-->
    <!--                                <ul class="pagination pull-right"></ul>-->
    <!--                            </td>-->
    <!--                        </tr>-->
    <!--                        </tfoot>-->
    <?php

}
if ($values[0] == 'submenu') {
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SubMenuDataSource.inc";
    $submenu = new SubMenuDataSource();
    $submenu->open();
    if ($values[1] == 'up' && $values[2] != 1) {
        $smnu = $submenu->FindByNum($values[2] - 1);
        $smnu2 = $submenu->FindByNum($values[2]);
        $smnu->Number = $values[2];
        $smnu2->Number = $values[2] - 1;
        $submenu->UpdateNum($smnu);
        $submenu->UpdateNum($smnu2);
    } elseif ($values[1] == 'down' && $values[2] != $submenu->MaxNumber()) {
        $smnu = $submenu->FindByNum($values[2] + 1);
        $smnu2 = $submenu->FindByNum($values[2]);
        $smnu->Number = $values[2];
        $smnu2->Number = $values[2] + 1;
        $submenu->UpdateNum($smnu);
        $submenu->UpdateNum($smnu2);
    }
    $submenus = $submenu->Fill();
//    $submenu->close();
    ?>
<table id="td" class="footable table table-stripped" data-page-size="1000000000"
       data-filter=#filter>
    <thead>
    <tr>
        <th class="up-down" data-sort-ignore="true"><img class="th-loader" src="Template/Images/gifs/loading.gif"/></th>
        <th>شناسه</th>
        <th>منو اصلی</th>
        <th data-hide="phone,tablet">نام زیر منو</th>
        <th data-hide="phone,tablet" data-sort-ignore="true">تصویر</th>
        <th data-hide="phone,tablet" data-sort-ignore="true"></th>
        <th id="th1" data-hide="phone,tablet" data-sort-ignore="true"></th>
        <th id="th2" data-hide="phone,tablet" data-sort-ignore="true"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $postsCounter = 0;
    require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/MainMenuDataSource.inc";
    $mainmenu = new MainMenuDataSource();
    $mainmenu->open();
    foreach ($submenus as $c) {
        $postsCounter++;
        $m = $mainmenu->FindOneMainMenuBasedOnId($c->MainMenu->MainMenuId);
        echo "<tr>";
        echo "<td><div class='UP' ><a class='btn btn-success btn-circle' ";
        if ($c->Number == 1) {
            echo ' disabled ';
        }
        echo " ><i class='fa fa-arrow-up' style='font-size: 18px; padding-right: 5px'></i>submenu-up-$c->Number</a></div>";


        echo "<div class='DOWN' ><a class='btn btn-success btn-circle' ";
        if ($c->Number == $submenu->MaxNumber()) {
            echo ' disabled ';
        }
        echo " ><i class='fa fa-arrow-down' style='font-size: 18px; padding-right: 5px'></i>submenu-down-$c->Number</a></div></td>";
        echo "<td><div class='DatabaseField' >" . $c->SubMenuId . "</div></td>";
        echo "<td><div class='DatabaseField' >" . $m->Group->Name . "</div></td>";
        echo "<td><div class='DatabaseField' >" . $c->SubGroup->Name . "</div></td>";
        echo "<td><div class='DatabaseField' ><img src='";
        if ($c->Image == "Click here to select a file") {
            echo '';
        } else {
            echo "../$c->Image";
        }
        echo "' /></div></td>";
        echo "<td><div class='DatabaseField' ><a href='SwitchSubMenu.php?id=" . $c->SubMenuId . "'>";
        if ($c->Disabled == 0) {
            echo "<i title='فعال' class='fa fa-check text-navy'></i>";
        } else {
            echo "<i title='غیرفعال' class='fa fa-remove text-danger'></i>";
        }
        echo "</a></div></td>";
        echo "<td><button class='btn-white btn btn-sm m-xs' title='Edit'><a href='SubMenu.php?id=" . $c->SubMenuId . "'>" . "ویرایش" . "</a></button></td>";
        echo "<td><button class='btn-white btn btn-sm m-xs' title='Delete'><a onclick='return deleteConfirm()' href='operateSubMenu.php?id=" . $c->SubMenuId . "'>" . "حذف" . "</a></button></td>";
        echo "</tr>";
    }
    ?>
</tbody>
    <!--                        <tfoot  style="direction: ltr">-->
    <!--                        <tr>-->
    <!--                            <td colspan="5">-->
    <!--                                <ul class="pagination pull-right"></ul>-->
    <!--                            </td>-->
    <!--                        </tr>-->
    <!--                        </tfoot>-->
    <?php


    $mainmenu->close();
    $submenu->close();
}
?>
<script>
    $(document).ready(function () {
        $(".UP,.DOWN").click(function () {
            $('.th-loader').fadeIn(0);
            $.ajax({
                type: 'POST',
                url: 'AjaxMoveMenu.php',
                data: {value: $(this).text()},
                success: function (data) {
                    $('#td').html(data);
                    $('.th-loader').fadeOut(0);
                }
            });
        });
    });
</script>