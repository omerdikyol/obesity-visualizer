<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/userService/userService.php';

// Get all countries
$data = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/helper/countries.php';
$countries = array();
foreach ($data as $key => $country) {
    array_push($countries, $country);
}

$error = isset($_SESSION['regError']) ? $_SESSION['regError'] : false;
unset($_SESSION['regError']);

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/register.php';