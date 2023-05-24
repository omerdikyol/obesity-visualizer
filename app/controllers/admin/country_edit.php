<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService/adminService.php';

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    exit;
}

$id = $mysqli->real_escape_string($_GET['id']);

$data = getCountry($id);

if ($data) {
    $bmi = $data['bmi'];
    $geo = $data['geo'];
    $year = $data['year'];
    $value = $data['value'];
    $id = $data['id'];

    $_SESSION["edit_id"] = $id;

    // Get country codes
    $countries = array();
    $countriesDict = include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/helper/countries.php';
    foreach ($countriesDict as $code => $countryName) {
        array_push($countries, $code);
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/admin/country_edit.php';
} else {
    $_SESSION["alert"] = "Country Data not found";
    header("Location: /obesity-visualizer/app/controllers/admin/countries.php");
    exit(0);
}