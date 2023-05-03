<?php

$mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

$bmi = $_GET["bmi"];
$geo = $_GET["geo"];
$year = $_GET["year"];

$sql = "DELETE FROM public_data WHERE bmi = ? AND geo = ? AND year = ?";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL Error: " . $stmt->error);
}

$stmt->bind_param("sss", $bmi, $geo, $year);

$stmt->execute();

$stmt->close();

$mysqli->close();

$_SESSION["alert_success"] = "Country Data deleted successfully";

header("Location: /obesity-visualizer/app/controllers/admin/countries.php");