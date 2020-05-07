<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<?php
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/ProductColorDataSource.inc';
$productcolor = new ProductColor();
$_POST['product'] = str_replace('quantity', '', $_POST['product']);
$pcds = new ProductColorDataSource();
$pcds->open();
$pcolors = $pcds->GetProductColorsForOneProduct($_POST['product']);
$pcds->close();

foreach ($pcolors as $p) {
    echo "<div class = 'colorSample' style = 'border:3px solid " . $p->Color->Sample . ";' title = '" . $p->Color->Name . "'>" . $p->Quantity . "<a class='dltbtn2'><i class='fa fa-trash-o'></i>$p->ProductColorId</a></div>";
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