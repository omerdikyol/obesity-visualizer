<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="/obesity-visualizer/public-app/public/css/style.css">
</head>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/header.php"); ?>

<body>
    <div class="visButton-container">
        <button class="visButton" id="pieBtn" style="display: none;" onclick="Visualize('pie')">
            <i class="fas fa-chart-pie"></i>
            <span>Pie Chart</span>
        </button>
        <button class="visButton" id="lineBtn" style="display: none;" onclick="Visualize('line')">
            <i class="fas fa-chart-line"></i>
            <span>Line Chart</span>
        </button>
        <button class="visButton" id="barBtn" style="display: none;" onclick="Visualize('bar')">
            <i class="fas fa-chart-bar"></i>
            <span>Bar Chart</span>
        </button>
        <button class="visButton" id="mapBtn" style="display: none;" onclick="Visualize('map')">
            <i class="fas fa-map-marked-alt"></i>
            <span>Map</span>
        </button>
        <button class="visButton" id="tableBtn" style="display: none;" onclick="Visualize('table')">
            <i class="fas fa-table"></i>
            <span>Table</span>
        </button>
        <button class="visButton export-btn" id="exportBtn" style="display: none; float: right;" onclick="exportWebsiteAsPdf()">
            <i class="fas fa-file-pdf"></i>
            <span>Export as PDF</span>
        </button>
    </div>


    <div class="chart-holder" id="chart-holder">
        <h2>Select Visualization Type</h2>
        <h3>Select a visualization type from the buttons below. Each button represents a different type of chart or
            graph. Click on a button to generate the corresponding visualization.</h3>
        <div class="visualization-buttons">
            <button class="visualization-button" onclick="Visualize('pie'); enableButtons();">
                <i class="fas fa-chart-pie"></i>
                <span>Pie Chart</span>
            </button>
            <button class="visualization-button" onclick="Visualize('line'); enableButtons();">
                <i class="fas fa-chart-line"></i>
                <span>Line Chart</span>
            </button>
            <button class="visualization-button" onclick="Visualize('bar'); enableButtons();">
                <i class="fas fa-chart-bar"></i>
                <span>Bar Chart</span>
            </button>
            <button class="visualization-button" onclick="Visualize('map'); enableButtons();">
                <i class="fas fa-map"></i>
                <span>Map</span>
            </button>
            <button class="visualization-button" onclick="Visualize('table'); enableButtons();">
                <i class="fas fa-table"></i>
                <span>Table</span>
            </button>
        </div>
    </div>

</body>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/footer.php"); ?>

</html>