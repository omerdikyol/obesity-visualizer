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
    input[type="password"],
    input[type="date"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .buttonRegister {
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

    .buttonRegister:hover {
        background-color: #3e8e41;
    }
    </style>
</head>

<?php include('./includes/header.php'); ?>

<body>
    <h1 style="color: black;">Registration Form</h1>
    <div class="container">
        <form action="../controllers/registerController.php" method="post">
            <label for="Name">Name</label>
            <input type="text" id="username" name="username" placeholder="Enter your name (required)" required>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter your email (required)" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password (required)" required>

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword"
                placeholder="Confirm your password (required)" required>

            <label for="country">Country</label>
            <select id="country" name="country">
                <option value="australia">Australia</option>
                <option value="canada">Canada</option>
                <option value="usa">USA</option>
            </select>

            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth">

            <label for="height">Height</label>
            <input type="text" id="height" name="height" placeholder="Enter your height (optional)">

            <label for="weight">Weight</label>
            <input type="text" id="weight" name="weight" placeholder="Enter your weight (optional)">

            <button type="submit" class="buttonRegister" id="registerBtn">Register</button>
        </form>
    </div>
</body>

<?php include('./includes/footer.php'); ?>

</html>