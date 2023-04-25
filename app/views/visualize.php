<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <?php include('./includes/header.php'); ?>

    <a><button class="button2" id="pieBtn" onclick="Pie()">Pie</button></a>
    <a><button class="button2" id="lineBtn" onclick="Line()">Line</button></a>
    <a><button class="button2" id="barBtn" onclick="Bar()">Bar</button></a>
    <a><button class="button2" id="mapBtn" onclick="Map()">Map</button></a>
    <a><button class="button2" id="tableBtn" onclick="Table()">Table</button></a>

    <a><button class="button2" id="exportBtn" style="float: right;">Export</button></a>
    <a><button class="button2" id="filterBtn" style="float: right;">Filter</button></a>

    <div class="chart-holder"></div>
    <script>
    function Map() {
        document.querySelector('.chart-holder').innerHTML = "";

        // Add svg map from map.php
        var map = document.createElement('iframe');
        map.src = "visualize/map.php";

        // Align to center
        map.style.margin = "auto";
        map.style.display = "block";
        map.style.align = "center";



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