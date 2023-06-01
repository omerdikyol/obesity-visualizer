<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/AdminService/adminModel.php';

if ($_SESSION['admin'] === true) {
    $_SESSION['admin'] = false;
}
header('Location: /obesity-visualizer/public-app/app/controllers/admin/adminLogin.php');
exit;
