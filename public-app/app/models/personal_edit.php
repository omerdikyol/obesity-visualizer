<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id = $_SESSION['user_id'];

// Get the form data
$name = strval($_POST['name']);
$email = strval($_POST['email']);
$country = strval($_POST['country']);
$date_of_birth = strval($_POST['date_of_birth']);
$height = floatval($_POST['height']);
$weight = floatval($_POST['weight']);

$url = 'http://localhost/obesity-visualizer/user/' . $id;

// Send the data to the API endpoint
$data = array(
    'name' => $name,
    'email' => $email,
    'country' => $country,
    'date_of_birth' => $date_of_birth,
    'height' => $height,
    'weight' => $weight
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
    header("Location: /obesity-visualizer/public-app/app/controllers/user/profile.php");
    exit;
}

if ($httpCode === 200) {
    // User data updated successfully
    $_SESSION["alert_success"] = "User data updated successfully";
} else {
    // User data not updated
    $_SESSION["alert_fail"] = "User data not updated.";
}

header("Location: /obesity-visualizer/personal");
exit;
