<?php

$mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

$user_id = $_GET['id'];

$sql = "DELETE FROM user WHERE id = ?";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL Error: " . $stmt->error);
}

$stmt->bind_param("i", $user_id);

$stmt->execute();

$stmt->close();

$mysqli->close();

$_SESSION["alert_success"] = "User deleted successfully";

header("Location: /obesity-visualizer/app/controllers/admin/users.php");