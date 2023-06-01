<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/models/admin/adminLogin.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/admin/adminLogin.php';