<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../Globals/Sessions.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . '../ClassesEx/datasource/LogoDataSource.inc';


$logo = new LogoDataSource();
$logo->open();
$logos = $logo->Fill();
$logo->close();
$i = 0;
foreach ($logos as $l) {
    if (($i % 3) == 0) {
        echo '<br>';
    }
    ?>
    <div class="check-option"><label class="check-text"
                                     for="lg<?php echo $l->LogoId; ?>"><?php echo $l->Name; ?></label>
        <div class='checkboxFour'><input class="brandcheck" type="checkbox"
                                         id="lg<?php echo $l->LogoId; ?>" name="brandcheck_list[]"
                                         value="<?php echo $l->LogoId; ?>"/><label
                    for='lg<?php echo $l->LogoId; ?>'></label></div>
    </div>
    <?php
    $i++;
}