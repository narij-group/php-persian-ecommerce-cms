<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassesEx/datasource/FeedDataSource.inc';
$feed = new FeedDataSource();
$feed->Delete($_GET['id']);
?>
<script>
    window.top.close();
</script>
