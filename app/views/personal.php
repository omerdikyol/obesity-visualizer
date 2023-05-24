<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/header.php"; ?>

    <!-- Check if session user_id exists -->
    <?php if (!isset($_SESSION['user_id'])) : ?>
    <div class="container">
        <h1>You are not logged in!</h1>
        <p style="text-align: center; margin-top: 50px;">Please <a href="login.php">login</a> to view this page.</p>
    </div>
    <?php else : ?>
    <div class="container" id="data_container">
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
        <button class="button1" id="editBtn" onclick="editBtn()">Edit</button>
        <div class="dropdown">
            <button class="button1" id="exportBtn">Export</button>
            <div class="dropdown-content">
                <a href="#" onclick="exportCSV();return false;">as CSV</a>
                <a href="#" onclick="exportPDF();return false;">as PDF</a>
                <a href="#" onclick="exportPNG();return false;">as PNG</a>
            </div>
        </div>
    </div>

    <div class="container" id="edit_container" style="display: none;">
        <h1 style="color: black;">Edit Personal Data</h1>
        <div class="container">
            <form action="../controllers/editController.php" method="post" class="form">
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

                <input type="submit" value="Submit" class="edit_button">
                <input type="button" value="Cancel" onclick="window.location.href='personal.php'" class="edit_button">
            </form>
        </div>
</body>

<?php endif; ?>


<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/footer.php"; ?>

</html>