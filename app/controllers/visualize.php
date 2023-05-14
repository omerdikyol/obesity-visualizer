<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function Map() {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add svg map from map.php
    var map = document.createElement('iframe');
    map.src = "/obesity-visualizer/app/controllers/map.php";
    map.classList.add('fade-in'); // add fade-in class

    // Align to center
    map.style.margin = "auto";
    map.style.display = "block";
    map.style.align = "center";

    document.querySelector('.chart-holder').appendChild(map);

    // Trigger reflow
    void map.offsetWidth; // eslint-disable-line no-unused-expressions

    // Add active class to trigger animation
    map.classList.add('active');
}

function Pie() {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add pie chart from pie.php
    var pie = document.createElement('iframe');
    pie.src = "/obesity-visualizer/app/controllers/pie.php";
    pie.classList.add('fade-in'); // add fade-in class

    // Align to center
    pie.style.margin = "auto";
    pie.style.display = "block";
    pie.style.align = "center";

    document.querySelector('.chart-holder').appendChild(pie);

    // Trigger reflow
    void pie.offsetWidth; // eslint-disable-line no-unused-expressions

    // Add active class to trigger animation
    pie.classList.add('active');
}

function Line() {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add line chart from line.php
    var line = document.createElement('iframe');
    line.src = "/obesity-visualizer/app/controllers/line.php";
    line.classList.add('fade-in'); // add fade-in class

    // Align to center
    line.style.margin = "auto";
    line.style.display = "block";
    line.style.align = "center";

    document.querySelector('.chart-holder').appendChild(line);

    // Trigger reflow
    void line.offsetWidth; // eslint-disable-line no-unused-expressions

    // Add active class to trigger animation
    line.classList.add('active');
}

function Bar() {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add bar chart from bar.php
    var bar = document.createElement('iframe');
    bar.src = "/obesity-visualizer/app/controllers/bar.php";
    bar.classList.add('fade-in'); // add fade-in class

    // Align to center
    bar.style.margin = "auto";
    bar.style.display = "block";
    bar.style.align = "center";

    document.querySelector('.chart-holder').appendChild(bar);

    // Trigger reflow
    void bar.offsetWidth; // eslint-disable-line no-unused-expressions

    // Add active class to trigger animation
    bar.classList.add('active');
}

function Table() {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add table from table.php
    var table = document.createElement('iframe');
    table.src = "/obesity-visualizer/app/controllers/table.php";
    table.classList.add('fade-in'); // add fade-in class

    // Align to center
    table.style.margin = "auto";
    table.style.display = "block";
    table.style.align = "center";

    document.querySelector('.chart-holder').appendChild(table);

    // Trigger reflow
    void table.offsetWidth; // eslint-disable-line no-unused-expressions

    // Add active class to trigger animation
    table.classList.add('active');
}

function generatePDF() {
    const doc = new jsPDF();
    const content = document.getElementById('chart-holder');

    // create a canvas element to render the content to
    const canvas = document.createElement('canvas');
    canvas.width = content.offsetWidth;
    canvas.height = content.offsetHeight;
    const ctx = canvas.getContext('2d');

    // use html2canvas to render the content to the canvas
    html2canvas(content, {
        canvas: canvas,
        useCORS: true,
        allowTaint: true,
        foreignObjectRendering: true,
        onrendered: () => {
            // use canvg to render any SVGs in the content to the canvas
            const svgs = content.querySelectorAll('svg');
            svgs.forEach((svg) => {
                canvg(canvas, svg.outerHTML, {
                    ignoreMouse: true,
                    ignoreAnimation: true,
                    imageRendering: 'auto',
                    async: false,
                });
            });

            // add the canvas to the PDF document
            const imgData = canvas.toDataURL('image/png');
            doc.addImage(imgData, 'PNG', 15, 15, 180, 180 / canvas.width * canvas.height);

            // save the PDF document
            doc.save('my-document.pdf');
        }
    });
}
</script>