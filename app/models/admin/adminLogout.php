<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService.php';

if ($_SESSION['admin'] === true) {
    $_SESSION['admin'] = false;
}
header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
exit;