<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

    $user_id = $_SESSION["edit_id"];
    echo $user_id;

    $_SESSION["edit_id"] = null;

    $sql = "SELECT * FROM user WHERE id = $mysqli->real_escape_string($user_id)";

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
    $stmt->bind_param("ssssiii", $name, $email, $country, $date_of_birth, $height, $weight, $user_id);

    $stmt->execute();

    $stmt->close();

    $mysqli->close();

    $_SESSION["alert_success"] = "User edited successfully";
} else {
    $_SESSION["alert_fail"] = "User edit failed";
}

header("Location: /obesity-visualizer/app/controllers/admin/users.php");
exit(0);