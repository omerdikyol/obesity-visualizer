<?php
# Returns all data from db

$mysqli = require_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

$sql = "SELECT * FROM public_data";
$result = $mysqli->query($sql);
$data = array();
while ($row = $result->fetch_assoc()) {
    $temp = array();
    $temp["country"] = $row['geo'];
    $temp["year"] = $row['year'];
    $temp["value"] = $row['value'];
    switch ($row["bmi"]) {
        case "BMI_GE25":
            $temp["bmi"] = "Overweight";
            break;
        case "BMI25-29":
            $temp["bmi"] = "Pre-obese";
            break;
        case "BMI_GE30":
            $temp["bmi"] = "Obese";
            break;
    }
    $data[] = $temp;
}
echo json_encode($data);