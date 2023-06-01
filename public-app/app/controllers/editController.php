<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/db/database.php';
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

        # Check if email already exists in database
        $sqlTemp = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST['email']));
        $resultTemp = $mysqli->query($sqlTemp);
        $userTemp = $result->fetch_assoc();
        if ($userTemp) {
            die("Email already exists");
        }

        # Height float Validation
        if (!filter_var($height, FILTER_VALIDATE_FLOAT) && $height != "") {
            die("Invalid height format");
        }

        # Weight float Validation
        if (!filter_var($weight, FILTER_VALIDATE_FLOAT) && $weight != "") {
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
        header("Location: /obesity-visualizer/public-app/app/controllers/personal.php");
    }
}