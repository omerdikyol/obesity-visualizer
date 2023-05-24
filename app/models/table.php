<?php
# Returns all data from db

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/chartService/chartService.php';

$data = getAllData();

echo $data;