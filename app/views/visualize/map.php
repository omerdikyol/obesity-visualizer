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
        <!-- Add dropdown menu for selecting year and hold that value in a variable -->
        <select name="year" id="year" style="width: auto;">
            <option value="2008">2008</option>
            <option value="2014">2014</option>
            <option value="2017">2017</option>
            <option value="2019">2019</option>
        </select>

        <!-- Add dropdown menu for selecting body mass index type -->
        <select name="bmi" id="bmi" style="width: auto;">
            <option value="Overweight">Overweight</option>
            <option value="Pre-obese">Pre-obese</option>
            <option value="Obese">Obese</option>
        </select>

        <!-- Add div to show selected countries information -->
        <p id="country-info"></p>

        <div style="position: relative;">
            <!-- Add svg map -->
            <object id="europe-map" type="image/svg+xml" data="/obesity-visualizer/public/images/europe.svg"></object>
            <!-- Add div to show country name -->
            <div id="country-name"></div>

            <!-- Add div to show list of countries -->
            <!-- Add header -->
            <ul style=" position: absolute; top: 0; right: 0; overflow-y: auto; max-height: 100%;">
                <?php
                // Add countries to list
                foreach ($countries as $country) {
                    echo "<li id='$country' class='country-list-item' onclick='countryClicked(this.id)'>$country</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Add info box to show info of clicked country -->
        <div class="info-box" id="info-box" style="position: absolute; top: 5%; right: 30%;">
            <h2 style="margin-top: 0;">Country Information</h2>
            <p><strong>Country:</strong></p>
            <p><strong>Year:</strong></p>
            <p><strong>BMI:</strong></p>
            <p><strong>Percentage:</strong></p>
        </div>

        <!-- Add legends for map -->
        <div class="legend" id="legend-bmi25-29">
            <h4>BMI 25-29 (Pre-obese) Legend</h4>
            <div class=" legend-item">
                <div class="color-box" style="background-color: #ADD8E6;"></div>
                <span>30.0 - 32.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #87CEFA;"></div>
                <span>32.0 - 34.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #00FF00;"></div>
                <span>34.0 - 36.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #FFFF00;"></div>
                <span>36.0 - 38.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #FFA500;"></div>
                <span>38.0 - 40.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #FF4500;"></div>
                <span>40.0 - 42.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #8B0000;"></div>
                <span>42.0 - 54.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: lightgray;"></div>
                <span>No data provided.</span>
            </div>
        </div>

        <div class="legend" id="legend-bmi-ge25">
            <h4>BMI_GE25 (Overweight) Legend</h4>
            <div class="legend-item">
                <div class="color-box" style="background-color: #ADD8E6;"></div>
                <span>43.6 - 47.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #6699CC;"></div>
                <span>47.0 - 50.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #8BC34A;"></div>
                <span>50.0 - 53.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #FFEB3B;"></div>
                <span>53.0 - 56.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #FF9800;"></div>
                <span>56.0 - 59.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #FF5722;"></div>
                <span>59.0 - 63.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #B71C1C;"></div>
                <span>63.0 - 65.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: lightgray;"></div>
                <span>No data provided.</span>
            </div>
        </div>

        <div class="legend" id="legend-bmi-ge30">
            <h4>BMI_GE30 (Obese) Legend</h4>
            <div class="legend-item">
                <div class="color-box" style="background-color: #ADD8E6;"></div>
                <span>7.9 - 10.9</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #0000FF;"></div>
                <span>10.9 - 12.8</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #00008B;"></div>
                <span>12.8 - 14.1</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #90EE90;"></div>
                <span>14.1 - 15.7</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #008000;"></div>
                <span>15.7 - 16.9</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #006400;"></div>
                <span>16.9 - 18.7</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #FFA500;"></div>
                <span>18.7 - 20.1</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #FF0000;"></div>
                <span>20.1 - 23.0</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: #8B0000;"></div>
                <span>23.0 - 28.7</span>
            </div>
            <div class="legend-item">
                <div class="color-box" style="background-color: lightgray;"></div>
                <span>No data provided.</span>
            </div>
        </div>

    </section>
</body>

</html>