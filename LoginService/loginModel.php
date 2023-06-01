<?php
if (!isset($mysqli))
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/db/database.php';

class LoginService
{
    function login($input)
    {
        global $mysqli;

        # Check if email exists in database
        $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($input['email']));

        # Execute query
        $result = $mysqli->query($sql);

        # Get user
        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($input['password'], $user['password'])) {
                return $user;
            }
        }
        return null;
    }

    function register($input)
    {
        global $mysqli;

        # Email Validation
        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            // Set error message and redirect to register page
            $_SESSION['alert_fail'] = "Invalid email";
            header('Location: /obesity-visualizer/public-app/app/controllers/register.php');
        }

        # Check if password length is greater than 8
        if (strlen($input['password']) < 8) {
            $_SESSION['alert_fail'] = "Password must be at least 8 characters long";
            header('Location: /obesity-visualizer/public-app/app/controllers/register.php');
        }

        # Password must contain at least one number and one letter
        if (!preg_match('/[a-z]/i', $input['password'])) {
            $_SESSION['alert_fail'] = "Password must contain at least one letter";
            header('Location: /obesity-visualizer/public-app/app/controllers/register.php');
        }
        if (!preg_match('/[0-9]/', $input['password'])) {
            $_SESSION['alert_fail'] = "Password must contain at least one number";
            header('Location: /obesity-visualizer/public-app/app/controllers/register.php');
        }

        # Check if both passwords match
        if ($input['password'] != $input['confirm_password']) {
            $_SESSION['alert_fail'] = "Passwords do not match";
            header('Location: /obesity-visualizer/public-app/app/controllers/register.php');
        }

        # Date Validation
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $input['date_of_birth'])) {
            $_SESSION['alert_fail'] = "Invalid date";
            header('Location: /obesity-visualizer/public-app/app/controllers/register.php');
        }

        # Hash password
        $password_hash = password_hash($input['password'], PASSWORD_DEFAULT);

        # Check if email already exists in database
        $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($input['email']));
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();
        if ($user) {
            $_SESSION['alert_fail'] = "Email already exists";
            header('Location: /obesity-visualizer/public-app/app/controllers/register.php');
        }

        # Insert user into database
        $sql = "INSERT INTO user (name, email, password, country, date_of_birth, height, weight) VALUES (?, ?, ?, ?, ? , ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->bind_param("sssssii", $input['name'], $input['email'], $password_hash, $input['country'], $input['date_of_birth'], $input['height'], $input['weight']);

        $stmt->execute();

        $stmt->close();
    }
}
