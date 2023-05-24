<?php
# Returns data for a specific bmi

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/chartService/chartService.php';

if (isset($_GET['bmi'])) {
    $bmi = "";

    $data = getFromBmi($_GET['bmi']);

    echo $data;
} else {
    if (!isset($_GET['bmi'])) {
        echo "BMI not set";
    }
}