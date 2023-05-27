<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

if (!isset($mysqli))
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

// Get all countries with their data from database
function getCountries()
{
    global $mysqli;
    $sql = "SELECT * FROM public_data";
    $result = $mysqli->query($sql);
    $countries = $result->fetch_all(MYSQLI_ASSOC);
    return $countries;
}

// Get country by id
function getCountry($id)
{
    global $mysqli;
    $sql = "SELECT * FROM public_data WHERE id = $id";
    $result = $mysqli->query($sql);
    $country = $result->fetch_assoc();
    return $country;
}

// Get country codes from database
function getCountryCodes()
{
    global $mysqli;
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

// Get country names from database
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


# Returns data for a specific bmi (used in line chart)
function getFromBmi($bmi)
{
    switch ($bmi) {
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
    global $mysqli;
    $sql = sprintf(
        "SELECT * FROM public_data WHERE bmi ='%s'",
        $mysqli->real_escape_string($bmi),
    );
    $result = $mysqli->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $row["value"] = floatval($row["value"]);
        $data[] = $row;
    }
    return json_encode($data);
}

# Returns data for a specific year and bmi (used in pie chart)
function getFromYearAndBmi($year, $bmi)
{
    switch ($bmi) {
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
    global $mysqli;
    $sql = sprintf(
        "SELECT * FROM public_data WHERE year = '%s' AND bmi ='%s'",
        $mysqli->real_escape_string($year),
        $mysqli->real_escape_string($bmi)
    );
    $result = $mysqli->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $temp = array();
        $temp["country"] = $row['geo'];
        $temp["value"] = floatval($row['value']);
        $data[] = $temp;
    }
    return json_encode($data);
}

# Returns all data from db and groups it by bmi (used in table)
function getAllData()
{
    global $mysqli;
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
        $data[$bmi][$row['geo']][$row['year']] = floatval($row['value']);
    }
    return json_encode($data);
}