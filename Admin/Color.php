<!DOCTYPE html>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
$cm = "add";
require_once __DIR__ . DIRECTORY_SEPARATOR .  '../ClassesEx/datasource/ColorDataSource.inc';
$color = new Color();
if (isset($_GET['id'])) {
    $cm = "edit";
    $p = new ColorDataSource();
    $color = $p->Fill();
}
?>
<?php
include_once 'Template/top.php';

include_once 'Template/menu.php';
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>رنگ</h2>
    </div>
    <div class="col-lg-6 title-en">
        <h2>Color</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

                    <a href="Colors.php">
                        <button class="btn btn-info btn-w-m" type="button"><i class="fa fa-list-ol"></i>
                            لیست رنگ ها
                        </button>
                    </a>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            رنگ
                        </div>
                        <div class="panel-body">
                            <div class="Inputs">
                                <?php
                                if ($cm == "add") {
                                ?>
                                <form action="#" method="post">
                                    <?php
                                    } elseif ($cm == "edit") {
                                    ?>
                                    <form action="UpdateColor.php" method="post">
                                        <input type="hidden" id="id" name="id" value="<?php echo $color->ColorId; ?>" />
                                        <?php
                                        }
                                        ?>
                                        <fieldset class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    سبز :
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="color" class="ColorText" id="green" name="green" value="<?php echo $color->Green; ?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    آبی پر رنگ  :
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="color" class="ColorText" id="darkblue" name="darkblue" value="<?php echo $color->DarkBlue; ?>" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">
                                                    آبی کم رنگ  :
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="color" class="ColorText" id="lightblue" name="lightblue" value="<?php echo $color->LightBlue; ?>" />
                                                </div>
                                            </div>
                                        </fieldset>
                                        <button class="btn btn-primary btn-w-m pull-right" type="submit"><i
                                                    class="fa fa-check"></i><strong>تایید</strong></button>
                                    </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="Metro">
    <div class="Centerer">        
        <div class="MainTitle2"><span <?php
            if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                echo "class='SBackground'";
            } else {
                echo "class='GBackground'";
            }
            ?> >Color</span><img src="Template/Images/trigger2.png" alt=""/></div>
        <div class="ProfileBar">
            <div class="Shortcut"><a href="Colors.php"><img src="Template/Images/Database.png" alt=""/></a></div>
            <div class="Shortcut"><a href="Index.php"><img src="Template/Images/Start.png" alt=""/></a></div>
            <div class="Shortcut"><a href="Logoff.php" ><img src="Template/Images/Logoff.png" alt=""/></a></div>
            <div class="Profile">
                <img src="Template/Images/malecostume-128.png" alt=""/>
                <div class="Name"><?php echo $settings->Owner; ?></div>

            </div>
        </div>
        <div class="Inputs">
            <?php
            if ($cm == "add") {
                ?>
                <form action="#" method="post">
                    <?php
                } elseif ($cm == "edit") {
                    ?> 
                    <form action="UpdateColor.php" method="post">
                        <input type="hidden" id="id" name="id" value="<?php echo $color->ColorId; ?>" />
                        <?php
                    }
                    ?>

                    <table>
                        <tr><td><label>سبز : </label></td><td><input type="color" class="ColorText" id="green" name="green" value="<?php echo $color->Green; ?>" /></td></tr>                                                
                        <tr><td><label>آبی پر رنگ : </label></td><td><input type="color" class="ColorText" id="darkblue" name="darkblue" value="<?php echo $color->DarkBlue; ?>" /></td></tr>                                                
                        <tr><td><label>آبی کم رنگ: </label></td><td><input type="color" class="ColorText" id="lightblue" name="lightblue" value="<?php echo $color->LightBlue; ?>" /></td></tr>                                                                        
                        <tr class="SaveTr"><td class="SaveTd"></td><td><input type="submit" class="Save" value="" /></td></tr>                        
                    </table>
                </form>
        </div>
    </div>
</div>
<?php
include_once 'Template/bottom.php';
