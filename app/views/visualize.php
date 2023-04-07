<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>


<body>
    <?php include('./includes/header.php'); ?>

    <a><button class="button-secondary" onclick="Pie()">Pie</button></a>
    <a><button class="button-secondary" onclick="Line()">Line</button></a>
    <a><button class="button-secondary" onclick="Bar()">Bar</button></a>
    <a><button class="button-secondary" onclick="Map()">Map</button></a>
    <a><button class="button-secondary" style="float: right;">Export</button></a>


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
    </script>
</body>
<?php include('./includes/footer.php'); ?>


</html>