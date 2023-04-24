<?php

session_start();

// Connect to database
$mysqli = require_once('../db/database.php');

// Get all countries
$sql = "SELECT * FROM public_data";
$result = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
    #country-name {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        font-size: 14px;
        font-family: sans-serif;
        background-color: gainsboro;
        padding: 2px;
        box-sizing: border-box;
    }

    /* Legend */
    .legend {
        display: none;
        position: fixed;
        bottom: 10px;
        left: 10px;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        font-family: Arial, sans-serif;
        font-size: 14px;
        background-color: #fff;
        z-index: 9999;
    }

    .legend h4 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 16px;
        font-weight: bold;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .color-box {
        width: 16px;
        height: 16px;
        margin-right: 5px;
    }

    .legend-item span {
        font-size: 14px;
    }

    /* Country List */
    .list-item {
        list-style-type: none;
        background-color: #f2f2f2;
        padding: 10px;
        margin-bottom: 5px;
        cursor: pointer;
    }

    /* Country Info Box */
    .info-box {
        display: none;
        position: fixed;
        padding: 2px;
        border: 1px solid #ccc;
        font-family: Arial, sans-serif;
        font-size: 14px;
        background-color: #fff;
        z-index: 9999;
    }
    </style>
</head>

<body>
    <section>
        <!-- Add dropdown menu for selecting year and hold that value in a variable -->
        <select name="year" id="year">
            <option value="2008">2008</option>
            <option value="2014">2014</option>
            <option value="2017">2017</option>
            <option value="2019">2019</option>
        </select>

        <!-- Add dropdown menu for selecting body mass index type -->
        <select name="bmi" id="bmi">
            <option value="Overweight">Overweight</option>
            <option value="Pre-obese">Pre-obese</option>
            <option value="Obese">Obese</option>
        </select>

        <!-- Add div to show selected countries information -->
        <p id="country-info"></p>

        <div style="position: relative;">
            <!-- Add svg map -->
            <object id="europe-map" type="image/svg+xml" data="europe.svg"></object>
            <!-- Add div to show country name -->
            <div id="country-name"></div>

            <!-- Add div to show list of countries -->
            <!-- Add header -->
            <ul style=" position: absolute; top: 0; right: 0; overflow-y: auto; max-height: 100%;">
                <?php
                // Get all countries from database and remove duplicates
                $countries = [];
                while ($row = $result->fetch_assoc()) {
                    if (!in_array($row['geo'], $countries) && strlen($row['geo']) < 3) {
                        // Add country to array
                        array_push($countries, $row['geo']);
                    }
                }

                // Sort countries alphabetically
                sort($countries);

                // Add countries to list
                foreach ($countries as $country) {
                    // Get country name from countries.php
                    $countries = include('../helper/countries.php');
                    $country = $countries[$country];

                    echo "<li id='$country' class='list-item' onclick='countryClicked(this.id)'>$country</li>";
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

<script type='text/javascript' src='../../public/js/tinycolor.js'></script>

<script>
var svgObject = document.getElementById("europe-map");
var countryName = document.getElementById("country-name");

var year = document.getElementById("year");
var bmi = document.getElementById("bmi");

//! Add event listeners to year dropdown menus
year.addEventListener("change", colorMap);
year.addEventListener("change", resetInfoBox);
bmi.addEventListener("change", colorMap);
bmi.addEventListener("change", showLegend);
bmi.addEventListener("change", resetInfoBox);



// Show legend based on selected bmi type
function showLegend() {
    const selectedValue = document.getElementById("bmi").value;
    const legendBmi25to29 = document.getElementById("legend-bmi25-29");
    const legendBmiGe25 = document.getElementById("legend-bmi-ge25");
    const legendBmiGe30 = document.getElementById("legend-bmi-ge30");

    if (selectedValue === "Overweight") {
        legendBmi25to29.style.display = 'none';
        legendBmiGe25.style.display = 'block';
        legendBmiGe30.style.display = 'none';
    } else if (selectedValue === "Pre-obese") {
        legendBmi25to29.style.display = 'block';
        legendBmiGe25.style.display = 'none';
        legendBmiGe30.style.display = 'none';
    } else if (selectedValue === "Obese") {
        legendBmi25to29.style.display = 'none';
        legendBmiGe25.style.display = 'none';
        legendBmiGe30.style.display = 'block';
    }
}



//! Write a function for coloring the map depends on values year and bmi
// Create color dictionaries for all indexes
var bmi25_29 = {
    "30.0 - 32.0": "#ADD8E6",
    "32.0 - 34.0": "#87CEFA",
    "34.0 - 36.0": "#00FF00",
    "36.0 - 38.0": "#FFFF00",
    "38.0 - 40.0": "#FFA500",
    "40.0 - 42.0": "#FF4500",
    "42.0 - 54.0": "#8B0000"
};

var bmi_ge25 = {
    "43.6 - 47.0": "#ADD8E6",
    "47.0 - 50.0": "#6699CC",
    "50.0 - 53.0": "#8BC34A",
    "53.0 - 56.0": "#FFEB3B",
    "56.0 - 59.0": "#FF9800",
    "59.0 - 63.0": "#FF5722",
    "63.0 - 65.0": "#B71C1C"
};

var bmi_ge30 = {
    "7.9 - 10.9": "#ADD8E6",
    "10.9 - 12.8": "#0000FF",
    "12.8 - 14.1": "#00008B",
    "14.1 - 15.7": "#90EE90",
    "15.7 - 16.9": "#008000",
    "16.9 - 18.7": "#006400",
    "18.7 - 20.1": "#FFA500",
    "20.1 - 23": "#FF0000",
    "23 - 28.7": "#8B0000"
};

/* Legend:
BMI25-29 (Pre-obese):
    30.0 - 32.0: #ADD8E6 (Light blue)
    32.0 - 34.0: #87CEFA (Blue)
    34.0 - 36.0: #00FF00 (Green)
    36.0 - 38.0: #FFFF00 (Yellow)
    38.0 - 40.0: #FFA500 (Orange)
    40.0 - 42.0: #FF4500 (Red)
    42.0 - 54.0: #8B0000 (Dark red)

BMI_GE25 (Overweight):
    43.6 - 47.0: #ADD8E6 (Light blue)
    47.0 - 50.0: #6699CC (Blue-gray)
    50.0 - 53.0: #8BC34A (Green)
    53.0 - 56.0: #FFEB3B (Yellow)
    56.0 - 59.0: #FF9800 (Orange)
    59.0 - 63.0: #FF5722 (Red)
    63.0 - 65.0: #B71C1C (Dark red)

BMI_GE30 (Obese):
    7.9 - 10.9: Light Blue (#ADD8E6)
    10.5 - 12.8: Blue (#0000FF)
    12.8 - 14.1: Dark Blue (#00008B)
    14.1 - 15.7: Light Green (#90EE90)
    15.7 - 16.9: Green (#008000)
    16.9 - 18.7: Dark Green (#006400)
    18.7 - 20.1: Orange (#FFA500)
    20.1 - 23: Red (#FF0000)
    23 - 28.7: Dark Red (#8B0000)
*/


// Function for coloring the map
function colorMap() {
    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    var request = [];

    for (var i = 0; i < paths.length; i++) {
        (function(i) {
            // Connect to database and get value of that country
            var country = paths[i].id;
            var year = document.getElementById("year").value;
            var bmi = document.getElementById("bmi").value;

            // Send request to bmi.php
            request[i] = new XMLHttpRequest();
            var url = "bmi.php?country=" + country + "&year=" + year + "&bmi=" + bmi;
            request[i].open("GET", url, true);

            request[i].onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Parse the data
                    var data = JSON.parse(this.responseText);
                    var value = -1;
                    var color = "";
                    if (data.length > 0 && data[0].value != 0) {
                        value = data[0].value;
                    }
                    // if data is empty return (no data for that country, year and bmi)
                    else {
                        paths[i].setAttribute("fill", "white");
                        paths[i].setAttribute("fill", "ADD8E6");
                        return;
                    }

                    // Select required array
                    var color_array;
                    if (bmi == "Pre-obese") {
                        color_array = bmi25_29;
                    } else if (bmi == "Overweight") {
                        color_array = bmi_ge25;
                    } else if (bmi == "Obese") {
                        color_array = bmi_ge30;
                    }

                    // Get color
                    for (var key in color_array) {
                        var range = key.split(" - ");
                        if (value >= range[0] && value < range[1]) {
                            color = color_array[key];
                            break;
                        }
                    }

                    // Color the map
                    paths[i].setAttribute("fill", "white"); // Clear previous color
                    paths[i].setAttribute("fill", color);
                }
            };

            request[i].send();
        })(i);
    }
}

//! Create event listener for interacting with the map
svgObject.addEventListener("load", function() {
    // Call functions initially
    colorMap();
    showLegend();
    document.getElementById("info-box").style.display = "none";

    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    for (var i = 0; i < paths.length; i++) {

        // Add border to all countries
        paths[i].setAttribute("stroke", "black");
        paths[i].setAttribute("stroke-width", "0.6px");
        paths[i].setAttribute("stroke-linejoin", "round");

        // Add event listener to each path
        paths[i].addEventListener("click", function() {
            // Get data
            var country = this.id;
            var year = document.getElementById("year").value;
            var bmi = document.getElementById("bmi").value;
            var countryName = this.getAttribute("name");

            // Send request to bmi.php
            var request = new XMLHttpRequest();
            var url = "bmi.php?country=" + country + "&year=" + year + "&bmi=" + bmi;
            request.open("GET", url, true);
            request.send();

            // Get response from bmi.php
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    try {
                        var data = JSON.parse(request.responseText);

                        // Show info box
                        var infoBox = document.getElementById("info-box");
                        var year = document.getElementById("year").value;
                        var bmi = document.getElementById("bmi").value;
                        infoBox.style.display = "block";

                        infoBox.getElementsByTagName("p")[0].innerHTML =
                            "<strong>Country:</strong> " + countryName;
                        infoBox.getElementsByTagName("p")[1].innerHTML =
                            "<strong>Year:</strong> " + year;
                        infoBox.getElementsByTagName("p")[2].innerHTML =
                            "<strong>BMI:</strong> " + bmi;

                        // if data is not empty, get value
                        if (data.length > 0 && data[0].value != 0) {
                            var value = data[0].value;
                            infoBox.getElementsByTagName("p")[3].innerHTML =
                                "<strong>Percentage:</strong> " + value;

                        } else {
                            infoBox.getElementsByTagName("p")[3].innerHTML =
                                "<strong>No data provided.</strong>";
                        }
                    } catch (e) {
                        console.log(e);
                    }
                }
            }
        });

        paths[i].addEventListener("mouseover", function() {
            //! Show country name and make color darker

            // If country is already colored, make it a little bit darker
            if (this.getAttribute("fill")[0] == "#") {
                // Get old color and make it a little bit darker using tinycolor.js
                var oldColor = tinycolor(this.getAttribute("fill"));
                var newColor = oldColor.darken(30).toString();
                this.style.fill = newColor;
            }


            // Move country name to the center of the country
            var bbox = this.getBBox();
            var x = bbox.x + bbox.width / 2;
            var y = bbox.y + 20;
            countryName.style.transform = "translate(" + x + "px, " + y +
                "px)";
            countryName.textContent = this.getAttribute("name");
            countryName.style
                .display = "block";
        });

        paths[i].addEventListener("mouseout", function() {
            // Restore old color and hide country name
            this.style.fill = this.getAttribute("data-old-fill");
            countryName.style.display = "none";
        });
    }
});

// Function for clicking list elements
function countryClicked(itemName) {
    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    for (var i = 0; i < paths.length; i++) {
        if (paths[i].getAttribute("name") == itemName) {
            // Trigger click event
            paths[i].dispatchEvent(new MouseEvent("click"));

            // Hover over the country
            paths[i].dispatchEvent(new MouseEvent("mouseover"));
            // Wait 0.3 second
            setTimeout(function() {
                // Unhover the country
                paths[i].dispatchEvent(new MouseEvent("mouseout"));
            }, 300);

            break;
        }
    }
}

// Function for reseting info box
function resetInfoBox() {
    document.getElementById("info-box").style.display = "none";
}
</script>