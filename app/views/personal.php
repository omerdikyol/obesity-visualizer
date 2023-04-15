<?php
session_start();
?>

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

    .container {
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
    </style>
</head>

<body>
    <?php include('./includes/header.php'); ?>

    <h1 style="color: black;">My Personal Data</h1>
    <div class="container">
        <table>
            <tr>
                <th>Attribute</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Name</td>
                <td>Ömer</td>
            </tr>
            <tr>
                <td>Surname</td>
                <td>Dikyol</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>omerdikyol@example.com</td>
            </tr>
            <tr>
                <td>Country</td>
                <td>Turkey</td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td>02/04/2002</td>
            </tr>
            <tr>
                <td>Height</td>
                <td>193cm</td>
            </tr>
            <tr>
                <td>Weight</td>
                <td>-</td>
            </tr>
        </table>
        <button class="button_personal" id="editBtn">Edit</button>
        <button class="button_personal" id="exportBtn">Export</button>
    </div>
</body>

<?php include('./includes/footer.php'); ?>

</html>