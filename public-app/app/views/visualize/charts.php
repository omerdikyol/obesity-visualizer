<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="/obesity-visualizer/public-app/public/css/style.css">
</head>

<body>
    <section>


        <div class="wrapper">
            <div id="leftOverlay">
                <div id="exportDiv">
                    <label style="display: inline-block;">Export As:</label>
                    <button onclick=" generatePDF()" class="chart-exp-button" style="margin-right: 10px;">PDF</button>
                    <button onclick="generateCSV()" class="chart-exp-button">CSV</button>
                </div>
                <div id="yearDiv">
                    <!-- Add dropdown menu for selecting year and hold that value in a variable -->
                    <label for="year" style="display: inline-block;">Year:</label>
                    <select name="year" id="year" class="select" style="width: auto;">
                        <option value="2008">2008</option>
                        <option value="2014">2014</option>
                        <option value="2017">2017</option>
                        <option value="2019">2019</option>
                    </select>
                </div>

                <div id="bmiDiv">
                    <label for="bmi" style="display: inline-block;">BMI:</label>
                    <!-- Add dropdown menu for selecting body mass index type -->
                    <select name="bmi" id="bmi" class="select" style="width: auto;">
                        <option value="Overweight">Overweight</option>
                        <option value="Pre-obese">Pre-obese</option>
                        <option value="Obese">Obese</option>
                    </select>
                </div>

                <!-- Add reset button -->
                <button onclick="reset()" id="resetButton" class="cool-button">Reset Zoom</button>

                <div id="countryCountDiv">
                    <!-- Add label for country count -->
                    <label for="country_count" style="display: inline-block;">Country Count:</label>
                    <!-- Add dropdown menu for country count -->
                    <select name="country_count" id="country_count" class="select" style="width: auto;">
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
            </div>

            <div id="rightOverlay">
                <h2>Country List</h2>
                <!-- Add div to show list of countries -->
                <ul id="countryList">
                    <?php
                    // Add countries to list
                    foreach ($countries as $country) {
                        echo "<li id='$country' class='country-list-item' onclick='listClicked(this.id)' onmouseover='listHover(this.id)' onmouseout='listOut()'>$country</li>";
                    }
                    ?>
                </ul>
            </div>

            <div style="position: relative;" id="exportable">
                <!-- Add Title with year and bmi type -->
                <h1>Obesity rate by body mass index (BMI)</h1>
                <h3 id="title" style="text-align: center;"></h3>

                <div id="chart-container" class="center-container" style="white-space: nowrap; overflow-x: hidden;">
                    <div id="chart"></div>
                </div>

                <!-- Add info box to show info of clicked country -->
                <div class="info-box" id="info-box" style="position: absolute; top: 5%; right: 20%;">
                    <button onclick="closeInfoBox()" style="position: absolute; top: 0; right: 0;">X</button>
                    <h2 style="margin-top: 0;">Country Information</h2>
                    <p><strong>Country:</strong></p>
                    <p><strong>Year:</strong></p>
                    <p><strong>BMI:</strong></p>
                    <p><strong>Percentage:</strong></p>
                </div>
            </div>
        </div>

    </section>
</body>

</html>