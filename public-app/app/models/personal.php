<?php

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/UserService/userModel.php';

$id = $mysqli->real_escape_string($_SESSION['user_id']);

$url = 'http://localhost/obesity-visualizer/user/' . $id;

$c = curl_init();
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
$res = curl_exec($c);
curl_close($c);

$arr = json_decode($res, true);

if ($arr === null) {
    // JSON decoding failed
    $error = json_last_error_msg();
    echo "JSON decoding error: $error";
} else {
    // Access the values from the array
    $name = $arr['name'] ?? null;
    $email = $arr['email'] ?? null;
    $country = $arr['country'] ?? null;
    $date_of_birth = $arr['date_of_birth'] ?? null;
    $height = $arr['height'] ?? null;
    $weight = $arr['weight'] ?? null;
    $bmi = $arr['bmi'] ?? null;
}