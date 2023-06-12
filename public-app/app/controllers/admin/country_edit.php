<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/AdminService/adminModel.php';

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/admin/login');
    exit;
}

$id = $mysqli->real_escape_string($_GET['id']);

$adminService = new AdminService();

$data = $adminService->getCountryAdmin($id);

if ($data) {
    $bmi = $data['bmi'];
    $geo = $data['geo'];
    $year = $data['year'];
    $value = $data['value'];
    $id = $data['id'];

    $_SESSION["edit_id"] = $id;

    // Get country codes
    $countries = array();
    $countriesDict = include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/helper/countries.php';
    foreach ($countriesDict as $code => $countryName) {
        array_push($countries, $code);
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/admin/country_edit.php';
} else {
    $_SESSION["alert_fail"] = "Country Data not found";
    header("Location: /obesity-visualizer/admin/country-list");
    exit(0);
}
