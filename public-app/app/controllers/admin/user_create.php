<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/AdminService/adminModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/CountryService/countryModel.php';

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/admin/login');
    exit;
}

// Get country names
$countryService = new CountryService();
$countries = $countryService->getCountryNames();
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/admin/user_create.php';
