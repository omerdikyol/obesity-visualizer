<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
    /* CSS Code to Style the Page */
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        margin-top: 50px;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .buttonLogin {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .buttonLogin:hover {
        background-color: #3e8e41;
    }
    </style>



</head>
<?php include('./includes/header.php'); ?>

<body>
    <div class="login-box">
        <h1 style="color: black;">Login Form</h1>
        <div class="container">
            <form>
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit" class="buttonLogin" id="loginBtn">Login</button>
            </form>
        </div>
    </div>
</body><?php include('./includes/footer.php');
        ?>

</html>