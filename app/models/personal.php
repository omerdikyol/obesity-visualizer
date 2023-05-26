<?php

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/userService.php';

$id = $mysqli->real_escape_string($_SESSION['user_id']);

$data = getPersonalData($id);

$data = json_decode($data, true);

$name = $data['name'];
$email = $data['email'];
$country = $data['country'];
$date_of_birth = $data['date_of_birth'];
$height = $data['height'];
$weight = $data['weight'];
$bmi = $data['bmi'];;