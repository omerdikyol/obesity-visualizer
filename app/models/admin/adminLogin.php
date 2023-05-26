<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = adminLogin($username, $password);
    if ($result === true) {
        // Redirect the user to the admin dashboard page
        header('Location: /obesity-visualizer/app/controllers/admin.php');
        exit;
    } else {
        // Display an error message
        header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    }
}