<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get user's data from database
$mysqli = require_once('obesity-visualizer/public-app/app/db/database.php');
$sql = sprintf("SELECT * FROM user WHERE id = '%s'", $mysqli->real_escape_string($_SESSION['user_id']));
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

// Create table with user's data
$table = '<tr><td>Name</td><td>' . $user['name'] . '</td></tr>';
$table .= '<tr><td>Email</td><td>' . $user['email'] . '</td></tr>';
$table .= '<tr><td>Country</td><td>' . $user['country'] . '</td></tr>';
$table .= '<tr><td>Date of Birth</td><td>' . $user['date_of_birth'] . '</td></tr>';
$table .= '<tr><td>Height</td><td>' . $user['height'] . ' cm' . '</td></tr>';
$table .= '<tr><td>Weight</td><td>' . $user['weight'] . ' kg' . '</td></tr>';
$table .= '<tr><td>BMI</td><td>' . $user['bmi'] . '</td></tr>';

// Create a new CSV file and write the column headers and rows from the HTML table to the file.
$file = 'user_data.csv';
file_put_contents($file, 'Attribute,,Value' . "\n");
$rows = preg_match_all('/<tr>(.*?)<\/tr>/', $table, $matches);
for ($i = 0; $i < $rows; $i++) {
    $row = preg_replace('/<.*?>/', ',', $matches[1][$i]);
$row = rtrim($row, ',');
$row = ltrim($row, ',');
file_put_contents($file, $row .
"\n", FILE_APPEND);
}

// Set the headers of the response to force the download of the CSV file.
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="user_data.csv";');
readfile('user_data.csv');

// Delete the CSV file from current folder.
unlink('user_data.csv');