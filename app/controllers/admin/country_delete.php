<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService.php';


if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    exit;
}

$id = $mysqli->real_escape_string($_GET['id']);

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/models/admin/country_delete.php';