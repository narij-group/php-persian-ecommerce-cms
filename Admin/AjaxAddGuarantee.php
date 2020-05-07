<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once 'Template/top2.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/GuaranteeDataSource.inc';

$guarantee = new Guarantee();
$guarantee->Product = $_POST['product'];
$guarantee->Guarantee = $_POST['guarantee'];
$guarantee->Date = date("Y/m/d");
if ($_POST['guarantee'] != NULL) {
    $grds = new GuaranteeDataSource();
    $grds->open();
    $grds->Insert($guarantee);
    $gs = $grds->GetGuaranteesForOneProduct($_POST['product']);
    $grds->close();


    foreach ($gs as $p) {
        echo "<span class='guaranteeSample label-success'>" . $p->Guarantee->Name . "-" . $p->Guarantee->Duration . " : <span class='price label label-warning'>" . number_format($p->Guarantee->Price) . " تومان</span><a class='dltbtn3 btn btn-danger btn-circle' ><i class='fa fa-remove'></i>$p->GuaranteeId</a></span>";
    }
} else {


    $grds = new GuaranteeDataSource();
    $grds->open();

    echo "<div class='alert alert-warning'>گارانتی را انتخاب کنید!</div><br />";
    $gs = $grds->GetGuaranteesForOneProduct($_POST['product']);
    $grds->close();
    foreach ($gs as $p) {
        echo "<span class='guaranteeSample label-success'>" . $p->Guarantee->Name . "-" . $p->Guarantee->Duration . " : <span class='price label label-warning'>" . number_format($p->Guarantee->Price) . " تومان</span><a class='dltbtn3 btn btn-danger btn-circle' ><i class='fa fa-remove'></i>$p->GuaranteeId</a></span>";
    }
}
?>
<script>
    $(document).ready(function () {
        $(".dltbtn3").click(function () {
            if (confirm('آیا میخواهید این گارانتی را حذف نمایید ؟')) {
                $.ajax({
                    type: 'POST',
                    url: 'AjaxDeleteGuarantee.php',
                    data: {guaranteeId: $(this).text(), product:<?php echo $_POST['product']; ?>},
                    success: function (data) {
                        $('#guaranteeSamples').html(data);
                    }
                });
            }
        });
    });
</script>