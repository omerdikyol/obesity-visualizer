<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OV | Login</title>
    <link rel="stylesheet" href="/obesity-visualizer/public-app/public/css/style.css">
    <link rel="icon" href="/obesity-visualizer/public-app/public/images/logoov.ico">
</head>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/header.php"; ?>

<body>
    <div class="login-box">
        <h1>Login Form</h1>
        <div class="container" id="login-container">
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/alert.php"; ?>
            <form action="/obesity-visualizer/public-app/app/models/login.php" method="post" class="form">
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
<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/footer.php"; ?>

</html>