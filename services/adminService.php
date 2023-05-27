<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

if (!isset($mysqli))
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

class AdminService
{
    function adminLogin($username, $password)
    {
        // Check if the submitted credentials are valid
        if ($username === 'admin' && $password === 'admin') {
            // Set the session variable to indicate that the user is logged in
            $_SESSION['admin'] = true;
            return true;
        }
        return false;
    }

    function adminLogout()
    {
        if ($_SESSION['admin'] === true) {
            $_SESSION['admin'] = false;
        }
        header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
        exit;
    }

    function getCountriesAdmin()
    {
        global $mysqli;
        $sql = "SELECT * FROM public_data";
        $result = $mysqli->query($sql);
        $countries = $result->fetch_all(MYSQLI_ASSOC);
        return $countries;
    }

    function getCountryAdmin($id)
    {
        global $mysqli;
        $sql = "SELECT * FROM public_data WHERE id = $id";
        $result = $mysqli->query($sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    // Create country data (used in admin panel)
    function createCountry($input)
    {
        global $mysqli;

        $sql = "INSERT INTO public_data (bmi, geo, year, value) VALUES (?, ?, ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->bind_param("sssd", $input["bmi"], $input["geo"], $input["year"], $input["value"]);

        if (!$stmt->execute()) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->close();
    }

    // Delete country data (used in admin panel)
    function deleteCountry($id)
    {
        global $mysqli;

        $sql = "DELETE FROM public_data WHERE id = ?";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $stmt->close();

        $_SESSION["alert_success"] = "Country Data deleted successfully";
    }

    // Edit country data (used in admin panel)
    function editCountry($id, $input)
    {
        global $mysqli;

        $sql = "UPDATE public_data SET bmi = ?, geo = ?, year = ?, value = ? WHERE id = ?";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->bind_param("sssdi", $input["bmi"], $input["geo"], $input["year"], $input["value"], $id);

        $stmt->execute();

        $stmt->close();

        $_SESSION["alert_success"] = "Country Data updated successfully";
    }

    // Get all users from database (used in admin panel)
    function getUsers()
    {
        global $mysqli;
        $sql = "SELECT * FROM user";
        $result = $mysqli->query($sql);
        $users = $result->fetch_all(MYSQLI_ASSOC);

        return $users;
    }

    // Get user by id (used in admin panel)
    function getUser($id)
    {
        global $mysqli;
        $sql = "SELECT * FROM user WHERE id = $id";
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        return $user;
    }

    // Create user (used in admin panel)
    function createUser($input)
    {
        global $mysqli;

        $sql = "INSERT INTO user (name, email, password, country, date_of_birth, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->bind_param("sssssii", $input["name"], $input["email"], $input["password"], $input["country"], $input["date_of_birth"], $input["height"], $input["weight"]);

        $stmt->execute();

        $stmt->close();
    }

    // Edit user (used in admin panel)
    function editUser($id, $input)
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

    // Delete user (used in admin panel)
    function deleteUser($id)
    {
        global $mysqli;
        $sql = "DELETE FROM user WHERE id = ?";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $stmt->close();
    }
}