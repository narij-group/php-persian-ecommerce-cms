<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/SubGroupDataSource.inc';
$sgds = new SubGroupDataSource();
$sgds->open();
$subgroups = $sgds->FillByGroup($_POST['category_item_id']);
$sgds->close();

if (isset($_POST['category_item_id']) == TRUE) {

    if ($_POST['category_item_type'] == "desktop") {
        foreach ($subgroups as $sb) {
            echo '<li class="sgdesktop" id="' . $sb->SubGroupId . '"><a class="pointer"><i class="fa fa-angle-double-left"></i>';
            echo $sb->Name;
            echo '</a></li>';
        }
    } elseif ($_POST['category_item_type'] == "mobile") {
        ?>
        <div class="items" id="flickity">
            <?php
            foreach ($subgroups as $sb) {
                echo '<a class="pointer sgmobile" id="' . $sb->SubGroupId . '">';
                echo '<div class="gallery-cell">';
                echo $sb->Name;
                echo '</div>';
                echo '</a>';
            }
            ?>
        </div>
        <?php
    }
}
?>
<script>
    $(document).ready(function () {

        var elem = document.querySelector('#flickity');
        var flkty = new Flickity(elem, {
            // options
            cellAlign: 'right',
            contain: true,
            freeScroll: true,
            pageDots: false,
            rightToLeft: true,
            prevNextButtons: false
        });

        $(".sgdesktop").on("click", function () {
            var sgid = $(this).attr("id");

//                $('html,body').animate({
//                        scrollTop: $(".Products").offset().top
//                    },
//                    'slow');
            $("#wait").css("display", "block");
            $.ajax({
                url: 'AjaxSearch/AjaxAdvancedSearch.php',
                type: 'POST',
                data: {
                    page: "1",
                    sub_group : sgid
                },
                success: function (result) {
                    $("#wait").css("display", "none");
                    $("#products").html(result);
                },
                error: function (result) {
                    alert("لطفا دوباره امتحان کنید!");
                }
            });

        });

        $(".sgmobile").on("click", function () {
            var sgid = $(this).attr("id");

//            $('html,body').animate({
//                    scrollTop: $(".Products").offset().top
//                },
//                'slow');
            $("#wait").css("display", "block");
            $.ajax({
                url: 'AjaxSearch/AjaxAdvancedSearch.php',
                type: 'POST',
                data: {
                    page: "1",
                    sub_group : sgid
                },
                success: function (result) {
                    $("#wait").css("display", "none");
                    $("#products").html(result);
                },
                error: function (result) {
                    alert("لطفا دوباره امتحان کنید!");
                }
            });

        });

    });
</script>
