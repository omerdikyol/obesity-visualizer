<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle the form submission
if (isset($_POST['country_create'])) {
    // Get the form data
    $bmi = strval($_POST['bmi']);
    $country = strval($_POST['geo']);
    $year = strval($_POST['year']);
    $percentage = floatval($_POST['value']); // Convert to decimal

    // Perform any validation or processing if needed

    // Send the data to the API endpoint
    $url = 'http://localhost/obesity-visualizer/admin/countries';
    $data = array(
        'bmi' => $bmi,
        'geo' => $country,
        'year' => $year,
        'value' => $percentage
    );

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_SSL_VERIFYPEER => false
    );

    $c = curl_init();
    curl_setopt_array($c, $options);

    $res = curl_exec($c);
    $error = curl_error($c);
    $errno = curl_errno($c);
    $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);

    curl_close($c);

    if ($errno !== 0) {
        // cURL error occurred
        $_SESSION["alert_fail"] = "cURL error: " . $error;
        header("Location: /obesity-visualizer/admin/country-list");
        exit;
    }

    if ($httpCode === 201) {
        // Country data created successfully
        $_SESSION["alert_success"] = "Country data created successfully";
    } else {
        // Country data not created
        $_SESSION["alert_fail"] = "Country data not created.";
    }

    header("Location: /obesity-visualizer/admin/country-list");
    exit;
}
