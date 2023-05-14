<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/header.php"); ?>

<body>
    <a><button class="button2" id="pieBtn" style="display: none;" onclick="Visualize('pie')">Pie</button></a>
    <a><button class="button2" id="lineBtn" style="display: none;" onclick="Visualize('line')">Line</button></a>
    <a><button class="button2" id="barBtn" style="display: none;" onclick="Visualize('bar')">Bar</button></a>
    <a><button class="button2" id="mapBtn" style="display: none;" onclick="Visualize('map')">Map</button></a>
    <a><button class="button2" id="tableBtn" style="display: none;" onclick="Visualize('table')">Table</button></a>

    <a><button class="button2" id="exportBtn" style="display: none; float: right;"
            onclick="generatePDF()">Export</button></a>

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

<?php include($_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/footer.php"); ?>

</html>