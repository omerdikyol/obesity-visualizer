<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.19.0/pdf-lib.js"></script>

<script>
function Visualize(type) {
    document.querySelector('.chart-holder').innerHTML = "";

    // Add table.php (without using iframe)
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

function generatePDF() {
    // Create a new jsPDF instance
    const pdf = new jsPDF();
    console.log("PDF generating");

    // Get all the charts and iframes on the page
    const elementsToExport = document.querySelectorAll('svg, iframe');

    // Create a promise for each element to be exported
    const exportPromises = [];

    // Loop through all the elements and add them to the array of promises
    elementsToExport.forEach((element) => {
        const exportPromise = new Promise((resolve) => {
            // Get the current element's bounding rectangle
            const elementRect = element.getBoundingClientRect();

            // Create a canvas element that has the same width and height as the current element
            const elementCanvas = document.createElement('canvas');
            elementCanvas.width = elementRect.width;
            elementCanvas.height = elementRect.height;

            // Get the canvas context
            const elementCtx = elementCanvas.getContext('2d');

            // Draw the current element on the canvas
            if (element instanceof SVGSVGElement) {
                // If the current element is an SVG element, draw it on the canvas using canvg
                canvg(elementCanvas, element.outerHTML);
            } else {
                // If the current element is an iframe, draw it on the canvas using dom-to-image
                domtoimage.toPng(element).then((dataUrl) => {
                    const img = new Image();
                    img.src = dataUrl;
                    elementCtx.drawImage(img, 0, 0);
                });
            }

            // Add the current element's canvas to the PDF
            pdf.addImage(elementCanvas, elementRect.left, elementRect.top, elementRect.width,
                elementRect.height);

            // Resolve the promise
            resolve();
        });

        // Add the promise to the array of promises
        exportPromises.push(exportPromise);
    });

    // When all the promises are resolved, save the PDF
    Promise.all(exportPromises).then(() => {
        pdf.save('obesity-visualizer.pdf');
        console.log("PDF generated");
    });
}

function generatePDF2() {
    // Export div with id "chartFrame" to PDF
    var element = document.getElementById('chartFrame');

    html2canvas(element).then((canvas) => {
        var imgData = canvas.toDataURL('image/png');
        var doc = new jsPDF();
        doc.addImage(imgData, 'PNG', 10, 10);
        doc.save('obesity-visualizer.pdf');
    });

    console.log("PDF generated");
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}

function generatePDF3() {
    const element = document.getElementById('chartFrame');

    // Create a configuration object for html2pdf
    const config = {
        filename: 'chart.pdf',
        margin: 10,
        image: {
            type: 'jpeg',
            quality: 0.98
        },
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        }
    };

    // Call the html2pdf function with the element and configuration
    html2pdf().from(element).set(config).save();

    console.log("PDF generated");
}

function generatePDF4() {
    var pdf = new jsPDF('p', 'pt', 'a4');
    pdf.setFontSize(18);
    pdf.fromHTML(document.getElementById('html-2-pdfwrapper'),
        margins.left, // x coord
        margins.top, {
            // y coord
            width: margins.width // max width of content on PDF
        },
        function(dispose) {
            headerFooterFormatting(pdf)
        },
        margins);

    var iframe = document.createElement('iframe');
    iframe.setAttribute('style',
        'position:absolute;right:0; top:0; bottom:0; height:100%; width:650px; padding:20px;');
    document.body.appendChild(iframe);

    iframe.src = pdf.output('datauristring');
}

const {
    PDFDocument
} = PDFLib;

async function exportWebsiteAsPdf() {
    const doc = await PDFDocument.create();
    const pages = doc.getPages();

    // Create a new page
    const page = doc.addPage();

    // Get the iframe elements
    const iframeElements = Array.from(document.querySelectorAll('iframe'));

    // Counter to keep track of completed iframes
    let completedIframes = 0;

    // Function to handle loading and rendering iframe content
    const loadIframeContent = async (iframe) => {
        const iframeWindow = iframe.contentWindow;
        const iframeDocument = iframeWindow.document;

        // Wait for the iframe to finish loading
        await new Promise((resolve) => {
            iframeWindow.addEventListener('load', resolve);
        });

        // Get the iframe content
        const iframeContent = iframeDocument.documentElement.innerHTML;

        // Add the iframe content to the PDF page
        const iframeText = page.drawText(iframeContent, {
            x: 10,
            y: 10,
            maxWidth: page.getWidth() - 20,
            maxHeight: page.getHeight() - 20,
        });

        completedIframes++;

        // Check if all iframes have been processed
        if (completedIframes === iframeElements.length) {
            // Save the PDF
            const pdfBytes = await doc.save();
            downloadPdf(pdfBytes, 'website.pdf');
        }
    };

    // Loop through each iframe and load its content
    iframeElements.forEach((iframe) => {
        loadIframeContent(iframe);
    });
}

// Function to download the generated PDF
function downloadPdf(pdfBytes, filename) {
    const blob = new Blob([pdfBytes], {
        type: 'application/pdf'
    });
    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = filename;
    link.click();
}
</script>