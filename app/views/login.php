<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require_once('../db/database.php');

    # Check if email exists in database
    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST['email']));

    # Execute query
    $result = $mysqli->query($sql);

    # Get user
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST['password'], $user['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $is_logged_in = true;
            # Redirect to home page
            header("Location: ../views/home.php");
            exit;
        }
    }

    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<?php include('./includes/header.php'); ?>

<body>
    <div class="login-box">
        <h1>Login Form</h1>
        <div class="container" id="login-container">

            <?php if ($is_invalid) : ?>
            <em>Invalid Email or Password</em>
            <?php endif; ?>

            <form method="post">
                <label id="login-label" for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required
                    value="<?= htmlspecialchars($_POST["email"] ??  "") ?>">
                <!-- If user enters credentials wrong, it is most likely the password. So keep the same email using value -->
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit" class="button1" id="loginBtn">Login</button>
            </form>
        </div>
    </div>
</body>
<?php include('./includes/footer.php'); ?>

</html>