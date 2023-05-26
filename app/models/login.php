<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/userService.php';

$is_invalid = false;
$is_logged_in = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    login($is_invalid, $is_logged_in);
}