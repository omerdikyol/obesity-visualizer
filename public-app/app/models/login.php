<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

$is_invalid = false;
$is_logged_in = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $url = 'http://localhost/obesity-visualizer/auth/login';

    $input = array(
        'email' => strval($_POST['email']),
        'password' => strval($_POST['password'])
    );

    // Create a new cURL resource
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($input));

    $res = curl_exec($c);
    $error = curl_error($c);
    $errno = curl_errno($c);
    $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);
    curl_close($c);

    $data = json_decode($res, true);


    if ($data['user'] !== null) { // User found
        $is_logged_in = true;
        $_SESSION['user'] = true;
        $_SESSION['user_id'] = $data['user']['id'];
        $_SESSION['alert_success'] = 'Logged in successfully.';
    } else { // User not found
        $is_invalid = true;
        $_SESSION['alert_fail'] = 'Invalid email or password.';
        header("Location: /obesity-visualizer/login");
        exit;
    }

    // Check for errors
    if ($errno !== 0) {
        // cURL error occurred
        $_SESSION["alert_fail"] = "cURL error: " . $error;
        header("Location: /obesity-visualizer/login");
        exit;
    }

    if ($httpCode === 200) {
        // User logged in successfully
        header("Location: /obesity-visualizer/home");
        exit;
    }

    if ($httpCode === 400) {
        // Bad request
        $_SESSION["alert_fail"] = "Bad request";
        header("Location: /obesity-visualizer/login");
        exit;
    }

    if ($httpCode === 401) {
        // Unauthorized
        $_SESSION["alert_fail"] = "Unauthorized";
        header("Location: /obesity-visualizer/login");
        exit;
    }

    if ($httpCode === 404) {
        // Not found
        $_SESSION["alert_fail"] = "Not found";
        header("Location: /obesity-visualizer/login");
        exit;
    }
}
