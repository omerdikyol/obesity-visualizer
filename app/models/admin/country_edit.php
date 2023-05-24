<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/adminService/adminService.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_SESSION["edit_id"];
    $_SESSION["edit_id"] = null;

    $data = getCountry($id);

    if ($data) {
        editCountry($id);
        $_SESSION["alert_success"] = "Country Data edited successfully";
    }
} else {
    $_SESSION["alert_fail"] = "Country Data edit failed";
}

header("Location: /obesity-visualizer/app/controllers/admin/countries.php");
exit(0);