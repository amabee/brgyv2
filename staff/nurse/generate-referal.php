<?php
require '../../vendor/autoload.php'; // Include Dompdf's autoloader
include_once('../../config.php');

use Dompdf\Dompdf;
use Dompdf\Options;

// Create a new Dompdf instance
$pdf = new Dompdf();

// (Optional) Set PDF options, like paper size and orientation
$pdf->setPaper('A4', 'portrait');

// Referral letter content
$referralLetter = '
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 1in;
        }
        h1 {
            text-align: center;
        }
        p {
            margin-top: 20px;
        }
        .sender-info {
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>Referral Letter</h1>
    
    <p>Date: ' . date('Y-m-d') . '</p>
    
    <p>To Whom It May Concern,</p>
    
    <p>I am referring the following patient:</p>
    
    <p><strong>Patient Name:</strong> John Doe</p>
    <p><strong>Date of Birth:</strong> January 1, 1980</p>
    <p><strong>Medical Record Number:</strong> 12345</p>
    
    <p>For the following reason:</p>
    
    <p>Mr. Doe is being referred for further evaluation and treatment of his condition.</p>
    
    <p>Please provide the necessary care and attention to this patient. Thank you for your assistance.</p>
    
    <p class="sender-info">Sincerely,<br>
    [Your Name]<br>
    [Your Title]</p>
</body>
</html>
';

// Load HTML content into Dompdf
$pdf->loadHtml($referralLetter);

// Render the HTML to PDF
$pdf->render();

// Output the PDF to the browser or save it to a file
$pdf->stream();
?>
