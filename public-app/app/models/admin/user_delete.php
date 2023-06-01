<?php

$id = $mysqli->real_escape_string($_GET['id']);

$url = 'http://localhost/obesity-visualizer/admin/users/' . $id;

$c = curl_init();
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);

$res = curl_exec($c);
var_dump($res);
$error = curl_error($c);
$errno = curl_errno($c);
$info = curl_getinfo($c, CURLINFO_HTTP_CODE);
curl_close($c);

if ($errno !== 0) {
    // cURL error occurred
    $_SESSION["alert_fail"] = "cURL error: " . $error;
    header("Location: /obesity-visualizer/public-app/app/controllers/admin/countries.php");
    exit;
}

if ($info === 200) {
    $_SESSION["alert_success"] = "User data deleted successfully";
} else {
    $_SESSION["alert_fail"] = "User data not deleted";
}

header("Location: /obesity-visualizer/public-app/app/controllers/admin/users.php");