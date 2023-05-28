<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

if (!isset($mysqli))
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

class UserService
{

    // Get user by id from session
    function getUser($id)
    {
        global $mysqli;
        $sql = sprintf("SELECT * FROM user WHERE id = '%s'", $mysqli->real_escape_string($id));
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        return $user;
    }

    function login($is_invalid, $is_logged_in)
    {
        global $mysqli;

        # Check if email exists in database
        $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST['email']));

        # Execute query
        $result = $mysqli->query($sql);

        # Get user
        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($_POST['password'], $user['password'])) {
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

    function getPersonalData($id)
    {
        global $mysqli;
        // Get user data
        $user = $this->getUser($id);

        if ($user) {
            $name = $user['name'];
            $email = $user['email'];
            $country = $user['country'];
            $date_of_birth = $user['date_of_birth'];
            $height = ($user['height'] == 0) ? "-" : $user['height'];
            $weight = ($user['weight'] == 0) ? "-" : $user['weight'];
            $bmi = "-";
        }

        # if height and weight are set, calculate BMI
        if ($height != "-" && $weight != "-" && $height != 0 && $weight != 0) {
            $bmi = $weight / (($height / 100) * ($height / 100));
            $bmi = round($bmi, 2);

            # if BMI is less than 18.5, it is underweight
            if ($bmi < 18.5) {
                $bmi = $bmi . " (Underweight)";
            }
            # if BMI is between 18.5 and 24.9, it is normal
            else if ($bmi >= 18.5 && $bmi <= 24.9) {
                $bmi = $bmi . " (Normal)";
            }
            # if BMI is between 25 and 29.9, it is overweight
            else if ($bmi >= 25 && $bmi <= 29.9) {
                $bmi = $bmi . " (Overweight)";
            }
            # if BMI is greater than 30, it is obese
            else if ($bmi > 30) {
                $bmi = $bmi . " (Obese)";
            }

            # update user's BMI in database
            $sql = sprintf("UPDATE user SET bmi = '%s' WHERE id = '%s'", $mysqli->real_escape_string($bmi), $mysqli->real_escape_string($id));
            $mysqli->query($sql);
        }

        $arr = array(
            "name" => $name,
            "email" => $email,
            "country" => $country,
            "date_of_birth" => $date_of_birth,
            "height" => $height,
            "weight" => $weight,
            "bmi" => $bmi
        );

        return $arr;
    }

    function editPersonalData($id, $input)
    {
        global $mysqli;

        $sql = "UPDATE user SET name = ?, email = ?, country = ?, date_of_birth = ?, height = ?, weight = ? WHERE id = ?";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->bind_param("ssssiii", $input["name"], $input["email"], $input["country"], $input["date_of_birth"], $input["height"], $input["weight"], $id);

        $stmt->execute();

        $stmt->close();
    }
}