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
    // Read bmi and year value 
    var bmiObj = document.getElementById('bmi');
    var yearObj = document.getElementById('year');

    var bmi = (bmiObj.style.display === 'none') ? null : bmiObj.value;
    var year = (yearObj.style.display === 'none') ? null : yearObj.value;

    switch (bmi) {
        case "Overweight":
            bmi = "BMI_GE25";
            break;
        case "Pre-obese":
            bmi = "BMI25-29";
            break;
        case "Obese":
            bmi = "BMI_GE30";
            break;
        default:
            break;
    }

    // Read  CSV file
    const reader = new FileReader();

    reader.onload = function (event) {
        const csvData = event.target.result;
        const lines = csvData.split('\n');
        const filteredLines = [];

        filteredLines.push(lines[0]); // Add the header line to the filtered lines

        // Filter the CSV data based on the criteria
        for (let i = 0; i < lines.length; i++) {
            const line = lines[i];
            const columns = line.split(',');

            // Check if year is null
            if (year === null) {
                if (columns[0] === bmi) { // Check if the BMI column matches the selected BMI
                    filteredLines.push(line);
                }
            }
            else {
                if (columns[0] === bmi && columns[2] === year) { // Check if the BMI and year columns match the selected BMI and year
                    filteredLines.push(line);
                }
            }
        }

        // Generate the filtered CSV content
        const filteredCSV = filteredLines.join('\n');

        // Create a download link for the filtered CSV file
        const link = document.createElement('a');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(filteredCSV));
        link.setAttribute('download', "chart_data.csv");

        // Trigger the download
        link.click();

        // Clean up
        year = null;
        bmi = null;
    };

    // Read the CSV file using its location
    fetch("/obesity-visualizer/public-app/app/db/eurostat_data.csv")
        .then(response => response.blob())
        .then(blob => reader.readAsText(blob))
        .catch(error => console.log('Error:', error));
}