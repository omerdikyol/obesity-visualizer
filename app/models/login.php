<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require_once('../db/database.php');

    # Check if email exists in database
    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST['email']));

    # Execute query
    $result = $mysqli->query($sql);

    # Get user
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST['password'], $user['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $is_logged_in = true;
            # Redirect to home page
            header("Location: /obesity-visualizer/app/controllers/home.php");
            exit;
        }
    }

    $is_invalid = true;
}