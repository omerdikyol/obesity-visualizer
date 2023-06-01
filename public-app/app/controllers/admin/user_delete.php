<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/AdminService/adminModel.php';

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/public-app/app/controllers/admin/adminLogin.php');
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/models/admin/user_delete.php';