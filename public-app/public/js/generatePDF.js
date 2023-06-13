function generatePDF() {
    var element = document.getElementById("exportable");
    var opt = {
        margin: 0.5,
        filename: 'myChart.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }

    };

    html2pdf().set(opt).from(element).save();
}