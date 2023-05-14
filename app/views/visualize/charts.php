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
        <div id="yearDiv">
            <!-- Add dropdown menu for selecting year and hold that value in a variable -->
            <label for="year" style="display: inline-block;">Year:</label>
            <select name="year" id="year" style="width: auto;">
                <option value="2008">2008</option>
                <option value="2014">2014</option>
                <option value="2017">2017</option>
                <option value="2019">2019</option>
            </select>
        </div>

        <div id="bmiDiv">
            <label for="bmi" style="display: inline-block;">BMI:</label>
            <!-- Add dropdown menu for selecting body mass index type -->
            <select name="bmi" id="bmi" style="width: auto;">
                <option value="Overweight">Overweight</option>
                <option value="Pre-obese">Pre-obese</option>
                <option value="Obese">Obese</option>
            </select>
        </div>

        <!-- Add reset button -->
        <button onclick="reset()" id="resetButton">Reset</button>

        <div id="countryCountDiv">
            <!-- Add label for country count -->
            <label for="country_count" style="display: inline-block;">Country Count:</label>
            <!-- Add dropdown menu for country count -->
            <select name="country_count" id="country_count" style="width: auto;">
                <option value="1">1</option>
                <option value="3">3</option>
                <option value="5" selected="selected">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>

        <!-- Add div to show selected countries information -->
        <p id="country-info"></p>

        <div style="position: relative;" id="exportable">
            <!-- Add Title with year and bmi type -->
            <h1>Obesity rate by body mass index (BMI)</h1>
            <h3 id="title" style="text-align: center;"></h3>

            <div id="chart" style="text-align: center;"></div>

            <!-- Add div to show list of countries -->
            <!-- Add header -->
            <ul style=" position: absolute; top: 0; right: 0; overflow-y: auto; max-height: 100%;" id="countryList">
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