<?php

session_start();

if ($_SESSION['admin'] !== true) {
    header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/models/admin/countries.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/admin/countries.php';