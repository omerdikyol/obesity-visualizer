<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script>
function Visualize(type) {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add table from table.php
    var chart = document.createElement('iframe');
    chart.src = "/obesity-visualizer/app/controllers/" + type + ".php";
    chart.classList.add('fade-in'); // add fade-in class
    chart.id = "chartFrame";

    // Align to center
    chart.style.margin = "auto";
    chart.style.display = "block";
    chart.style.align = "center";

    document.querySelector('.chart-holder').appendChild(chart);

    // Trigger reflow
    void chart.offsetWidth; // eslint-disable-line no-unused-expressions

    // Add active class to trigger animation
    chart.classList.add('active');
}

function enableButtons() {
    document.getElementById("pieBtn").style.display = "inline-block";
    document.getElementById("lineBtn").style.display = "inline-block";
    document.getElementById("barBtn").style.display = "inline-block";
    document.getElementById("mapBtn").style.display = "inline-block";
    document.getElementById("tableBtn").style.display = "inline-block";
    document.getElementById("exportBtn").style.display = "inline-block";
}

function generatePDF() {}
</script>