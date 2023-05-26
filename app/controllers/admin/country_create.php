<?php

session_start();

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/countryService.php';
// Get country codes
$countryCodes = getCountryCodes();
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/admin/country_create.php';