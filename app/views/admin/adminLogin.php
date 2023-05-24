<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="/obesity-visualizer/public/css/style.css">
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/includes/sidenav.php'; ?>

<body>

    <div class="main">

        <div class="login-box">
            <h1>Admin Login Form</h1>
            <div class="container" id="login-container">
                <form method="post" action="/obesity-visualizer/app/models/admin/adminLogin.php">
                    <label>Username:</label>
                    <input type="text" name="username"><br>

                    <label>Password:</label>
                    <input type="password" name="password"><br>

                    <button type="submit" class="button1" id="loginBtn">Login</button>
                </form>
            </div>
        </div>

    </div>
</body>

</html>