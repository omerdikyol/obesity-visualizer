<?php

# Email Validation
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

# Check if password length is greater than 8
if (strlen($_POST['password']) < 8) {
    die("Password must be at least 8 characters long");
}

# Password must contain at least one number and one letter
if (!preg_match('/[a-z]/i', $_POST['password'])) {
    die("Password must contain at least one letter");
}
if (!preg_match('/[0-9]/', $_POST['password'])) {
    die("Password must contain at least one number");
}

# Check if both passwords match
if ($_POST['password'] != $_POST['confirmPassword']) {
    die("Passwords do not match");
}

# Date Validation
if (!preg_match("/^(20[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['dateOfBirth'])) {
    die("Invalid date format");
}

# Hash password
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

# Connect to database
$mysqli = require_once('../db/database.php');

# Insert user into database
$sql = "INSERT INTO user (name, email, password_hash, country, date_of_birth) VALUES (?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL Error: " . $stmt->error);
}

$stmt->bind_param("sssss", $_POST['username'], $_POST['email'], $password_hash, $_POST['country'], $_POST['dateOfBirth']);

$stmt->execute();

$stmt->close();

$mysqli->close();

# Redirect to login page
header("Location: ../views/login.php");