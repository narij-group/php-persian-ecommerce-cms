<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
$max = 32;
$dir = "../Images/" . $_POST['FolderId'];
unlink($_POST['Image']);
//echo '<div style="width:100%; direction:ltr; height:30px; ">';
//echo $_POST['Image'];
//echo "</div>";
$files = array_values(array_filter(scandir($dir), function ($file) {
            return !is_dir($file);
        }));
$n = 0;
foreach ($files as $file) {
    if (strpos($file, 'png') !== false || strpos($file, 'jpg') !== false) {
        if ($n < $max) {
            $n++;
            echo "<div class='thumb-holder  ThumbImage'><img src='$dir/$file' /></div>";
            echo "<a class='deleteHover'>$dir/$file<img src='Template/Images/deleteHover.png' /></a> ";
        }
    }
}
$rows = ceil($n / 4);
for ($i = (4 * (ceil($n / 4))) - $n; $i > 0; $i--) {
    echo "<div class='thumb-holder'><img class='Default' data-toggle='modal' data-target='#filemanModal1'  src='Template/Images/ImageThumb.png' /></div>";
}
echo '<div class="clear-fix"></div>';
?>
<script>
    $(document).ready(function() {
        $(".deleteHover").click(function () {
            if (confirm('آیا میخواهید این عکس را حذف نمایید ؟')) {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxImageDelete.php',
                    data: {FolderId: <?php echo $_POST['FolderId']; ?>, Image: $(this).text()},
                    success: function (data) {
                        $('.UploadBoxThumbs').html(data);
                    }
                });
            }
        });
//        $(".Default").click(function() {
//            $("#Filemanager").fadeIn(250);
//            $("#modalback").fadeIn(250);
//        });
        <?php
        $files = scandir($dir);
        $i = 0;
        while ($files) {
        if (strpos($files[$i], ".jpg") !== false || strpos($files[$i], ".png") !== false || strpos($files[$i], ".jpeg") !== false) {
        $image = $dir . "/" . $files[$i];
        ?>
        if($('#image').val() == "<?php echo $_POST['Image']; ?>" ) {
            $('#image').val("<?php echo $image; ?>");
            $.ajax({
                type: 'POST',
                url: 'RefreshImage.php',
                data: {Image: $('#image').val()},
                success: function (data) {
//                    $("#Filemanager2").fadeOut(250);
//                    $("#modalback").fadeOut(250);
                    $('.SelectBoxContainer').html(data);
                    $("#wait").css("display", "none");
//                    $('#roxyCustomPanel2').dialog('close');
                    $('#closeModal1').click(function(){return true;}).click();
                }
            });
        }
        <?php
        break;
        } else {
        if ($i > 10) {
            break;
        }
        $i++;
    }
        }
        ?>
    });
</script>