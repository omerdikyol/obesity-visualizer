<?php

session_start();

if ($_SESSION['admin'] === true) {
    $_SESSION['admin'] = false;
}
header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
exit;