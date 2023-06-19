<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/UserService/userModel.php';

// Get all countries
$data = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/helper/countries.php';
$countries = array();
foreach ($data as $key => $country) {
    array_push($countries, $country);
}

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/register.php';