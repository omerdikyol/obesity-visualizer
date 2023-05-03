<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirect the user to the login page
    header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    exit;
} else {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/admin.php';
}