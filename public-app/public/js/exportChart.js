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

    var bmiDiv = document.getElementById('bmiDiv');
    var yearDiv = document.getElementById('yearDiv');

    var bmi = (bmiDiv.style.display === 'none') ? null : bmiObj.value;
    var year = (yearDiv.style.display === 'none') ? null : yearObj.value;

    var bmiSecond = null;

    switch (bmi) {
        case "Overweight":
            bmiSecond = "BMI_GE25";
            break;
        case "Pre-obese":
            bmiSecond = "BMI25-29";
            break;
        case "Obese":
            bmiSecond = "BMI_GE30";
            break;
        default:
            break;
    }

    // Get data from session storage
    var data = sessionStorage.getItem("data");
    var dataObj = JSON.parse(data);

    // Clear data from session storage
    sessionStorage.removeItem("data");

    // Generate CSV
    const lines = [];
    const headers = [];

    // Add BMI and year to top of file
    lines.push("Obesity Visualizer");
    lines.push("BMI: " + bmi);
    if (year !== null) {
        lines.push("Year: " + year);
    }
    lines.push(""); // Add empty line

    // Add headers
    headers.push("country"); // Add country header first
    for (const key in dataObj[0]) {
        if (dataObj[0].hasOwnProperty(key) && key !== "country") { // Add all other headers
            const element = dataObj[0][key];
            if (key === "bmi" || key === "id") continue;
            headers.push(key);
        }
    }
    lines.push(headers.join(","));

    // Add data
    for (let i = 0; i < dataObj.length; i++) {
        const line = [];
        const columns = dataObj[i];

        if (columns["country"] === undefined) continue; // Skip if country is undefined

        line.push(columns["country"]); // Add country first
        for (const key in columns) {
            if (key === "bmi" || key === "id") continue;
            if (columns.hasOwnProperty(key) && key !== "country") {
                const element = columns[key];
                line.push(element);
            }
        }
        lines.push(line.join(","));
    }

    // Generate the filtered CSV content
    const filteredCSV = lines.join('\n');

    // Create a download link for the filtered CSV file
    const link = document.createElement('a');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(filteredCSV));
    link.setAttribute('download', "chart_data.csv");

    // Trigger the download
    link.click();

    // Clean up
    year = null;
    bmi = null;
}
