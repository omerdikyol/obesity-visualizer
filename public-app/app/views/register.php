<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="/obesity-visualizer/public-app/public/css/style.css">
    <style>
    .password-requirements {
        list-style-type: disc;
        padding-left: 20px;
        margin-top: 0;
        margin-bottom: 20px;
    }

    .password-requirements li {
        margin-bottom: 5px;
        color: gray;
        font-size: smaller;
    }
    </style>
</head>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/header.php"; ?>

<body>
    <h1>Registration Form</h1>
    <div class="container">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/alert.php"; ?>
        <form action="/obesity-visualizer/public-app/app/models/register.php" method="post" class="form">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name (required)" required>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter your email (required)" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password (required)" required>
            <ul class="password-requirements">
                <li>Password must be at least 8 characters long.</li>
                <li>Password must contain at least one digit and one number.</li>
            </ul>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password"
                placeholder="Confirm your password (required)" required>

            <label for="country">Country</label>
            <select id="country" name="country">
                <?php
                foreach ($countries as $key => $country) {
                    echo "<option value='$country'>$country</option>";
                }
                ?>
            </select>

            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth">

            <label for="height">Height (cm)</label>
            <input type="text" id="height" name="height" placeholder="Enter your height (optional)">

            <label for="weight">Weight (kg)</label>
            <input type="text" id="weight" name="weight" placeholder="Enter your weight (optional)">

            <button type="submit" class="button1" id="registerBtn">Register</button>
        </form>
    </div>
</body>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/footer.php"); ?>

</html>