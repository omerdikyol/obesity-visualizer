<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Obesity Visualizer</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='/obesity-visualizer/public/css/style.css'>
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/includes/sidenav.php'; ?>

<body>
    <div class="main">
        <h1 style="color: black;">Add Country Data</h1>
        <div class="container" id="edit_container">

            <div class=" container">
                <form action="/obesity-visualizer/app/models/admin/country_create.php" method="post" class="form">
                    <label for="bmi">BMI</label>
                    <select id="bmi" name="bmi" required>
                        <option value="BMI25-29">BMI25-29</option>
                        <option value="BMI_GE25">BMI_GE25</option>
                        <option value="BMI_GE30">BMI_GE30</option>
                    </select>

                    <label for="country">Country Code</label>
                    <select id="geo" name="geo" required>
                        <?php
                        foreach ($countryCodes as $key => $countryCode) {
                            echo "<option value='$countryCode'>$countryCode</option>";
                        }
                        ?>
                    </select>

                    <label for="year">Year</label>
                    <select id="year" name="year" required>
                        <?php
                        for ($i = 1975; $i <= 2023; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>

                    <label for="percentage">Percentage</label>
                    <input type="number" step="0.01" id="value" name="value">

                    <input type="submit" value="Submit" class="button1" name="country_create">
                </form>
                <a href="/obesity-visualizer/app/controllers/admin/countries.php" style="text-decoration: none;">
                    <button class="button1" id="countriesBtn">Back</button>
                </a>
            </div>
        </div>
</body>

</html>