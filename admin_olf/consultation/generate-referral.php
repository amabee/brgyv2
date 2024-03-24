<?php
require '../../vendor/autoload.php'; // Include Dompdf's autoloader
include_once('../../config.php');
$id = $_GET['id'];
$sql = "SELECT *,admins.first_name as d_first_name,admins.last_name as d_last_name,patients.first_name as p_first_name,patients.last_name as p_last_name FROM consultations 
JOIN patients ON patients.id = consultations.patient_id
JOIN admins ON admins.id = consultations.doctor_id
WHERE consultations.id = $id"; // Update this query to match your database structure

use Dompdf\Dompdf;
use Dompdf\Options;

// Create a new Dompdf instance
$pdf = new Dompdf();

// (Optional) Set PDF options, like paper size and orientation
$pdf->setPaper('A4', 'portrait');

// Fetch patient data using MySQLi (assuming you have a $conn object)
$result = $conn->query($sql);

// Initialize a variable to keep track of row colors
$evenRow = false;
$rowNumber = 1; // Initialize row number

// Generate the HTML content for the PDF
$htmlContent = '<html>
<head></head>
<body>
<h1>Referral</h1>
<br>
&nbsp;&nbsp;&nbsp;<img src="data:image/png;base64,' . base64_encode(file_get_contents('http://localhost/brgyv2/admin/consultation/rx.png')) . '" width="70" height="70">
';

$evenRow = false; // Initialize the even row status
$rowNumber = 1;  // Initialize the row number
while ($row = $result->fetch_assoc()) {
    $rowColorStyle = $evenRow ? 'background-color: #f2f2f2;' : '';
    $htmlContent .= '<div style="border: 1px solid #dddddd; padding: 10px; margin: 10px; ' . $rowColorStyle . '">
    <p><strong>Patient Name:</strong> ' . $row['p_first_name'] .' ' . $row['p_last_name'] .'</p>
    <p><strong>Patient Address:</strong> ' . $row['address'] .'</p>
    <p><strong>Patient Serial No:</strong> ' . $row['serial_no'] .'</p>
    <br>
    <p><strong>Description:</strong> ' . $row['description'] . '</p>
    <p><strong>Diagnosis:</strong> ' . $row['diagnosis'] . '</p>
    <p><strong>Prescription:</strong> ' . $row['medicine'] . '</p>
    <br>    <br>
    <p>To Whom It May Concern,
    <br>   <br>
    I am writing to request a referral for our patient, ' . $row['p_first_name'] .' ' . $row['p_last_name'] .', to see a specialist in [Specialty]. After a thorough examination, it has been determined that a consultation with a specialist is advisable to provide the most appropriate care for ' . $row['p_first_name'] .' ' . $row['p_last_name'] .' medical condition.
    We kindly request your assistance in coordinating this referral. We believe that your expertise in the field of [Specialty] will greatly benefit the patient. Please provide us with the necessary details for scheduling an appointment, and we will ensure all relevant medical records are transferred to your office.
    If you require any specific information or documentation from our end, please do not hesitate to let us know. We are committed to ensuring a smooth and efficient process for the patients referral.
    Thank you for your cooperation and your dedication to providing the highest quality of care to our patient. We trust that ' . $row['p_first_name'] .' ' . $row['p_last_name'] .' will be in capable hands under your guidance.

    </p>
    <div style="float: right;">
  
        <p>
          
    <hr style="clear: both; border: none; border-top: 2px solid #000; width: 100%;">
        <strong>Doctor:</strong> ' . $row['d_first_name'] .' '. $row['d_last_name'] . '</p>
    </div>
    
</div>';

    $updateIsPrintSql = "UPDATE consultations SET is_print = 1 WHERE id = ?";
    $updateIsPrintStmt = $conn->prepare($updateIsPrintSql);
    $updateIsPrintStmt->bind_param("i", $id);
    $updateIsPrintStmt->execute();

    $evenRow = !$evenRow; // Toggle the row color for alternation
}

// Load HTML content into Dompdf
$pdf->loadHtml($htmlContent);

// Render the HTML to PDF
$pdf->render();

// Generate the PDF and trigger a download
$pdfData = $pdf->output();
file_put_contents('referral.pdf', $pdfData);
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="referral.pdf"');
readfile('referral.pdf');

?>
