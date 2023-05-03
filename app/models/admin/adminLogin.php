<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the submitted credentials are valid
    if ($username === 'admin' && $password === 'admin') {
        // Set the session variable to indicate that the user is logged in
        $_SESSION['admin'] = true;

        // Redirect the user to the admin dashboard page
        header('Location: /obesity-visualizer/app/controllers/admin.php');
        exit;
    } else {
        // Display an error message
        $error = 'Invalid username or password';
        header('Location: /obesity-visualizer/app/controllers/admin/adminLogin.php');
    }
}