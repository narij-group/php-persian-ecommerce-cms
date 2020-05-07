<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';

$productcolor = new ProductColorDataSource();
$productcolor->open();
$productcolor->Delete($_POST['colorId']);
$productcolors = $productcolor->GetProductColorsForOneProduct($_POST['product']);
$productcolor->close();
foreach ($productcolors as $p) {
    echo "<div class = 'colorSample' style = 'border:3px solid " . $p->Color->Sample . ";' title = '" . $p->Color->Name . "'>" . $p->Quantity . "<a class='dltbtn2'><img src='Template/Images/deleteHover.png' alt='' />$p->ProductColorId</a></div>";
}
?>
<script>
    $(document).ready(function () {
        $(".dltbtn2").click(function () {
            if (confirm('آیا میخواهید این رنگ را حذف نمایید ؟')) {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxDeleteColor.php',
                    data: {colorId: $(this).text(), product:<?php echo $_POST['product']; ?>},
                    success: function (data) {
                        $('#colorSamples').html(data);
                    }
                });
            }
        });
    });
</script>