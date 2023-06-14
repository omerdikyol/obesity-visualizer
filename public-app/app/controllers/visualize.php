<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/visualize.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
function Visualize(type) {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add table.php (without using iframe)
    var chart = document.createElement('iframe');
    chart.src = "/obesity-visualizer/public-app/app/controllers/" + type + ".php";
    chart.classList.add('fade-in'); // add fade-in class
    chart.id = "chartFrame";

    // Align to center
    chart.style.margin = "auto";
    chart.style.display = "block";
    chart.style.align = "center";

    if (type == "map") {
        chart.scrolling = "no";
    }

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
    document.getElementById("dropdown").style.display = "inline-block";
    document.getElementById("pdfBtn").style.display = "inline-block";
    document.getElementById("csvBtn").style.display = "inline-block";
}

function downloadCSV() {
    // Create a hidden anchor element
    const link = document.createElement('a');
    link.style.display = 'none';

    // Set the download URL
    link.href = '/obesity-visualizer/public-app/app/db/eurostat_data.csv';

    // Set the file name
    link.download = 'data.csv';

    // Append the anchor element to the document body
    document.body.appendChild(link);

    // Trigger the click event
    link.click();

    // Clean up
    document.body.removeChild(link);
}

function toggleExportDropdown() {
    var exportDropdown = document.getElementById("exportDropdownContent");
    exportDropdown.classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches(".export-btn")) {
        var exportDropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < exportDropdowns.length; i++) {
            var exportDropdown = exportDropdowns[i];
            if (exportDropdown.classList.contains("show")) {
                exportDropdown.classList.remove("show");
            }
        }
    }
};
</script>