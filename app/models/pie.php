<?php
# Returns data for a specific year and bmi

if (isset($_GET['year']) && isset($_GET['bmi'])) {
    $year = $_GET['year'];
    $bmi = "";
    switch ($_GET['bmi']) {
        case "Overweight":
            $bmi = "BMI_GE25";
            break;
        case "Pre-obese":
            $bmi = "BMI25-29";
            break;
        case "Obese":
            $bmi = "BMI_GE30";
            break;
    }
    $mysqli = require_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';
    $sql = sprintf(
        "SELECT * FROM public_data WHERE year = '%s' AND bmi ='%s'",
        $mysqli->real_escape_string($year),
        $mysqli->real_escape_string($bmi)
    );
    $result = $mysqli->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data["country"] = $row['geo'];
        $data["value"] = $row['value'];
    }
    echo json_encode($data);
} else {
    if (!isset($_GET['year'])) {
        echo "Year not set";
    }
}