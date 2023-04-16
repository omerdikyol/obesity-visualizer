<?php

session_start();

if (isset($_SESSION['user_id'])) {

    $mysqli = require_once('../db/database.php');

    $sql = sprintf("SELECT * FROM user WHERE id = '%s'", $mysqli->real_escape_string($_SESSION['user_id']));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

</head>
<?php include('./includes/header.php'); ?>

<body>
    <h1>Home</h1>

    <?php if (isset($user)) : ?>
    <p>Welcome, <?php echo $user['name']; ?>!</p>
    <?php else : ?>
    <p><a href="login.php">Login</a> or <a href="register.php">Register</a></p>

    <?php endif; ?>
</body>
<?php include('./includes/footer.php'); ?>

</html>