<?php
# Returns data for a specific bmi

if (isset($_GET['bmi'])) {
    $bmi = "";

    $url = 'http://localhost/obesity-visualizer/chart/' . $_GET['bmi'];

    // Create a new cURL resource
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($c);
    curl_close($c);

    $data = json_decode($res, true);
    echo $data;
} else {
    if (!isset($_GET['bmi'])) {
        echo "BMI not set";
    }
}