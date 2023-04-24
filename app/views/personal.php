<?php
session_start();

// Check if session user_id exists
if (isset($_SESSION['user_id'])) {

    $mysqli = require_once('../db/database.php');

    $sql = sprintf("SELECT * FROM user WHERE id = '%s'", $mysqli->real_escape_string($_SESSION['user_id']));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        $name = $user['name'];
        $email = $user['email'];
        $country = $user['country'];
        $date_of_birth = $user['date_of_birth'];
        $height = ($user['height'] == 0) ? "-" : $user['height'];
        $weight = ($user['weight'] == 0) ? "-" : $user['weight'];
        $bmi = "-";
    }

    # if height and weight are set, calculate BMI
    if ($height != "-" && $weight != "-") {
        $bmi = $weight / (($height / 100) * ($height / 100));
        $bmi = round($bmi, 2);

        # if BMI is less than 18.5, it is underweight
        if ($bmi < 18.5) {
            $bmi = $bmi . " (Underweight)";
        }
        # if BMI is between 18.5 and 24.9, it is normal
        else if ($bmi >= 18.5 && $bmi <= 24.9) {
            $bmi = $bmi . " (Normal)";
        }
        # if BMI is between 25 and 29.9, it is overweight
        else if ($bmi >= 25 && $bmi <= 29.9) {
            $bmi = $bmi . " (Overweight)";
        }
        # if BMI is greater than 30, it is obese
        else if ($bmi > 30) {
            $bmi = $bmi . " (Obese)";
        }

        # update user's BMI in database
        $sql = sprintf("UPDATE user SET bmi = '%s' WHERE id = '%s'", $mysqli->real_escape_string($bmi), $mysqli->real_escape_string($_SESSION['user_id']));
        $mysqli->query($sql);
    }
}
?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>



<script>
// Edit button function
function editBtn() {
    // Remove Data table and show form
    document.getElementById('data_container').style.display = 'none';
    document.getElementById('edit_container').style.display = 'block';
}

// Export button function
function exportCSV() {
    // Export data to CSV file
    window.location.href = '../controllers/exportCSVController.php';
}

function exportPDF() {
    var HTML_Width = $(".exportable").width();
    var HTML_Height = $(".exportable").height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    html2canvas(document.getElementById('exportable')).then(function(canvas) {
        var imgData = canvas.toDataURL("image/png", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'PNG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        pdf.save("user_data.pdf");
    });
}

function exportPNG() {
    html2canvas(document.getElementById('exportable')).then(function(canvas) {
        var ctx = canvas.getContext('2d');

        // set the ctx to draw beneath your current content
        ctx.globalCompositeOperation = 'destination-over';

        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        var img = canvas.toDataURL("image/png");
        saveAs(img, 'user_data.png');
    });
}
</script>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
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

    .data_container,
    .edit_container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        margin-top: 30px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f5f5f5;
        font-weight: bold;
        color: #333;
    }

    .button_personal {
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

    .button_personal:hover {
        background-color: #3e8e41;
    }

    .edit_container {
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
    input[type="number"],
    input[type="email"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    /* Dropdown Button */
    .dropbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;

    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
    </style>
</head>

<body>
    <?php include('./includes/header.php'); ?>

    <!-- Check if session user_id exists -->
    <?php if (!isset($_SESSION['user_id'])) : ?>
    <div class="container">
        <h1 style="color: black;">You are not logged in!</h1>
        <p style="color: black;">Please <a href="login.php">login</a> to view this page.</p>
    </div>
    <?php else : ?>
    <div class="data_container" id="data_container">
        <div class="exportable" id="exportable">
            <h1 style="color: black;">My Personal Data</h1>
            <div class="container">
                <table>
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
        <button class="button_personal" id="editBtn" onclick="editBtn()">Edit</button>
        <div class="dropdown">
            <button class="button_personal" id="exportBtn">Export</button>
            <div class="dropdown-content">
                <a href="#" onclick="exportCSV();return false;">as CSV</a>
                <a href="#" onclick="exportPDF();return false;">as PDF</a>
                <a href="#" onclick="exportPNG();return false;">as PNG</a>
            </div>
        </div>
    </div>

    <div class="edit_container" id="edit_container" style="display: none;">
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
                        // Get countries from helper file   
                        $countries = include '../helper/countries.php';
                        foreach ($countries as $key => $country) {
                            echo "<option value='$country'>$country</option>";
                        }
                        ?>
                </select>

                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $date_of_birth ?>"
                    required>

                <label for="height">Height (cm)</label>
                <input type="number" id="height" name="height" value="<?php echo $height ?>" required>

                <label for="weight">Weight (kg)</label>
                <input type="number" id="weight" name="weight" value="<?php echo $weight ?>" required>

                <input type="submit" value="Submit" class="edit_button">
                <input type="button" value="Cancel" onclick="window.location.href='personal.php'" class="edit_button">
            </form>
        </div>
</body>

<?php endif; ?>

<?php include('./includes/footer.php'); ?>

</html>