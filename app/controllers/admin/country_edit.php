<?php
session_start();

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    exit;
}

$mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';
$bmi = $mysqli->real_escape_string($_GET['bmi']);
$geo = $mysqli->real_escape_string($_GET['geo']);
$year = $mysqli->real_escape_string($_GET['year']);

$sql = sprintf("SELECT * FROM public_data WHERE bmi = '%s' AND geo = '%s' AND year = '%s'", $bmi, $geo, $year);

$result = $mysqli->query($sql);
$data = $result->fetch_assoc();
if ($data) {
    $bmi = $data['bmi'];
    $geo = $data['geo'];
    $year = $data['year'];
    $value = $data['value'];

    $_SESSION["edit_bmi"] = $bmi;
    $_SESSION["edit_geo"] = $geo;
    $_SESSION["edit_year"] = $year;

    // Get country codes
    $countries = array();
    $countriesDict = include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/helper/countries.php';
    foreach ($countriesDict as $code => $countryName) {
        array_push($countries, $code);
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/admin/country_edit.php';
} else {
    $_SESSION["alert"] = "Country Data not found";
    header("Location: /obesity-visualizer/app/controllers/admin/country_edit.php");
    exit(0);
}