<?php
# Returns all data from db

$mysqli = require_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

$sql = "SELECT * FROM public_data";
$result = $mysqli->query($sql);
$data = array();
$data["Overweight"] = array();
$data["Pre-obese"] = array();
$data["Obese"] = array();
while ($row = $result->fetch_assoc()) {
    $bmi = $row['bmi'];
    switch ($row["bmi"]) {
        case "BMI_GE25":
            $bmi = "Overweight";
            break;
        case "BMI25-29":
            $bmi = "Pre-obese";
            break;
        case "BMI_GE30":
            $bmi = "Obese";
            break;
    }
    $data[$bmi][$row['geo']][$row['year']] = $row['value'];
}
echo json_encode($data);