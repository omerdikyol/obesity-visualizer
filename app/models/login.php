<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/userService.php';

$userService = new UserService();

$is_invalid = false;
$is_logged_in = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userService->login($is_invalid, $is_logged_in);
}