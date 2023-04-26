<?php

// Get all countries
$data = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/helper/countries.php';
$countries = array();
foreach ($data as $key => $country) {
    array_push($countries, $country);
}

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/register.php';