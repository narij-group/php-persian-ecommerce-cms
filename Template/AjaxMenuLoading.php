<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MainMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SubMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SupperMenuDataSource.inc';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/MenuTitleDataSource.inc';


$mainmenu = new MainMenuDataSource();
$mainmenu->open();
$mainmenus = $mainmenu->CFill();
$mainmenu->close();


$suppermenu = new SupperMenuDataSource();
$suppermenu->open();
$menutitle = new MenuTitleDataSource();
$menutitle->open();

?>
<nav class="navigation">
    <ul class="root" id="menu">
        <?php
        foreach ($mainmenus as $mm) {
            ?>
            <li>
                <a href="#"><span class="fa fa-chevron-down"></span><?php echo $mm->Group->Name; ?></a>
                <div class="second-level box-shadow">
                    <ul>
                        <?php
                        $submenu = new SubMenuDataSource();
                        $submenu->open();
                        //                        $submenu->MainMenu = $mm->MainMenuId;
                        $submenus = $submenu->getOneMainMenuSubMenus($mm->MainMenuId);
                        $submenu->close();
                        foreach ($submenus as $sm) {
                            ?>
                            <li>
<!--                                <a href="Products.php?sbgroup=--><?php //echo $sm->SubGroup->SubGroupId; ?><!--">-->
                                <a href="#">
                                    <?php echo $sm->SubGroup->Name; ?>
                                    <span class="caret-top"></span>
                                </a>
                                <?php
                                $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
                                $menutitles = $menutitle->getOneSubMenuTitles($sm->SubMenuId);
                                $suppermenu2 = new SupperMenuDataSource();
                                $suppermenu2->open();
                                foreach ($menutitles as $mt) {
                                    $supmnus = $suppermenu2->getSupperMenusOfThisTitleC1($mt->MenuTitleId);
                                    if ($supmnus != null) {
                                        foreach ($supmnus as $spm) {
                                            ?>
                                            <div class="third-level box-shadow2">
                                                <?php
                                                $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
                                                $menutitles = $menutitle->getOneSubMenuTitlesC1($sm->SubMenuId);
                                               // $suppermenu2 = new SupperMenuDataSource();
                                               // $suppermenu2->open();
                                                ?>
                                                <div class="column">
                                                    <?php
                                                    foreach ($menutitles as $mt) {
                                                        ?>
                                                        <div class="itemcontainer leftsideborder">
                                                            <ul>
                                                                <?php
                                                                $supmnus = $suppermenu2->getSupperMenusOfThisTitleC1($mt->MenuTitleId);
                                                                ?>
                                                                <li>
<!--                                                                    <a href="Products.php?tid=--><?php //echo $mt->MenuTitleId; ?><!--"-->
                                                                    <span
                                                                       class="title"><?php echo $mt->Name; ?></span>
                                                                </li>
                                                                <?php
                                                                foreach ($supmnus as $spm) {
                                                                    ?>
                                                                    <li>
                                                                        <a href="Products.php?spgroup=<?php echo $spm->SupperGroup->SupperGroupId; ?>"><?php echo $spm->SupperGroup->Name; ?></a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>

                                                        <?php
                                                    }

                                                    //$suppermenu2->close();
                                                    ?>
                                                </div>

                                                <?php
                                                $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
                                                $menutitles = $menutitle->getOneSubMenuTitlesC2($sm->SubMenuId);
//                                                $suppermenu2 = new SupperMenuDataSource();
//                                                $suppermenu2->open();
                                                ?>
                                                <div class="column">
                                                    <?php
                                                    foreach ($menutitles as $mt) {
                                                        ?>
                                                        <div class="itemcontainer leftsideborder">
                                                            <ul>
                                                                <?php
                                                                $supmnus = $suppermenu2->getSupperMenusOfThisTitleC2($mt->MenuTitleId);
                                                                ?>
                                                                <li>
                                                                    <a href="Products.php?tid=<?php echo $mt->MenuTitleId; ?>"
                                                                       class="title"><?php echo $mt->Name; ?></a>
                                                                </li>
                                                                <?php
                                                                foreach ($supmnus as $spm) {
                                                                    ?>
                                                                    <li>
                                                                        <a href="Products.php?spgroup=<?php echo $spm->SupperGroup->SupperGroupId; ?>"><?php echo $spm->SupperGroup->Name; ?></a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>

                                                        <?php
                                                    }

//                                                    $suppermenu2->close();

                                                    ?>
                                                </div>
                                                <?php
                                                $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
                                                $menutitles = $menutitle->getOneSubMenuTitlesC3($sm->SubMenuId);
//                                                $suppermenu2 = new SupperMenuDataSource();
//                                                $suppermenu2->open();
                                                ?>
                                                <div class="column">
                                                    <?php
                                                    foreach ($menutitles as $mt) {
                                                        ?>
                                                        <div class="itemcontainer leftsideborder">
                                                            <ul>
                                                                <?php
                                                                $supmnus = $suppermenu2->getSupperMenusOfThisTitleC3($mt->MenuTitleId);
                                                                ?>
                                                                <li>
                                                                    <a href="Products.php?tid=<?php echo $mt->MenuTitleId; ?>"
                                                                       class="title"><?php echo $mt->Name; ?></a>
                                                                </li>
                                                                <?php
                                                                foreach ($supmnus as $spm) {
                                                                    ?>
                                                                    <li>
                                                                        <a href="Products.php?spgroup=<?php echo $spm->SupperGroup->SupperGroupId; ?>"><?php echo $spm->SupperGroup->Name; ?></a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>

                                                        <?php
                                                    }

//                                                    $suppermenu2->close();
                                                    ?>
                                                </div>
                                                <?php
                                                $suppermenus = $suppermenu->getOneSubMenuSupperMenus($sm->SubMenuId);
                                                $menutitles = $menutitle->getOneSubMenuTitlesC4($sm->SubMenuId);
//                                                $suppermenu2 = new SupperMenuDataSource();
//                                                $suppermenu2->open();
                                                ?>
                                                <div class="column4">
                                                    <?php
                                                    foreach ($menutitles as $mt) {
                                                        ?>
                                                        <div class="itemcontainer leftsideborder">
                                                            <ul>
                                                                <?php
                                                                $supmnus = $suppermenu2->getSupperMenusOfThisTitleC4($mt->MenuTitleId);
                                                                ?>
                                                                <li>
                                                                    <a href="Products.php?tid=<?php echo $mt->MenuTitleId; ?>"
                                                                       class="title"><?php echo $mt->Name; ?></a>
                                                                </li>
                                                                <?php
                                                                foreach ($supmnus as $spm) {
                                                                    ?>
                                                                    <li>
                                                                        <a href="Products.php?spgroup=<?php echo $spm->SupperGroup->SupperGroupId; ?>"><?php echo $spm->SupperGroup->Name; ?></a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>

                                                        <?php
                                                    }

//                                                    $suppermenu2->close();
                                                    ?>
                                                </div>
                                                <div class="itemcontainer">
                                                    <?php
                                                    if (trim($sm->Image) != "جهت انتخاب تصویر اینجا را کلیک کنید..." && trim($sm->Image) != "") {
                                                        ?>
                                                        <img src="<?php echo $sm->Image; ?>" width="379"
                                                             height="335" alt=""/>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                $suppermenu2->close();
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <?php
        }

        $suppermenu->close();
        $menutitle->close();

        ?>
    </ul>
    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/SettingsDataSource.inc';
    $setting = new SettingsDataSource();
    $setting->open();
    $settings = $setting->Fill();
    $setting->close();
    ?>
    <?php
    if ($settings->MenuCustomButtonName != "") {
        ?>
        <a href="<?php echo $settings->MenuCustomButtonLink; ?>" class="m-custom-btn">
            <img src="<?php echo $settings->MenuCustomButtonImage; ?>">
            <span>
        <?php
        echo $settings->MenuCustomButtonName;
        ?>
            </span>
        </a>
        <?php
    }
    ?>
</nav>

<script>
    $(document).ready(function () {
        var settings = {
            sensitivity: 4,
            interval: 180,
            timeout: 500,
            over: function () {
                $(this).children('div').addClass('on');
            },
            out: function () {
                $(this).children('div').removeClass('on');
            }
        };
        $("#menu > li").hoverIntent(settings);
        $("#menu  li div.second-level ul li").hoverIntent(settings);

    });
</script>