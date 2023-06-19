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
        if (empty($input["email"])) {
            return -1;
        }

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            return -2;
        }

        # Check if password length is greater than 8
        if (strlen($input['password']) < 8) {
            return -3;
        }

        # Password must contain at least one number and one letter
        if (!preg_match("#[0-9]+#", $input['password']) || !preg_match("#[a-zA-Z]+#", $input['password'])) {
            return -4;
        }

        # Check if both passwords match
        if ($input['password'] != $input['confirm_password']) {
            return -5;
        }

        # Date Validation (must be in the years 1900-2020)
        if (empty($input["date_of_birth"])) {
            $_SESSION['alert_fail'] = "Date of birth is required";
            return -6;
        } else {
            $date_of_birth = $this->input_data($input["date_of_birth"]);
            if (!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date_of_birth)) {
                return -7;
            } else {
                $year = substr($date_of_birth, 0, 4);
                if ($year < 1900 || $year > 2020) {
                    return -8;
                }
            }
        }

        # Hash password
        $password_hash = password_hash($input['password'], PASSWORD_DEFAULT);

        # Check if email already exists in database
        $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($input['email']));
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();
        if ($user) {
            return -9;
        }

        # Insert user into database
        $sql = "INSERT INTO user (name, email, password, country, date_of_birth, height, weight) VALUES (?, ?, ?, ?, ? , ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            return -10;
        }

        $stmt->bind_param("sssssii", $input['name'], $input['email'], $password_hash, $input['country'], $input['date_of_birth'], $input['height'], $input['weight']);

        $stmt->execute();

        $stmt->close();

        return 1;
    }

    function input_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}