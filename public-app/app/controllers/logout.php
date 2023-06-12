<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();

header("Location: /obesity-visualizer/home");
exit;