<?php

session_start();

if (isset($_SESSION['user_id'])) {

    $mysqli = require_once('../db/database.php');

    $sql = sprintf("SELECT * FROM user WHERE id = '%s'", $mysqli->real_escape_string($_SESSION['user_id']));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/home.php';