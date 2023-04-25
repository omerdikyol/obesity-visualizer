<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize.php';
?>

<script>
function Map() {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add svg map from map.php
    var map = document.createElement('iframe');
    map.src = "/obesity-visualizer/app/controllers/map.php";

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
    pie.src = "/obesity-visualizer/public/images/pie.jpg";
    pie.alt = "pie chart";
    document.querySelector('.chart-holder').appendChild(pie);
}

function Line() {
    document.querySelector('.chart-holder').innerHTML = "";
    var line = document.createElement('img');
    line.src = "/obesity-visualizer/public/images/line.jpg";
    line.alt = "line chart";
    document.querySelector('.chart-holder').appendChild(line);
}

function Bar() {
    document.querySelector('.chart-holder').innerHTML = "";
    var bar = document.createElement('img');
    bar.src = "/obesity-visualizer/public/images/bar.jpg"
    bar.alt = "bar chart";
    document.querySelector('.chart-holder').appendChild(bar);
}

function Table() {
    document.querySelector('.chart-holder').innerHTML = "";
    var table = document.createElement('img');
    table.src = "/obesity-visualizer/public/images/table.jpg"
    table.alt = "table";
    document.querySelector('.chart-holder').appendChild(table);
}
</script>