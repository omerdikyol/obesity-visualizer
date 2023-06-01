<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/public-app/app/controllers/admin/adminLogin.php');
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/models/admin/users.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/admin/users.php';