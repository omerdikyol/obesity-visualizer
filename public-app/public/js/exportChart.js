// PDF
window.jsPDF = window.jspdf.jsPDF;

// FOR ALL CHARTS EXCEPT MAP
async function generatePDF() {
    const exportable = document.getElementById('exportable');
    const infoBox = document.getElementById('info-box');

    // Modify the CSS properties of the info-box div to move it below the chart-container
    const originalInfoBoxStyle = infoBox.getAttribute('style');
    infoBox.style.position = 'static';
    infoBox.style.marginTop = '1rem';

    // Convert the div to a canvas using html2canvas
    html2canvas(exportable, {
        scale: 2
    }).then((canvas) => {
        // Create a new jsPDF instance
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Calculate the width and height of the canvas in mm
        const imgWidth = (canvas.width * 25.4) / 96;
        const imgHeight = (canvas.height * 25.4) / 96;

        // Calculate the necessary dimensions to fit the content into the A4 page size
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const scaleX = pageWidth / imgWidth;
        const scaleY = pageHeight / imgHeight;
        const scale = Math.min(scaleX, scaleY);

        // Add the canvas image to the PDF with the calculated dimensions
        pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, imgWidth * scale, imgHeight * scale);

        // Save the PDF
        pdf.save('chart_data.pdf');

        // Restore the original CSS properties of the info-box div
        infoBox.setAttribute('style', originalInfoBoxStyle);
    });
}


// FOR MAP 
function convertSVGToObjectURL(svgObject) {
    return new Promise((resolve) => {
        const xmlSerializer = new XMLSerializer();
        const svgString = xmlSerializer.serializeToString(svgObject.contentDocument.documentElement);
        const img = new Image();
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0);
            resolve(canvas.toDataURL('image/png'));
        };
        img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
    });
}

async function generateMap() {
    const exportable = document.getElementById('exportable');
    const svgObject = document.getElementById('europe-map');
    const infoBox = document.getElementById('info-box');
    const legends = document.querySelectorAll('.legend');

    // Convert the SVG object to a Data URL
    const svgDataURL = await convertSVGToObjectURL(svgObject);
    svgObject.style.display = 'none';

    // Create a new image element with the Data URL as its source
    const svgImage = new Image();
    svgImage.src = svgDataURL;
    svgImage.style.width = '100%';
    exportable.appendChild(svgImage);

    // Modify the CSS properties of the info-box div to move it below the map
    const originalInfoBoxStyle = infoBox.getAttribute('style');
    infoBox.style.position = 'static';
    infoBox.style.marginTop = '1rem';

    // Move the legends above the map and set their display to block
    legends.forEach((legend) => {
        const originalLegendStyle = legend.getAttribute('style');
        legend.setAttribute('data-original-style',
            originalLegendStyle); // Store the original style in a data attribute
        if (legend.style.display !== 'none') {
            legend.style.position = 'static';
            legend.style.marginTop = '1rem';
        }
    });

    // Convert the div to a canvas using html2canvas
    html2canvas(exportable, {
        scale: 2
    }).then((canvas) => {
        // Create a new jsPDF instance
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Calculate the width and height of the canvas in mm
        const imgWidth = (canvas.width * 25.4) / 96;
        const imgHeight = (canvas.height * 25.4) / 96;

        // Calculate the necessary dimensions to fit the content into the A4 page size
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const scaleX = pageWidth / imgWidth;
        const scaleY = pageHeight / imgHeight;
        const scale = Math.min(scaleX, scaleY);

        // Add the canvas image to the PDF with the calculated dimensions
        pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, imgWidth * scale, imgHeight * scale);

        // Save the PDF
        pdf.save('chart_data.pdf');

        // Remove the temporary image element and show the original SVG object
        exportable.removeChild(svgImage);
        svgObject.style.display = '';

        // Restore the original CSS properties of the info-box div and legends
        infoBox.setAttribute('style', originalInfoBoxStyle);
        legends.forEach((legend) => {
            const originalLegendStyle = legend.getAttribute('data-original-style');
            legend.setAttribute('style', originalLegendStyle);
        });
    });
}


// CSV
function generateCSV() {
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