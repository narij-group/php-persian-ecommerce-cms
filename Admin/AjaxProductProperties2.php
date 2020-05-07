<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductPropertyDataSource.inc';

if ($role->ProductProperties != 1) {
    header('Location:Index.php');
    die();
}

$productProperty = new ProductPropertyDataSource();
$productProperty->open();
$productProperties = $productProperty->FindOneSupperGroupRecords($_POST['suppergroup']);
$productProperty->close();

setcookie(COOKIE_SUPPER_GROUP_ID, $_POST['suppergroup'], time() + 86400);
?>
<link href="Template/Styles/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<div class="db-cover" id="wait">
                <span class="loading-title <?php
                if (strlen(strstr($agent, 'Firefox')) > 0 || strlen(strstr($agent, 'Trident/7.0')) > 0) {
                    echo " SBackground'";
                } else {
                    echo " GBackground'";
                }
                ?>">Loading...</span>
    <img class="loading-gif" src="Template/Images/gifs/giphy (3).gif" alt=""/>
</div>
<table class="footable table table-stripped" data-page-size="1000000000"
       data-filter=#filter>
    <thead>
    <tr>
        <th class="choose-th">انتخاب<img class="th-loader"
                                         src="Template/Images/gifs/loading.gif"/></th>
        <th> نام</th>
        <th data-hide="phone,tablet"> محتوا</th>
        <!--                    <th> زیر زیرمجموعه</th>-->
    </tr>
    </thead>
    <?php
    $postsCounter = 0;
    foreach ($productProperties as $p) {
        $postsCounter++;
        echo "<tr>";
        echo "<td><div class='DatabaseField' ></div>";
        echo "<div class='checkbox checkbox-info checkbox-circle' ><input type = 'checkbox' ";
        if ($p->Search == 1) {
            echo ' checked ';
        }
        echo " value = '" . $p->ProductPropertyId . "' id = 'check" . $p->ProductPropertyId . "' ";
        echo " class='acheck' /><label for='check" . $p->ProductPropertyId . "' ></label ></div > ";
        echo "</div >";
        echo "</td>";
        echo "<td><div class='DatabaseField' >" . $p->Name . "</div></td>";
        echo "<td><div class='DatabaseField' >" . $p->Value . "</div></td>";
        echo "</tr>";
    }
    ?>
</table>
<script>
    $(document).ready(function () {
        $('.acheck').change(function () {
            $(".th-loader").fadeIn(0)
            if ($('.acheck').is(':checked')) {
                $(this).attr('disabled', "");
                $.ajax({
                    type: "POST",
                    url: "AjaxSearchSelection.php",
                    data: {id: $(this).val(), search_value: 1},
                    success: function () {
                        $(".th-loader").fadeOut(0)
                        $("#success-msg").fadeIn(250);
                        setTimeout(function () {
                            $("#success-msg").fadeOut(250);
                        }, 1000);
                    }
                });
            }
            else {
                $(this).attr('disabled', "");
                $.ajax({
                    type: "POST",
                    url: "AjaxSearchSelection.php",
                    data: {id: $(this).val(), search_value: 0},
                    success: function () {
                        $(".th-loader").fadeOut(0)
                        $("#success-msg").fadeIn(250);
                        setTimeout(function () {
                            $("#success-msg").fadeOut(250);
                        }, 1000);
                    }
                });
            }
            $(this).removeAttr('disabled', '');
        });
    });
</script>