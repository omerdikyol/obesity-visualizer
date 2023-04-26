<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/header.php"; ?>

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
<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/footer.php"; ?>

</html>