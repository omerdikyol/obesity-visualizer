<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/UserService/userModel.php';

$userService = new UserService();

if (isset($_SESSION['user_id'])) {
    $id = $mysqli->real_escape_string($_SESSION['user_id']);
    $user = $userService->getUser($id);
}