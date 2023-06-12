<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Obesity Visualizer</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='/obesity-visualizer/public-app/public/css/style.css'>
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/includes/sidenav.php'; ?>

<body>
    <div class="main">
        <h1 style="color: black;">Edit Country</h1>

        <div class=" container" id="edit_container">

            <div class=" container">
                <form action="/obesity-visualizer/public-app/app/models/admin/country_edit.php" method="post" class="form">
                    <label for="id"><?php echo "ID: " . $id ?></label>
                    <label for="bmi">BMI</label>
                    <select id="bmi" name="bmi" required>
                        <option value="BMI25-29" <?php if ($bmi == "BMI25-29") echo 'selected="selected"' ?>>BMI25-29
                        </option>
                        <option value="BMI_GE25" <?php if ($bmi == "BMI_GE25") echo 'selected="selected"' ?>>BMI_GE25
                        </option>
                        <option value="BMI_GE30" <?php if ($bmi == "BMI_GE30") echo 'selected="selected"' ?>>BMI_GE30
                        </option>
                    </select>

                    <label for="geo">Country Code</label>
                    <select id="geo" name="geo" required>
                        <option value="<?php echo $geo ?>"><?php echo $geo ?></option>
                        <?php
                        foreach ($countries as $key => $geo) {
                            echo "<option value='$geo'>$geo</option>";
                        }
                        ?>
                    </select>

                    <label for="year">Year</label>
                    <select id="year" name="year" required>
                        <option value="<?php echo $year ?>"><?php echo $year ?></option>
                        <?php
                        $year = date("Y");
                        for ($i = 1970; $i < $year + 1; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>

                    <label for="value">Percentage</label>
                    <input type="number" step="0.01" id="value" name="value" value="<?php echo $value ?>" required>

                    <input type="submit" value="Submit" class="button1" name="country_edit">
                </form>
                <a href="/obesity-visualizer/admin/country-list" style="text-decoration: none;">
                    <button class="button1">Back</button></a>
            </div>
        </div>
</body>

</html>