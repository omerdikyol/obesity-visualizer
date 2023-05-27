<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id = $_SESSION["edit_id"];
$_SESSION["edit_id"] = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $name = strval($_POST["name"]);
    $email = strval($_POST["email"]);
    $country = strval($_POST["country"]);
    $date_of_birth = strval($_POST["date_of_birth"]);
    $height = floatval($_POST["height"]);
    $weight = floatval($_POST["weight"]);

    $url = 'http://localhost/obesity-visualizer/admin/users/' . $id;

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
        header("Location: /obesity-visualizer/app/controllers/admin/users.php");
        exit;
    }

    if ($httpCode === 200) {
        // User created successfully
        $_SESSION["alert_success"] = "User updated successfully";
    } else {
        // User not created
        $_SESSION["alert_fail"] = "User not updated.";
    }
} else {
    $_SESSION["alert_fail"] = "User edit failed";
}

header("Location: /obesity-visualizer/app/controllers/admin/users.php");
exit(0);