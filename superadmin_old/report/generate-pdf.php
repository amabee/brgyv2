<?php
require '../../vendor/autoload.php'; // Include Dompdf's autoloader

use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // User submitted the form to generate the PDF

    // Create a new Dompdf instance
    $pdf = new Dompdf();

    // Load HTML content into Dompdf
    $htmlContent = $_POST['htmlContent'];
    $pdf->loadHtml($htmlContent);

    // (Optional) Set PDF options, like paper size and orientation
    $pdf->setPaper('A4', 'portrait');

    // Render the HTML to PDF
    $pdf->render();

    // Output the PDF to the browser
    $pdf->stream();
} elseif (isset($_GET['preview'])) {
    // User requested a PDF preview

    // Create a new Dompdf instance
    $pdf = new Dompdf();

    // Load HTML content into Dompdf (you can customize this content)
    $html = '<html><body><h1>Preview PDF</h1></body></html>';
    $pdf->loadHtml($html);

    // (Optional) Set PDF options, like paper size and orientation
    $pdf->setPaper('A4', 'portrait');

    // Render the HTML to PDF
    $pdf->render();

    // Output the PDF to the browser
    $pdf->stream();
} else {
    header('Location: index.php');
    exit();
}
