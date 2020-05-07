<script src="../Template/Scripts/jquery-3.1.1.js" type="text/javascript"></script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/CityDataSource.inc';

$city = new CityDataSource();
$city->open();

$city_ids = array_unique(explode(",", $_POST['cities']));
$counter = 0;
foreach ($city_ids as $c) {
    if (trim($c) != "") {
        ?>
        <div class="city-sample" title="حذف" id="sample<?php echo trim($c); ?>"><?php echo $city->GetName($c); ?></div>
        <script>
            $(document).ready(function () {
                $('#sample<?php echo trim($c); ?>').click(function () {
                    $(this).fadeOut(250);
                    $('#allowedcities').val("<?php echo str_replace(trim($c . ','), '', $_POST['cities']); ?>");
                    $.ajax({
                        type: 'POST',
                        url: 'SHInsertTheCity.php',
                        data: {cities: $('#allowedcities').val()},
                        success: function (data) {
                            $('#samples').html(data);
                        }
                    });
                });
            });
        </script>


        <?php
        $counter++;
        if ($counter % 4 == 0) {
            echo "<br/>";
        }
    }
}
?>

