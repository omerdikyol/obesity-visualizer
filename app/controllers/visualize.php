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

    // Add pie chart from pie.php
    var pie = document.createElement('iframe');
    pie.src = "/obesity-visualizer/app/controllers/pie.php";

    // Align to center
    pie.style.margin = "auto";
    pie.style.display = "block";
    pie.style.align = "center";

    document.querySelector('.chart-holder').appendChild(pie);
}

function Line() {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add line chart from line.php
    var line = document.createElement('iframe');
    line.src = "/obesity-visualizer/app/controllers/line.php";

    // Align to center
    line.style.margin = "auto";
    line.style.display = "block";
    line.style.align = "center";

    document.querySelector('.chart-holder').appendChild(line);
}

function Bar() {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add bar chart from bar.php
    var bar = document.createElement('iframe');
    bar.src = "/obesity-visualizer/app/controllers/bar.php";

    // Align to center
    bar.style.margin = "auto";
    bar.style.display = "block";
    bar.style.align = "center";

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