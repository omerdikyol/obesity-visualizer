<?php

$mysqli = include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/db/database.php';

$sql = "SELECT * FROM public_data";

$result = $mysqli->query($sql);

$countries = $result->fetch_all(MYSQLI_ASSOC);

$mysqli->close();