function generatePDF() {
    var element = document.getElementById("exportable");
    var opt = {
        margin: 0.4,
        filename: 'myChart.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { width: element_width, scale: 2, logging: true, dpi: 192, letterRendering: true, useCORS: true, allowTaint: true, foreignObjectRendering: true, backgroundColor: null },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
    };

    // Set the crossorigin attribute for iframes and SVGs
    var elements = element.getElementsByTagName("*");
    for (var i = 0; i < elements.length; i++) {
        var el = elements[i];
        if (el.tagName === "IFRAME" || el.tagName === "svg") {
            el.setAttribute("crossorigin", "anonymous");
        }
    }

    html2pdf().set(opt).from(element).save();
}


function generatePDF2() {
    $(document).ready(function () {
        $("#exportable").click(function () {
            kendo.drawing
                .drawDOM("body")
                .then(function (group) {
                    kendo.drawing.pdf.saveAs(group, "exported-page.pdf");
                });
        });
    });
}