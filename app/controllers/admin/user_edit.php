<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService/adminService.php';

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    exit;
}

$id = $mysqli->real_escape_string($_GET['id']);

$user = getUser($id);

if ($user) {
    $name = $user['name'];
    $email = $user['email'];
    $country = $user['country'];
    $date_of_birth = $user['date_of_birth'];
    $height = $user['height'];
    $weight = $user['weight'];
    $bmi = $user['bmi'];

    $_SESSION["edit_id"] = $id;

    // Get country names
    $countries = array();
    $countriesDict = include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/helper/countries.php';
    foreach ($countriesDict as $code => $countryName) {
        array_push($countries, $countryName);
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/admin/user_edit.php';
} else {
    $_SESSION["alert"] = "User not found";
    header("Location: /obesity-visualizer/app/controllers/admin/users.php");
    exit(0);
}