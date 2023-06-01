<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/AdminService/adminModel.php';

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/public-app/app/controllers/admin/adminLogin.php');
    exit;
}

$id = $mysqli->real_escape_string($_GET['id']);

$adminService = new AdminService();

$user = $adminService->getUser($id);

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
    $countriesDict = include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/helper/countries.php';
    foreach ($countriesDict as $code => $countryName) {
        array_push($countries, $countryName);
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/admin/user_edit.php';
} else {
    $_SESSION["alert"] = "User not found";
    header("Location: /obesity-visualizer/public-app/app/controllers/admin/users.php");
    exit(0);
}