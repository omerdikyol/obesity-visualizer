<?php
# Returns data for a specific year and bmi

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/countryService.php';

if (isset($_GET['year']) && isset($_GET['bmi'])) {
    $data = getFromYearAndBmi($_GET['year'], $_GET['bmi']);
    echo $data;
} else {
    if (!isset($_GET['year'])) {
        echo "Year not set";
    }
}