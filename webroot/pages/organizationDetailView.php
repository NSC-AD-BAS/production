<?php
$id = $_GET['value'];
include 'banner.php';
include 'populateDetailViews.php';
populate_org_detail($id);
?>