<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id = $_SESSION["edit_id"];
$_SESSION["edit_id"] = null;

$url = 'http://localhost/obesity-visualizer/admin/countries/' . $id;

if (isset($_POST['country_edit'])) {
    // Get the form data
    $bmi = strval($_POST['bmi']);
    $country = strval($_POST['geo']);
    $year = strval($_POST['year']);
    $percentage = floatval($_POST['value']); // Convert to decimal

    // Send the data to the API endpoint
    $data = array(
        'bmi' => $bmi,
        'geo' => $country,
        'year' => $year,
        'value' => $percentage
    );

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'PUT',
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
        header("Location: /obesity-visualizer/app/controllers/admin/countries.php");
        exit;
    }

    if ($httpCode === 200) {
        // Country data created successfully
        $_SESSION["alert_success"] = "Country data updated successfully";
    } else {
        // Country data not created
        $_SESSION["alert_fail"] = "Country data not updated.";
    }
} else {
    $_SESSION["alert_fail"] = "Country data not updated.";
}

header("Location: /obesity-visualizer/app/controllers/admin/countries.php");
exit;