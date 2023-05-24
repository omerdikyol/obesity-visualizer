<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService/adminService.php';

if (isset($_POST["user_create"])) {
    createUser();

    $_SESSION["alert_success"] = "User created successfully";
} else {
    $_SESSION["alert_fail"] = "User not created";
}

header("Location: /obesity-visualizer/app/controllers/admin/users.php");
exit(0);