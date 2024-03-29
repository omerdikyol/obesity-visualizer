<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/models/country.php';
// Get country names
$countries = getCountryNames();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/visualize/charts.php';
?>

<script type='text/javascript' src='/obesity-visualizer/public-app/app/helper/tinycolor.js'></script>
<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>

<script src="/obesity-visualizer/public-app/app/helper/exportChart.js"></script>


<script type='text/javascript'>
    window.jsPDF = window.jspdf.jsPDF;

    function convertSVGToObjectURL(svgObject) {
        return new Promise((resolve) => {
            const xmlSerializer = new XMLSerializer();
            const svgString = xmlSerializer.serializeToString(svgObject.contentDocument.documentElement);
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                resolve(canvas.toDataURL('image/png'));
            };
            img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
        });
    }

    async function generatePDF() {
        const exportable = document.getElementById('exportable');
        const svgObject = document.getElementById('europe-map');
        const infoBox = document.getElementById('info-box');
        const legends = document.querySelectorAll('.legend');

        // Convert the SVG object to a Data URL
        const svgDataURL = await convertSVGToObjectURL(svgObject);
        svgObject.style.display = 'none';

        // Create a new image element with the Data URL as its source
        const svgImage = new Image();
        svgImage.src = svgDataURL;
        svgImage.style.width = '100%';
        exportable.appendChild(svgImage);

        // Modify the CSS properties of the info-box div to move it below the map
        const originalInfoBoxStyle = infoBox.getAttribute('style');
        infoBox.style.position = 'static';
        infoBox.style.marginTop = '1rem';

        // Move the legends above the map and set their display to block
        legends.forEach((legend) => {
            const originalLegendStyle = legend.getAttribute('style');
            legend.setAttribute('data-original-style',
                originalLegendStyle); // Store the original style in a data attribute
            if (legend.style.display !== 'none') {
                legend.style.position = 'static';
                legend.style.marginTop = '1rem';
            }
        });

        // Convert the div to a canvas using html2canvas
        html2canvas(exportable, {
            scale: 2
        }).then((canvas) => {
            // Create a new jsPDF instance
            const pdf = new jsPDF('p', 'mm', 'a4');

            // Calculate the width and height of the canvas in mm
            const imgWidth = (canvas.width * 25.4) / 96;
            const imgHeight = (canvas.height * 25.4) / 96;

            // Calculate the necessary dimensions to fit the content into the A4 page size
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const scaleX = pageWidth / imgWidth;
            const scaleY = pageHeight / imgHeight;
            const scale = Math.min(scaleX, scaleY);

            // Add the canvas image to the PDF with the calculated dimensions
            pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, imgWidth * scale, imgHeight * scale);

            // Save the PDF
            pdf.save('chart_data.pdf');

            // Remove the temporary image element and show the original SVG object
            exportable.removeChild(svgImage);
            svgObject.style.display = '';

            // Restore the original CSS properties of the info-box div and legends
            infoBox.setAttribute('style', originalInfoBoxStyle);
            legends.forEach((legend) => {
                const originalLegendStyle = legend.getAttribute('data-original-style');
                legend.setAttribute('style', originalLegendStyle);
            });
        });
    }


    // Add Map and legend to chart div
    document.getElementById("chart").innerHTML = `<div style="position: relative;">
            <!-- Add svg map -->
            <object id="europe-map" type="image/svg+xml" data="/obesity-visualizer/public-app/public/images/europe.svg" style="background-color: lightblue;
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
    function colorMap() {
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
            url: "http://localhost/obesity-visualizer/chart/",
            type: "GET",
            data: {
                bmi: bmi,
                year: year
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

                    infoBox.getElementsByTagName("p")[0].innerHTML =
                        "<strong>Country:</strong> " + countryName;
                    infoBox.getElementsByTagName("p")[1].innerHTML =
                        "<strong>Year:</strong> " + year;
                    infoBox.getElementsByTagName("p")[2].innerHTML =
                        "<strong>BMI:</strong> " + bmi;

                    // Check if we have that countries data
                    if (data.find(x => x.country == countryName) ==
                        null) {
                        infoBox.getElementsByTagName("p")[3].innerHTML =
                            "<strong>No data provided.</strong>";
                    } else { // Data found in db
                        var value = data.find(x => x.country == countryName).value;
                        infoBox
                            .getElementsByTagName("p")[3].innerHTML =
                            "<strong>Percentage:</strong> " + value;
                    }
                });

                paths[i].addEventListener("mouseover", function() {

                    // Get old color and make it a little bit darker using tinycolor.js
                    var oldColor = tinycolor(this.getAttribute("fill"));
                    var newColor = oldColor.darken(30).toString();
                    this.style.fill = newColor;

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

            // Save data to session storage (for exporting the chart as CSV)
            // Convert country codes to country names
            for (var i = 0; i < data.length; i++) {
                data[i].country = countriesDict[data[i].country];
            }

            sessionStorage.setItem("data", JSON.stringify(data));

        }).fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
        });
    }

    function createMap() {
        // Event Listener for initial load
        svgObject.addEventListener("load", function() {
            // Call functions initially
            colorMap();
            showLegend();
            document.getElementById("info-box").style.display = "none";

            var year = document.getElementById("year").value;
            var bmi = document.getElementById("bmi").value;

            var svgDoc = svgObject.contentDocument;
            // Get all paths in the SVG
            var paths = svgDoc.querySelectorAll('path');

            $.ajax({
                url: "http://localhost/obesity-visualizer/chart/",
                type: "GET",
                data: {
                    bmi: bmi,
                    year: year
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

            // Add zoom functionality
            var svg = d3.select(svgDoc.querySelector("svg"));

            // Create a zoom behavior
            var zoom = d3.zoom()
                .scaleExtent([1, 10]) // Set the minimum and maximum zoom levels
                .on("zoom", zoomed);

            svg.call(zoom); // Bind the zoom behavior to the SVG element

            function zoomed(event) {
                // Update the transform of the SVG element based on the zoom event
                svg.attr("transform", event.transform);
            }

            // Add reset zoom button
            var resetZoomButton = document.getElementById("resetButton");
            resetZoomButton.onclick = function() {
                // Reset the zoom
                svg.transition()
                    .duration(750)
                    .call(zoom.transform, d3.zoomIdentity);
            };
        });
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
                    paths[i].dispatchEvent(new MouseEvent("mo   useout"));
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

    function resetInfoBox() {
        var infoBox = document.getElementById("info-box");
        infoBox.style.display = "none";
    }

    function closeInfoBox() {
        document.getElementById("info-box").style.display = "none";
    }

    // Hold and drag the info-box
    // Get the info-box element
    const infoBox = document.getElementById("info-box");

    // Variable to store the initial position of the info-box
    let initialX;
    let initialY;

    // Add event listener to the info-box for the mousedown event
    infoBox.addEventListener("mousedown", dragStart);

    function dragStart(event) {
        // Store the initial position of the info-box
        initialX = event.clientX - infoBox.offsetLeft;
        initialY = event.clientY - infoBox.offsetTop;

        // Attach event listeners for dragging and dropping
        document.addEventListener("mousemove", drag);
        document.addEventListener("mouseup", dragEnd);
    }

    function drag(event) {
        // Calculate the new position of the info-box
        const newX = event.clientX - initialX;
        const newY = event.clientY - initialY;

        // Set the new position
        infoBox.style.left = newX + "px";
        infoBox.style.top = newY + "px";
    }

    function dragEnd() {
        document.removeEventListener("mousemove", drag);
        document.removeEventListener("mouseup", dragEnd);
    }

    createMap();
</script>