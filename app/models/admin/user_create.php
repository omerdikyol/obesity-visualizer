<?php

session_start();

$mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/db/database.php";

if (isset($_POST["user_create"])) {
    $name = $mysqli->real_escape_string($_POST["name"]);
    $email = $mysqli->real_escape_string($_POST["email"]);
    $password = $mysqli->real_escape_string($_POST["password"]);
    $country = $mysqli->real_escape_string($_POST["country"]);
    $date_of_birth = $mysqli->real_escape_string($_POST["date_of_birth"]);
    $height = $mysqli->real_escape_string($_POST["height"]);
    $weight = $mysqli->real_escape_string($_POST["weight"]);


    # Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (name, email, password_hash, country, date_of_birth, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $stmt->error);
    }

    $stmt->bind_param("sssssss", $name, $email, $password_hash, $country, $date_of_birth, $height, $weight);

    $stmt->execute();
    $stmt->close();

    $_SESSION["alert_success"] = "User created successfully";
} else {
    $_SESSION["alert_fail"] = "User not created";
}

header("Location: /obesity-visualizer/app/controllers/admin/users.php");
exit(0);