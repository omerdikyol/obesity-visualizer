<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

if (!isset($mysqli))
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';


// Get user by id from session
function getUserFromSession()
{
    if (isset($_SESSION['user_id'])) {

        global $mysqli;
        $sql = sprintf("SELECT * FROM user WHERE id = '%s'", $mysqli->real_escape_string($_SESSION['user_id']));
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        return $user;
    }
}

function login()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        global $mysqli;

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
}

function register()
{
    global $mysqli;

    # Email Validation
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // Set error message and redirect to register page
        $_SESSION['regError'] = "Invalid email";
        header("Location: /obesity-visualizer/app/controllers/register.php");
        exit;
    }

    # Check if password length is greater than 8
    if (strlen($_POST['password']) < 8) {
        $_SESSION['regError'] = "Password must be at least 8 characters long";
        header("Location: /obesity-visualizer/app/controllers/register.php");
        exit;
    }

    # Password must contain at least one number and one letter
    if (!preg_match('/[a-z]/i', $_POST['password'])) {
        $_SESSION['regError'] = "Password must contain at least one letter";
        header("Location: /obesity-visualizer/app/controllers/register.php");
        exit;
    }
    if (!preg_match('/[0-9]/', $_POST['password'])) {
        $_SESSION['regError'] = "Password must contain at least one number";
        header("Location: /obesity-visualizer/app/controllers/register.php");
        exit;
    }

    # Check if both passwords match
    if ($_POST['password'] != $_POST['confirmPassword']) {
        $_SESSION['regError'] = "Passwords do not match";
        header("Location: /obesity-visualizer/app/controllers/register.php");
        exit;
    }

    # Date Validation
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['dateOfBirth'])) {
        $_SESSION['regError'] = "Invalid date";
        header("Location: /obesity-visualizer/app/controllers/register.php");
        exit;
    }

    # Hash password
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    # Check if email already exists in database
    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST['email']));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    if ($user) {
        $_SESSION['regError'] = "Email already exists";
        header("Location: /obesity-visualizer/app/controllers/register.php");
        exit;
    }

    # Insert user into database
    $sql = "INSERT INTO user (name, email, password_hash, country, date_of_birth) VALUES (?, ?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $stmt->error);
    }

    $stmt->bind_param("sssss", $_POST['username'], $_POST['email'], $password_hash, $_POST['country'], $_POST['dateOfBirth']);

    $stmt->execute();

    $stmt->close();
}