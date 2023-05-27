<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the form data
$name = strval($_POST["name"]);
$email = strval($_POST["email"]);
$password = strval(password_hash($_POST["password"], PASSWORD_DEFAULT));
$country = strval($_POST["country"]);
$date_of_birth = strval($_POST["date_of_birth"]);
$height = floatval($_POST["height"]);
$weight = floatval($_POST["weight"]);

// Send the data to the API endpoint
$url = 'http://localhost/obesity-visualizer/admin/users/';
$data = array(
    'name' => $name,
    'email' => $email,
    'password' => $password,
    'country' => $country,
    'date_of_birth' => $date_of_birth,
    'height' => $height,
    'weight' => $weight
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
    header("Location: /obesity-visualizer/app/controllers/admin/users.php");
    exit;
}

if ($httpCode === 201) {
    // User created successfully
    $_SESSION["alert_success"] = "User created successfully";
} else {
    // User not created
    $_SESSION["alert_fail"] = "User not created." . " " . $res . " " . $httpCode . " " . $error . " " . $errno;
}


header("Location: /obesity-visualizer/app/controllers/admin/users.php");
exit(0);