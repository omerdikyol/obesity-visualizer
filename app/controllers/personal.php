<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/services/countryService/countryService.php';

// Get country names
$countries = getCountryNames();

// Check if session user_id exists
if (isset($_SESSION['user_id'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/models/personal.php';
}
?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
// Edit button function
function editBtn() {
    // Remove Data table and show form
    document.getElementById('data_container').style.display = 'none';
    document.getElementById('edit_container').style.display = 'block';
}

// Export button function
function exportCSV() {
    // Export data to CSV file
    window.location.href = '/obesity-visualizer/app/controllers/exportCSVController.php';
}

function exportPDF() {
    var HTML_Width = $(".exportable").width();
    var HTML_Height = $(".exportable").height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    html2canvas(document.getElementById('exportable')).then(function(canvas) {
        var imgData = canvas.toDataURL("image/png", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'PNG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        pdf.save("user_data.pdf");
    });
}

function exportPNG() {
    html2canvas(document.getElementById('exportable')).then(function(canvas) {
        var ctx = canvas.getContext('2d');

        // set the ctx to draw beneath your current content
        ctx.globalCompositeOperation = 'destination-over';

        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        var img = canvas.toDataURL("image/png");
        saveAs(img, 'user_data.png');
    });
}
</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/personal.php"; ?>