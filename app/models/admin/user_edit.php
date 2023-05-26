<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $mysqli->real_escape_string($_SESSION["edit_id"]);
    $_SESSION["edit_id"] = null;

    editUser($id);

    $_SESSION["alert_success"] = "User edited successfully";
} else {
    $_SESSION["alert_fail"] = "User edit failed";
}

header("Location: /obesity-visualizer/app/controllers/admin/users.php");
exit(0);