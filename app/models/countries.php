<?php

function getCountryCodes()
{
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';
    $sql = "SELECT * FROM public_data";
    $result = $mysqli->query($sql);
    $codes = [];
    while ($row = $result->fetch_assoc()) {
        if (!in_array($row['geo'], $codes) && strlen($row['geo']) < 3) {
            // Add country to array
            array_push($codes, $row['geo']);
        }
    }
    return $codes;
}

function getCountryNames()
{
    $codes = getCountryCodes();
    $countries = include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/helper/countries.php';
    $names = [];
    foreach ($codes as $code) {
        $names[$code] = $countries[$code];
    }

    return $names;
}