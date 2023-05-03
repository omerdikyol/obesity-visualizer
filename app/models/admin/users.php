<?php

$mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

$sql = "SELECT * FROM user";

$result = $mysqli->query($sql);

$users = $result->fetch_all(MYSQLI_ASSOC);

$mysqli->close();