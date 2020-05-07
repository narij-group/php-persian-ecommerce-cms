<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/OpinionDataSource.inc';

$opinion = new OpinionDataSource();
$opinion->open();
$opinions = $opinion->LimitedFill($_POST['item'] + 30);
$items = $_POST['item'] + 30;
$total = $opinion->Fill();
$opinion->close();
$postsCounter = 0;
?>
<script src="Template/Scripts/jquery-2.2.0.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $(".product-id2").click(function () {
            var productId = $(this).text();
            $.ajax({
                url: 'ProductInfo.php',
                type: 'POST',
                data: {productId: productId},
                success: function (result) {
                    $("#modal-content").html(result);
                }
            });
        });
        $(".Agree").click(function () {
            $('#modalback2').fadeIn(0);
            var id = $(this).attr('id');
            $.ajax({
                url: 'AgreeOpinion.php',
                type: 'GET',
                data: {id: id},
                success: function (result) {
                    $('#modalback2').fadeOut(0);
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        positionClass: 'toast-top-left',
                        timeOut: 5000
                    };
                    toastr.success('عملیات موفقیت آمیز بود.', 'پیغام');
//                    $('#success-msg').fadeIn(0);
                    setInterval(function () {
//                        $('#success-msg').fadeOut(250);
                    }, 4750);
                }
            });
        });
        $(".DissAgree").click(function () {
            $('#modalback2').fadeIn(0);
            var id = $(this).attr('id');
            $.ajax({
                url: 'DissAgreeOpinion.php',
                type: 'GET',
                data: {id: id},
                success: function (result) {
                    $('#modalback2').fadeOut(0);
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        positionClass: 'toast-top-left',
                        timeOut: 5000
                    };
                    toastr.success('عملیات موفقیت آمیز بود.', 'پیغام');
//                    $('#success-msg').fadeIn(0);
                    setInterval(function () {
//                        $('#success-msg').fadeOut(250);
                    }, 4750);
                }
            });
        });
        $("#modalback").click(function () {
            $("#p-info").fadeOut(250);
            $("#modalback").fadeOut(500);
        });
        $('.DissAgree').click(function () {
            $(this).addClass(" RedBordered");
        });
        $('.Agree').click(function () {
            $(this).addClass(" GreenBordered");
        });
        $('#loadmore').click(function () {
            $('#modalback2').fadeIn(0);
            $.ajax({
                url: 'LoadMoreO.php',
                type: 'POST',
                data: {item: <?php echo $items; ?>},
                success: function (result) {

                    $('#modalback2').fadeOut(0);
                    $("#db").html(result);
                },
                error: function (result) {
                    $('#modalback2').fadeOut(0);
                    alert("لطفا دوباره امتحان کنید!");
                }
            });
        });
    });

</script>
<?php
foreach ($opinions as $c) {
    echo '<div class="opinion">';
    echo "<div class='DatabaseField UpDownMargin'><span class='btn btn-warning m-r-sm'>" . $c->OpinionId . "</span></div>";
    echo "<div class='DatabaseField'><span class='Date'>" . $c->Date . "</span></div>";
    echo "<div class='DatabaseField'><span class='title'>نام  کاربر : </span>" . $c->Customer->Name . " " . $c->Customer->Family . "</div>";
    echo "<div class='DatabaseField'><span class='title'>نظر : </span>" . $c->Value . "</div>";
    echo '<div class="DatabaseField Rate"><select id="rate' . $c->OpinionId . '"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div>';
    echo "<div class='DatabaseField'><span class='title'>شناسه محصول : </span><a class='product-id2' ><span class='btn btn-info m-r-sm'>" . $c->ProductId . "</span></a></div>";
    if ($c->Activated == 0) {
        echo "<div class='DatabaseField'><span class='title'>وضعیت : </span> در انتظار بررسی</div>";
    } else if ($c->Activated == 1) {
        echo "<div class='DatabaseField' ><span class='title'>وضعیت : </span>در حال نمایش  </div>";
    } else {
        echo "<div class='DatabaseField' ><span class='title'>وضعیت : </span>رد شده</div>";
    }
    if ($role->DeleteOpinion == 1) {
        echo "<a class='Delete btn btn-danger' onclick='return deleteConfirm()' href='DeleteOpinion.php?id=" . $c->OpinionId . "'>" . "<i class='fa fa-trash-o'></i>حذف" . "</a>";
    }
    if ($role->EditOpinion == 1) {
        echo "<div id='" . $c->OpinionId . "' class='DissAgree";
        if ($c->Activated == 2) {
            echo " RedBordered";
        }
        echo "'><a class='btn btn-success'>" . "<i class='fa fa-thumbs-o-down'></i>رد" . "</a></div>";
        echo "<div id='" . $c->OpinionId . "' class='Agree";
        if ($c->Activated == 1) {
            echo " GreenBordered";
        }
        echo "'><a class='btn btn-primary'>" . "<i class='fa fa-thumbs-o-up'></i>تایید" . "</a></div>";
    }
    echo "</div>";
    ?>
    <script src="../Template/Rating/dist/jquery.barrating.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#rate<?php echo $c->OpinionId; ?>').barrating({
                theme: 'fontawesome-stars',
                readonly: true
            });
            $('#rate<?php echo $c->OpinionId; ?>').barrating('set', <?php echo $c->Rate; ?>);
        });
    </script>
    <?php
}

foreach ($total as $t) {
    $postsCounter++;
}
if ($postsCounter >= $items) {
    ?>
    <input id="loadmore" type="button" name="loadmore" class="load-more2 btn btn-warning btn-w-m"
           value="بارگذاری موارد بیشتر..."/>
    <?php
}
?>

</div>

<div class="RecordsCounter">Total : <?php echo $postsCounter; ?></div>