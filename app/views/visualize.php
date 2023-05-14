<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/header.php"); ?>

<body>
    <a><button class="button2" id="pieBtn" onclick="Pie()">Pie</button></a>
    <a><button class="button2" id="lineBtn" onclick="Line()">Line</button></a>
    <a><button class="button2" id="barBtn" onclick="Bar()">Bar</button></a>
    <a><button class="button2" id="mapBtn" onclick="Map()">Map</button></a>
    <a><button class="button2" id="tableBtn" onclick="Table()">Table</button></a>

    <a><button class="button2" id="exportBtn" onclick="generatePDF()" style="float: right;">Export</button></a>
    <a><button class="button2" id="filterBtn" style="float: right;">Filter</button></a>

    <div class="chart-holder" id="chart-holder">
    </div>
</body>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/footer.php"); ?>

</html>