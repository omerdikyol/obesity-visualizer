<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

if (!isset($mysqli))
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';


function getCountriesAdmin()
{
    global $mysqli;
    $sql = "SELECT * FROM public_data";
    $result = $mysqli->query($sql);
    $countries = $result->fetch_all(MYSQLI_ASSOC);
    return $countries;
}

function getCountry($id)
{
    global $mysqli;
    $sql = "SELECT * FROM public_data WHERE id = $id";
    $result = $mysqli->query($sql);
    $data = $result->fetch_assoc();
    return $data;
}

// Create country data (used in admin panel)
function createCountry()
{
    global $mysqli;
    if (isset($_POST["country_create"])) {
        $bmi = $mysqli->real_escape_string($_POST["bmi"]);
        $country = $mysqli->real_escape_string($_POST["country"]);
        $year = $mysqli->real_escape_string($_POST["year"]);
        $percentage = $mysqli->real_escape_string($_POST["percentage"]);

        $sql = "INSERT INTO public_data (bmi, geo, year, value) VALUES (?, ?, ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " . $stmt->error);
        }

        $stmt->bind_param("ssss", $bmi, $country, $year, $percentage);

        $stmt->execute();
        $stmt->close();

        $_SESSION["alert_success"] = "Country data created successfully";
    } else {
        $_SESSION["alert_fail"] = "Country data not created";
    }
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
function editCountry($id)
{
    global $mysqli;
    $bmi = $mysqli->real_escape_string($_POST['bmi']);
    $geo = $mysqli->real_escape_string($_POST['geo']);
    $year = $mysqli->real_escape_string($_POST['year']);
    $value = $mysqli->real_escape_string($_POST['value']);

    $sql = "UPDATE public_data SET bmi = ?, geo = ?, year = ?, value = ? WHERE id = ?";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $stmt->error);
    }
    $stmt->bind_param("ssssi", $bmi, $geo, $year, $value, $id);

    $stmt->execute();

    $stmt->close();
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
function createUser()
{
    global $mysqli;

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
}

// Edit user (used in admin panel)
function editUser($id)
{
    global $mysqli;
    $sql = "SELECT * FROM user WHERE id = $mysqli->real_escape_string($id)";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $country = $_POST['country'];
        $date_of_birth = $_POST['date_of_birth'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];
    }

    // Update user data
    $sql = "UPDATE user SET name = ?, email = ?, country = ?, date_of_birth = ?, height = ?, weight = ? WHERE id = ?";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL Error: " . $stmt->error);
    }
    $stmt->bind_param("ssssiii", $name, $email, $country, $date_of_birth, $height, $weight, $id);

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