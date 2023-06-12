<?php
# Returns data for a specific bmi

if (isset($_GET['bmi'])) {
    $url = 'http://localhost/obesity-visualizer/chart/' . $_GET['bmi'];

    // Create a new cURL resource
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($c);
    $error = curl_error($c);
    $errno = curl_errno($c);
    $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);
    curl_close($c);

    if ($errno !== 0) {
        // cURL error occurred  
        header("Location: /obesity-visualizer/admin/country-list");
        exit;
    }

    $data = json_decode($res, true);
    echo $data;
} else {
    // BMI not specified
    header("Location: /obesity-visualizer/admin/country-list");
    exit;
}
