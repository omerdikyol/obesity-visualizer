<!DOCTYPE html>
<html>

<head>
    <title>OV | BMI Calculator</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/obesity-visualizer/public-app/public/css/style.css">
    <link rel="icon" href="/obesity-visualizer/public-app/public/images/logoov.ico">
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/header.php"; ?>
    </header>
    <h1>BMI Calculator</h1>
    <form class="bmiForm" onsubmit="calculateBMI(event)">
        <label for="height">Height (cm):</label>
        <input type="number" id="height" name="height" class="bmiInput" step="0.1" min="0" max="250"
            placeholder="Enter your height in centimeters" required>
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" class="bmiInput" step="0.1" min="0" max="250"
            placeholder="Enter your weight in kilograms" required>
        <input type="submit" value="Calculate BMI" class="button1">
    </form>
    <div class="bmiResult" id="result">
        <h2>Your BMI is:</h2>
        <p id="bmi"></p>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/footer.php"; ?>
</body>

</html>