<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

if (!isset($mysqli))
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

class CountryService
{

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
        $codes = $this->getCountryCodes();
        $countries = include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/helper/countries.php';
        $names = [];
        foreach ($codes as $code) {
            $names[$code] = $countries[$code];
        }

        return $names;
    }
}