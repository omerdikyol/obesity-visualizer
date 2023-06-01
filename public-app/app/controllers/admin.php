<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirect the user to the login page
    header('Location: /obesity-visualizer/public-app/app/controllers/admin/adminLogin.php');
    exit;
} else {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/admin.php';
}