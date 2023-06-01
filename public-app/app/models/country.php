<?php

function getCountry($id)
{
    // Send the data to the API endpoint
    $url = 'http://localhost/obesity-visualizer/country/ ' . $id;

    // Create a new cURL resource
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($c);
    curl_close($c);

    $country = json_decode($res, true);
    return $country;
}

function getCountries()
{
    // Send the data to the API endpoint
    $url = 'http://localhost/obesity-visualizer/country/';

    // Create a new cURL resource
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($c);
    curl_close($c);

    $countries = json_decode($res, true);
    return $countries;
}

function getCountryCodes()
{
    // Send the data to the API endpoint
    $url = 'http://localhost/obesity-visualizer/country/codes';

    // Create a new cURL resource
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($c);
    curl_close($c);

    $codes = json_decode($res, true);
    return $codes;
}

function getCountryNames()
{
    // Send the data to the API endpoint
    $url = 'http://localhost/obesity-visualizer/country/names';

    // Create a new cURL resource
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($c);
    curl_close($c);

    $names = json_decode($res, true);
    return $names;
}