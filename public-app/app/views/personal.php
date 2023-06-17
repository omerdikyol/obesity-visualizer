<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OV | Personal</title>
    <link rel="stylesheet" href="/obesity-visualizer/public-app/public/css/style.css">
    <link rel="icon" href="/obesity-visualizer/public-app/public/images/logoov.ico">
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/header.php"; ?>

    <!-- Check if session user_id exists -->
    <?php if (!isset($_SESSION['user_id'])) : ?>
    <div class="container">
        <h1>You are not logged in!</h1>
        <p style="text-align: center; margin-top: 50px;">Please <a href="login">login</a> to view this page.</p>
    </div>
    <?php else : ?>
    <div class="container" id="data_container">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/alert.php"; ?>
        <div class="exportable" id="exportable">
            <h1>My Personal Data</h1>
            <div class="container">
                <table class="personal-table">
                    <tr>
                        <th>Attribute</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><?php echo $name ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $email ?></td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td><?php echo ucfirst($country) ?></td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td><?php echo $date_of_birth ?></td>
                    </tr>
                    <tr>
                        <td>Height (cm)</td>
                        <td><?php echo $height ?></td>
                    </tr>
                    <tr>
                        <td>Weight (kg)</td>
                        <td><?php echo $weight ?></td>
                    </tr>
                    <tr>
                        <td>BMI</td>
                        <td><?php echo $bmi ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="display: flex;justify-content: center;align-items: center;">
            <button style="margin: 5px;" class=" button1" id="editBtn" onclick="editBtn()">Edit</button>
            <div class="dropdown">
                <button class="button1" id="exportBtn">Export</button>
                <div class="dropdown-content">
                    <a onclick="exportCSV();return false;">as CSV</a>
                    <a onclick="exportPDF();return false;">as PDF</a>
                    <a onclick="exportPNG();return false;">as PNG</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="edit_container" style="display: none;">
        <h1 style="color: black;">Edit Personal Data</h1>
        <div class="container">
            <form action="/obesity-visualizer/public-app/app/models/personal_edit.php" method="post" class="form">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo $name ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email ?>" required>

                <label for="country">Country</label>
                <select id="country" name="country" required>
                    <option value="<?php echo $country ?>"><?php echo ucfirst($country) ?></option>
                    <?php
                        foreach ($countries as $key => $country) {
                            echo "<option value='$country'>$country</option>";
                        }
                        ?>
                </select>

                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $date_of_birth ?>"
                    required>

                <label for="height">Height (cm)</label>
                <input type="number" id="height" name="height" step="0.1" min="0" max="250"
                    value="<?php echo $height ?>">

                <label for="weight">Weight (kg)</label>
                <input type="number" id="weight" name="weight" step="0.1" min="0" max="250"
                    value="<?php echo $weight ?>">

                <div style="display: flex;justify-content: center;align-items: center;">
                    <input type="submit" value="Submit" class="button1">
                    <input type="button" value="Cancel" onclick="window.location.href='/obesity-visualizer/personal'"
                        class="button1">
                </div>

            </form>
        </div>
    </div>
</body>

<?php endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/footer.php"; ?>

</html>