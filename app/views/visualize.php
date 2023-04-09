<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
    .buttonVisualize {
        display: inline-block;
        outline: 0;
        cursor: pointer;
        padding: 5px 16px;
        font-size: 14px;
        font-weight: 500;
        line-height: 20px;
        vertical-align: middle;
        border: 1px solid;
        border-radius: 6px;
        color: #0366d6;
        background-color: #fafbfc;
        border-color: #1b1f2326;
        box-shadow: rgba(27, 31, 35, 0.04) 0px 1px 0px 0px, rgba(255, 255, 255, 0.25) 0px 1px 0px 0px inset;
        transition: 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        transition-property: color, background-color, border-color;
    }

    .buttonVisualize:hover {
        color: #ffffff;
        background-color: #0366d6;
        border-color: #1b1f2326;
        box-shadow: rgba(27, 31, 35, 0.1) 0px 1px 0px 0px, rgba(255, 255, 255, 0.03) 0px 1px 0px 0px inset;
        transition-duration: 0.1s;
    }
    </style>
</head>


<body>
    <?php include('./includes/header.php'); ?>

    <a><button class="buttonVisualize" id="pieBtn" onclick="Pie()">Pie</button></a>
    <a><button class="buttonVisualize" id="lineBtn" onclick="Line()">Line</button></a>
    <a><button class="buttonVisualize" id="barBtn" onclick="Bar()">Bar</button></a>
    <a><button class="buttonVisualize" id="mapBtn" onclick="Map()">Map</button></a>
    <a><button class="buttonVisualize" id="tableBtn" onclick="Table()">Table</button></a>

    <a><button class="buttonVisualize" id="exportBtn" style="float: right;">Export</button></a>
    <a><button class="buttonVisualize" id="filterBtn" style="float: right;">Filter</button></a>

    <div class="chart-holder"></div>
    <script>
    function Map() {
        document.querySelector('.chart-holder').innerHTML = "";
        // Add image to object
        var map = document.createElement('img');
        map.src = "../../public/images/map.jpg";
        map.alt = "map";
        document.querySelector('.chart-holder').appendChild(map);
    }

    function Pie() {
        document.querySelector('.chart-holder').innerHTML = "";
        // Add image to object
        var pie = document.createElement('img');
        pie.src = "../../public/images/pie.jpg";
        pie.alt = "pie chart";
        document.querySelector('.chart-holder').appendChild(pie);
    }

    function Line() {
        document.querySelector('.chart-holder').innerHTML = "";
        var line = document.createElement('img');
        line.src = "../../public/images/line.jpg";
        line.alt = "line chart";
        document.querySelector('.chart-holder').appendChild(line);
    }

    function Bar() {
        document.querySelector('.chart-holder').innerHTML = "";
        var bar = document.createElement('img');
        bar.src = "../../public/images/bar.jpg"
        bar.alt = "bar chart";
        document.querySelector('.chart-holder').appendChild(bar);
    }

    function Table() {
        document.querySelector('.chart-holder').innerHTML = "";
        var table = document.createElement('img');
        table.src = "../../public/images/table.jpg"
        table.alt = "table";
        document.querySelector('.chart-holder').appendChild(table);
    }
    </script>
</body>
<?php include('./includes/footer.php'); ?>


</html>