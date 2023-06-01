<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/models/admin/adminLogout.php';
header("Location: /obesity-visualizer/public-app/app/controllers/admin/adminLogin.php");