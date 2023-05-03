<?php

session_start();

$mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/db/database.php";

if (isset($_POST["country_create"])) {
    $bmi = $mysqli->real_escape_string($_POST["bmi"]);
    $country = $mysqli->real_escape_string($_POST["country"]);
    $year = $mysqli->real_escape_string($_POST["year"]);
    $percentage = $mysqli->real_escape_string($_POST["percentage"]);

    $sql = "INSERT INTO public_data (bmi, geo, year, value) VALUES (?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $stmt->error);
    }

    $stmt->bind_param("ssss", $bmi, $country, $year, $percentage);

    $stmt->execute();
    $stmt->close();

    $_SESSION["alert_success"] = "Country data created successfully";
} else {
    $_SESSION["alert_fail"] = "Country data not created";
}

header("Location: /obesity-visualizer/app/controllers/admin/countries.php");
exit(0);