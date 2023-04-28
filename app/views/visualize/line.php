<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="/obesity-visualizer/public/css/style.css">
</head>

<body>
    <section>
        <!-- Add dropdown menu for selecting body mass index type -->
        <select name="bmi" id="bmi" style="width: auto;">
            <option value="Overweight">Overweight</option>
            <option value="Pre-obese">Pre-obese</option>
            <option value="Obese">Obese</option>
        </select>

        <!-- Add reset button -->
        <button onclick="reset()">Reset</button>

        <!-- Add div to show selected countries information -->
        <p id="country-info"></p>

        <div style="position: relative;">
            <div id="line"></div>
            <!-- Add pie chart -->

            <!-- Add div to show list of countries -->
            <!-- Add header -->
            <ul style=" position: absolute; top: 0; right: 0; overflow-y: auto; max-height: 100%;">
                <?php
                // Add countries to list
                foreach ($countries as $country) {
                    echo "<li id='$country' class='country-list-item' onclick='listClicked(this.id)' onmouseover='listHover(this.id)' onmouseout='listOut()'>$country</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Add info box to show info of clicked country -->
        <div class="info-box" id="info-box" style="position: absolute; top: 5%; right: 20%;">
            <h2 style="margin-top: 0;">Country Information</h2>
            <p><strong>Country:</strong></p>
            <p><strong>Year:</strong></p>
            <p><strong>BMI:</strong></p>
            <p><strong>Percentage:</strong></p>
        </div>
    </section>
</body>

</html>