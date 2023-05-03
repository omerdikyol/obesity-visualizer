<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

    $bmi = $_SESSION["edit_bmi"];
    $geo = $_SESSION["edit_geo"];
    $year = $_SESSION["edit_year"];

    $_SESSION["edit_bmi"] = null;
    $_SESSION["edit_geo"] = null;
    $_SESSION["edit_year"] = null;

    $sql = sprintf("SELECT * FROM public_data WHERE bmi = '%s' AND geo = '%s' AND year = '%s'", $bmi, $geo, $year);

    $result = $mysqli->query($sql);

    $data = $result->fetch_assoc();

    if ($data) {
        $bmi = $mysqli->real_escape_string($_POST['bmi']);
        $geo = $mysqli->real_escape_string($_POST['geo']);
        $year = $mysqli->real_escape_string($_POST['year']);
        $value = $mysqli->real_escape_string($_POST['value']);
    }

    $sql = "UPDATE public_data SET bmi = ?, geo = ?, year = ?, value = ? WHERE bmi = ? AND geo = ? AND year = ?";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $stmt->error);
    }
    $stmt->bind_param("sssssss", $bmi, $geo, $year, $value, $bmi, $geo, $year);

    $stmt->execute();

    $stmt->close();

    $mysqli->close();

    $_SESSION["alert_success"] = "Country Data edited successfully";
} else {
    $_SESSION["alert_fail"] = "Country Data edit failed";
}

header("Location: /obesity-visualizer/app/controllers/admin/countries.php");
exit(0);