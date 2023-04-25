<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<?php include('./includes/header.php'); ?>

<body>
    <h1>Registration Form</h1>
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
                <?php
                // Get all countries from the array in countries.php
                $countries = include '../helper/countries.php';
                foreach ($countries as $key => $country) {
                    echo "<option value='$country'>$country</option>";
                }
                ?>
            </select>

            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth">

            <label for="height">Height (cm)</label>
            <input type="text" id="height" name="height" placeholder="Enter your height (optional)">

            <label for="weight">Weight (kg)</label>
            <input type="text" id="weight" name="weight" placeholder="Enter your weight (optional)">

            <button type="submit" class="button1" id="registerBtn">Register</button>
        </form>
    </div>
</body>

<?php include('./includes/footer.php'); ?>

</html>