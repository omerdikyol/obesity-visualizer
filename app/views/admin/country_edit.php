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
        <h1 style="color: black;">Edit User</h1>

        <div class=" container" id="edit_container">

            <div class=" container">
                <form action="/obesity-visualizer/app/models/admin/country_edit_form.php" method="post" class="form">
                    <label for="bmi">BMI</label>
                    <select id="bmi" name="bmi" required>
                        <option value="BMI25-29">BMI25-29</option>
                        <option value="BMI_GE25">BMI_GE25</option>
                        <option value="BMI_GE30">BMI_GE30</option>
                    </select>

                    <label for="geo">Country Code</label>
                    <select id="geo" name="geo" required>
                        <option value="<?php echo $geo ?>"><?php echo $geo ?></option>
                        <?php
                        foreach ($geos as $key => $geo) {
                            echo "<option value='$geo'>$geo</option>";
                        }
                        ?>
                    </select>

                    <label for="year">Year</label>
                    <select id="year" name="year" required>
                        <option value="<?php echo $year ?>"><?php echo $year ?></option>
                        <?php
                        foreach ($years as $key => $year) {
                            echo "<option value='$year'>$year</option>";
                        }
                        ?>
                    </select>

                    <label for="value">Percentage</label>
                    <input type="number" step="0.01" id="value" name="value" value="<?php echo $value ?>" required>

                    <input type="submit" value="Submit" class="button1" name="country_edit">
                </form>
                <a href="/obesity-visualizer/app/controllers/admin/countries.php">
                    <button class="button1">Back</button></a>
            </div>
        </div>
</body>

</html>