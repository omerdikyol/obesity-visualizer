<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/userService.php';

if (isset($_SESSION['user_id'])) {
    $id = $mysqli->real_escape_string($_SESSION['user_id']);
    $user = getUser($id);
}