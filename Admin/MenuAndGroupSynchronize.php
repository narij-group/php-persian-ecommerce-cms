<meta charset="utf-8"/>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/MainMenuDataSource.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SubMenuDataSource.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SupperMenuDataSource.inc";

require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/GroupDataSource.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SubGroupDataSource.inc";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../ClassesEx/datasource/SupperGroupDataSource.inc";

require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';


$group = new GroupDataSource();
$group->open();
$groups = $group->Fill();
$group->close();

$subgroup = new SubGroupDataSource();
$subgroup->open();
$subgroups = $subgroup->Fill();
$subgroup->close();

$suppergroup = new SupperGroupDataSource();
$suppergroup->open();
$suppergroups = $suppergroup->Fill();
$suppergroup->close();

$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->Fill();
$mainmenu->close();

$submenu = new SubMenuDataSource();
$submenu->open();
$submenus = $submenu->Fill();
$submenu->close();

$suppermenu = new SupperMenuDataSource();
$suppermenu->open();
$suppermenus = $suppermenu->Fill();
$suppermenu->close();

$menutitle = new MenuTitleDataSource();
$menutitle->open();
$menutitles = $menutitle->Fill();
$menutitle->close();


foreach ($groups as $gp) {
    $add = true;
    foreach ($mainmenus as $mnu) {
        if (trim($mnu->Group->GroupId) == trim($gp->GroupId)) {
            $add = false;
        }
    }

    if ($add == true) {

        $mds = new MainMenuDataSource();
        $mds->open();

        $m = new MainMenu();
        $m->Number = $mds->MaxNumber() + 1;
        if ($mds->MaxNumber() == null) {
            $m->Number = 1;
        }
        $m->Group = $gp->GroupId;
        $m->Disabled = 0;
        $mds->Insert($m);

        $mds->close();
    }

}

$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->Fill();
$mainmenu->close();

$submenu = new SubMenuDataSource();
$submenu->open();
$submenus = $submenu->Fill();
$submenu->close();


foreach ($subgroups as $sgp) {
    $add = true;
    foreach ($submenus as $smnu) {
        if (trim($smnu->SubGroup->SubGroupId) == trim($sgp->SubGroupId)) {
            $add = false;
        }
    }
    if ($add == true) {

        $smds = new SubMenuDataSource();
        $smds->open();

        $sm = new SubMenu();
        $sm->SubGroup = $sgp->SubGroupId;
        foreach ($mainmenus as $mnu) {
            if (trim($mnu->Group->GroupId) == trim($sgp->Group->GroupId)) {
                $sm->MainMenu = $mnu->MainMenuId;
            }
        }
        $sm->Number = $smds->MaxNumber() + 1;
        if ($smds->MaxNumber() == null) {
            $sm->Number = 1;
        }
        $sm->Image = '';
        $sm->Disabled = 0;
        $smds->Insert($sm);

        $smds->close();
    }

}


$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->Fill();
$mainmenu->close();

$submenu = new SubMenuDataSource();
$submenu->open();
$submenus = $submenu->Fill();
$submenu->close();

$suppermenu = new SupperMenuDataSource();
$suppermenu->open();
$suppermenus = $suppermenu->Fill();
$suppermenu->close();

foreach ($suppergroups as $ssgp) {
    $add = true;
    $addTitle = true;

    foreach ($suppermenus as $ssmnu) {
        if (trim($ssmnu->SupperGroup->SupperGroupId) == trim($ssgp->SupperGroupId)) {
            $add = false;
//            echo $ssmnu->SupperGroup->SupperGroupId . "(" . $ssmnu->SupperGroup->Name . ")" . " AND " . $ssgp->SupperGroupId . "(" . $ssgp->Name . ")";
//            echo "<br>";
        }
    }


    if ($add == true) {
//        echo $ssgp->SupperGroupId . "(" . $ssgp->Name . ")";
//        echo "<br>";
        $ssmds = new SupperMenuDataSource();
        $ssmds->open();

        $ssm = new SupperMenu();
        $ssm->SupperGroup = $ssgp->SupperGroupId;

        foreach ($mainmenus as $mnu) {
            if (trim($mnu->Group->GroupId) == trim($ssgp->Group->GroupId)) {
//                echo $mnu->Group->GroupId . "(" . $mnu->Group->Name . ")" . " AND " . $ssgp->Group->GroupId . "(" . $ssgp->Group->Name . ")";
//                echo "<br>";
                $ssm->MainMenu = $mnu->MainMenuId;
            }
        }

        foreach ($submenus as $smnu) {
            if (trim($smnu->SubGroup->SubGroupId) == trim($ssgp->SubGroup->SubGroupId)) {
                $ssm->SubMenu = $smnu->SubMenuId;
            }
        }

        foreach ($menutitles as $mnut) {
            if (trim($mnut->SubMenu->SubMenuId) == trim($ssm->SubMenu)) {
                $addTitle = false;
                $ssm->Title = $mnut->MenuTitleId;
//                echo $ssm->Title;
//                echo "<br>";
            }
        }


        if ($addTitle == true) {
            $menutitle = new MenuTitle();
            $menutitle->Name = $ssgp->SubGroup->Name;
            $menutitle->SubMenu = $ssm->SubMenu;
            $menutitle->Column = "1";

//        echo $menutitle->Name;
//        echo "<br>";
//        echo $menutitle->SubMenu;
//        echo "<br>";
//        echo $menutitle->Column;
//        echo "<br>";

            $mtds = new MenuTitleDataSource();
            $mtds->open();
            $ssm->Title = $mtds->Insert($menutitle);
            $mtds->close();
        }


//        echo $ssm->SupperGroup;
//        echo "<br>";
//        echo $ssm->MainMenu;
//        echo "<br>";
//        echo $ssm->SubMenu;
//        echo "<br>";
//        echo "Title: " . $ssm->Title;
//        echo "<br>";
//        echo "<br>";

        $ssmds->Insert($ssm);
        $ssmds->close();

    }

}

header('Location:SelectMenus.php');