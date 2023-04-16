<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require_once('../db/database.php');
    // Find user from session
    $sql = sprintf("SELECT * FROM user WHERE id = '%s'", $mysqli->real_escape_string($_SESSION['user_id']));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    if ($user) {
        // Get user data from form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $country = $_POST['country'];
        $date_of_birth = $_POST['date_of_birth'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];

        // Data Validation
        # Name Validation
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            die("Only letters and white space allowed");
        }

        # Email Validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format");
        }

        # Height float Validation
        if (!filter_var($height, FILTER_VALIDATE_FLOAT)) {
            die("Invalid height format");
        }

        # Weight float Validation
        if (!filter_var($weight, FILTER_VALIDATE_FLOAT)) {
            die("Invalid weight format");
        }

        // Update user data
        $sql = "UPDATE user SET name = ?, email = ?, country = ?, date_of_birth = ?, height = ?, weight = ? WHERE id = ?";
        $stmt = $mysqli->stmt_init();
        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }
        $stmt->bind_param("ssssiii", $name, $email, $country, $date_of_birth, $height, $weight, $_SESSION['user_id']);

        $stmt->execute();

        $stmt->close();

        $mysqli->close();

        // Redirect to personal page
        header("Location: ../views/personal.php");
    }
}