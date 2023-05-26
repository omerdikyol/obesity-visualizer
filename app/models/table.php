<?php
# Returns all data from db

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/countryService.php';

$data = getAllData();

echo $data;