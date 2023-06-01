<!DOCTYPE html>
<html>

<head>
    <title>BMI Calculator | Obesity Visualizer</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/obesity-visualizer/public-app/public/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 400px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }

        .result {
            display: none;
            text-align: center;
            margin-top: 50px;
        }

        .result h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .result p {
            font-size: 24px;
            margin-top: 0;
        }
    </style>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/header.php"; ?>
    </header>
    <h1>BMI Calculator</h1>
    <form onsubmit="calculateBMI(event)">
        <label for="height">Height (cm):</label>
        <input type="number" id="height" name="height" step="0.1" min="0" max="250" placeholder="Enter your height in centimeters" required>
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" step="0.1" min="0" max="250" placeholder="Enter your weight in kilograms" required>
        <input type="submit" value="Calculate BMI" class="bmi-button">
    </form>
    <div class="result" id="result">
        <h2>Your BMI is:</h2>
        <p id="bmi"></p>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/footer.php"; ?>
</body>

</html>