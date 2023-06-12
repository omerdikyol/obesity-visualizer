<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/AdminService/adminModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = false;
    if ($username === 'admin' && $password === 'admin') {
        // Set the session variable to indicate that the user is logged in
        $_SESSION['admin'] = true;
        $result = true;
    }
    if ($result === true) {
        // Redirect the user to the admin dashboard page
        header('Location: /obesity-visualizer/admin/dashboard');
        exit;
    } else {
        // Display an error message
        header('Location: /obesity-visualizer/admin/login');
    }
}
