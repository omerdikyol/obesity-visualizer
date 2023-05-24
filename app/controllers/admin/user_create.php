<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService/adminService.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/countryService/countryService.php';

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    exit;
}

// Get country names
$countries = getCountryNames();
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/admin/user_create.php';