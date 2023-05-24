<?php

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/models/countries.php';

// Get country names
$countries = getCountryNames();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize/charts.php';
?>

<script type='text/javascript' src='/obesity-visualizer/public/js/tinycolor.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type='text/javascript'>
// Add Map and legend to chart div
document.getElementById("chart").innerHTML = `<div style="position: relative;">
            <!-- Add svg map -->
            <object id="europe-map" type="image/svg+xml" data="/obesity-visualizer/public/images/europe.svg" style="background-color: lightblue;
"></object>
            <!-- Add div to show country name -->
            <div id="country-name"></div>
        </div>

        <!-- Add legends for map -->
        <div class="legend" id="legend-bmi25-29">
            <h4>BMI 25-29 (Pre-obese) Legend</h4>
            <div class=" legend-item">
                <div class="color-box" style="background-color: #5757FF;"></div>
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
                <div class="color-box" style="background-color: #5757FF;"></div>
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
                <div class="color-box" style="background-color: #5757FF;"></div>
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
document.getElementById("countryCountDiv").style.display = "none";
document.getElementById("resetButton").style.display = "none";

var svgObject = document.getElementById("europe-map");
var countryName = document.getElementById("country-name");

var year = document.getElementById("year");
var bmi = document.getElementById("bmi");

//! Add event listeners to year dropdown menus
year.addEventListener("change", createMap);
year.addEventListener("change", resetInfoBox);
bmi.addEventListener("change", createMap);
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
    "30.0 - 32.0": "#5757FF", // light blue
    "32.0 - 34.0": "#87CEFA", // blue
    "34.0 - 36.0": "#00FF00", // green
    "36.0 - 38.0": "#FFFF00", // yellow
    "38.0 - 40.0": "#FFA500", // orange
    "40.0 - 42.0": "#FF4500", // red
    "42.0 - 54.0": "#8B0000" // dark red
};

var bmi_ge25 = {
    "43.6 - 47.0": "#5757FF", // light blue
    "47.0 - 50.0": "#6699CC", // blue-gray
    "50.0 - 53.0": "#8BC34A", // green
    "53.0 - 56.0": "#FFEB3B", // yellow
    "56.0 - 59.0": "#FF9800", // orange
    "59.0 - 63.0": "#FF5722", // red
    "63.0 - 65.0": "#B71C1C" // dark red
};

var bmi_ge30 = {
    "7.9 - 10.9": "#5757FF", // light blue
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
function createMap() {
    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    var request = [];
    var year = document.getElementById("year").value;
    var bmi = document.getElementById("bmi").value;
    var countriesDict = <?php echo json_encode($countries); ?>;
    var color = "";

    // Set title
    document.getElementById("title").innerHTML = "Year: " + year + " BMI: " +
        bmi;

    // Make AJAX call to get the BMI data for each country and build the final data array
    $.ajax({
        url: "/obesity-visualizer/app/models/year_bmi.php",
        type: "GET",
        data: {
            year: year,
            bmi: bmi
        },
    }).done(function(data) {
        data = JSON.parse(data);
        if (data[0] == null) {
            return;
        }

        // Float the values
        for (var i = 0; i < data.length; i++) {
            data[i].value = parseFloat(data[i].value);
        }

        for (var i = 0; i < paths.length; i++) {
            var id = paths[i].id;
            // Check if we have that countries data
            if (data.find(x => x.country == id) == null) { // Country data does not exist in db
                paths[i].setAttribute("fill", "white");
                paths[i].setAttribute("fill", "lightgray");
            } else { // Data found in db
                // Get value of that country id
                var value = data.find(x => x.country == id).value;
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

            // Add event listener to each path
            paths[i].addEventListener("click", function() {
                // Show info box
                var infoBox = document.getElementById("info-box");
                infoBox.style.display = "block";

                var year = document.getElementById("year").value;
                var bmi = document.getElementById("bmi").value;
                var countryName = this.getAttribute("name");
                var countryId = this.getAttribute("id");

                infoBox.getElementsByTagName("p")[0].innerHTML =
                    "<strong>Country:</strong> " + countryName;
                infoBox.getElementsByTagName("p")[1].innerHTML =
                    "<strong>Year:</strong> " + year;
                infoBox.getElementsByTagName("p")[2].innerHTML =
                    "<strong>BMI:</strong> " + bmi;

                // Check if we have that countries data
                if (data.find(x => x.country == countryId) ==
                    null) {
                    infoBox.getElementsByTagName("p")[3].innerHTML =
                        "<strong>No data provided.</strong>";
                } else { // Data found in db
                    var value = data.find(x => x.country == countryId).value;
                    infoBox
                        .getElementsByTagName("p")[3].innerHTML =
                        "<strong>Percentage:</strong> " + value;
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

                // Move country name to bottom of map like a line on the bottom
                countryName.style.display = "block";
                countryName.innerHTML = this.getAttribute("name");
                countryName.style.top = "20%";
                countryName.style.left = "30%";
                countryName.style.transform = "translate(-50%, -100%)";
                countryName.style.fontSize = "1.5rem";
                countryName.style.fontWeight = "bold";
                countryName.style.color = "black";
                countryName.style.position = "absolute";
                countryName.style.zIndex = "1000";
                countryName.style.backgroundColor = "white";
                countryName.style.padding = "0.5rem";
                countryName.style.borderRadius = "0.5rem";
                countryName.style.boxShadow = "0 0 5px rgba(0, 0, 0, 0.3)";
            });


            paths[i].addEventListener("mouseout", function() {
                // Restore old color and hide country name
                this.style.fill = this.getAttribute("data-old-fill");
                countryName.style.display = "none";
            });
        }

    }).fail(function(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);
    });
}

// Event Listener for initial load
svgObject.addEventListener("load", function() {
    // Call functions initially
    createMap();
    showLegend();
    document.getElementById("info-box").style.display = "none";

    var year = document.getElementById("year").value;
    var bmi = document.getElementById("bmi").value;

    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    $.ajax({
        url: "/obesity-visualizer/app/models/year_bmi.php",
        type: "GET",
        data: {
            year: year,
            bmi: bmi
        },
    }).done(function(data) {
        data = JSON.parse(data);
        if (data[0] == null) {
            return;
        }

        // Float the values
        for (var i = 0; i < data.length; i++) {
            data[i].value = parseFloat(data[i].value);
        }

        // Set Borders and Add event listeners to each path
        for (var i = 0; i < paths.length; i++) {
            // Add border
            paths[i].setAttribute("stroke", "black");
            paths[i].setAttribute("stroke-width", "0.6px");
            paths[i].setAttribute("stroke-linejoin", "round");
        }

    }).fail(function(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);
    });
});

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

function closeInfoBox() {
    document.getElementById("info-box").style.display = "none";
}
</script>