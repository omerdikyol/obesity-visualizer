<?php

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/models/countries.php';

// Get country names
$countries = getCountryNames();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize/charts.php';
?>

<script type='text/javascript' src='/obesity-visualizer/public/js/tinycolor.js'></script>

<script type='text/javascript'>
// Add Map and legend to chart div
document.getElementById("chart").innerHTML = `<div style="position: relative;">
            <!-- Add svg map -->
            <object id="europe-map" type="image/svg+xml" data="/obesity-visualizer/public/images/europe.svg"></object>
            <!-- Add div to show country name -->
            <div id="country-name"></div>
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
        </div>`;

// Hide unnecessary elements
document.getElementById("countryCount").style.display = "none";
document.getElementById("resetButton").style.display = "none";

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

// Function for showing the legend
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

// Color dictionaries for all bmi types
var bmi25_29 = {
    "30.0 - 32.0": "#ADD8E6", // light blue
    "32.0 - 34.0": "#87CEFA", // blue
    "34.0 - 36.0": "#00FF00", // green
    "36.0 - 38.0": "#FFFF00", // yellow
    "38.0 - 40.0": "#FFA500", // orange
    "40.0 - 42.0": "#FF4500", // red
    "42.0 - 54.0": "#8B0000" // dark red
};

var bmi_ge25 = {
    "43.6 - 47.0": "#ADD8E6", // light blue
    "47.0 - 50.0": "#6699CC", // blue-gray
    "50.0 - 53.0": "#8BC34A", // green
    "53.0 - 56.0": "#FFEB3B", // yellow
    "56.0 - 59.0": "#FF9800", // orange
    "59.0 - 63.0": "#FF5722", // red
    "63.0 - 65.0": "#B71C1C" // dark red
};

var bmi_ge30 = {
    "7.9 - 10.9": "#ADD8E6", // light blue
    "10.9 - 12.8": "#0000FF", // blue
    "12.8 - 14.1": "#00008B", // dark blue
    "14.1 - 15.7": "#90EE90", // light green
    "15.7 - 16.9": "#008000", // green
    "16.9 - 18.7": "#006400", // dark green
    "18.7 - 20.1": "#FFA500", // orange
    "20.1 - 23": "#FF0000", // red
    "23 - 28.7": "#8B0000" // dark red
};

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

            // Send request to country.php model
            request[i] = new XMLHttpRequest();
            var url = "/obesity-visualizer/app/models/country.php?country=" + country + "&year=" + year +
                "&bmi=" + bmi;
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
                        if (value >= parseFloat(range[0]) && value < parseFloat(range[1])) {
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

// Event Listener for initial load
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

            // Send request to country.php
            var request = new XMLHttpRequest();
            var url = "/obesity-visualizer/app/models/country.php?country=" + country + "&year=" +
                year +
                "&bmi=" + bmi;
            request.open("GET", url, true);
            request.send();

            // Get response
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

function listClicked(itemName) {
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

function listHover(itemName) {
    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    for (var i = 0; i < paths.length; i++) {
        if (paths[i].getAttribute("name") == itemName) {
            // Hover over the country
            paths[i].dispatchEvent(new MouseEvent("mouseover"));
            break;
        }
    }
}

function listOut() {
    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    for (var i = 0; i < paths.length; i++) {
        // Unhover the country
        paths[i].dispatchEvent(new MouseEvent("mouseout"));
    }
}

// Function for reseting info box
function resetInfoBox() {
    document.getElementById("info-box").style.display = "none";
}
</script>