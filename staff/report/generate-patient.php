<?php
require '../../vendor/autoload.php'; // Include Dompdf's autoloader
include_once('../../config.php');

$sql = "SELECT * FROM patients"; // Update this query to match your database structure

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
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternate row background color */
        }
    </style>
</head>
<body>
    <h1>List of Patients</h1>
    <table>
        <tr>
            <th>No.</th> <!-- Add the new "Number" column -->
            <th>First Name</th>
            <th>Last Name</th>
            <!-- Add more table headers for other patient data if needed -->
        </tr>';
while ($row = $result->fetch_assoc()) {
    $evenRow = !$evenRow; // Toggle the row color for alternation
    $rowColorClass = $evenRow ? 'even' : 'odd';
    
    $htmlContent .= '<tr class="' . $rowColorClass . '">
        <td>' . $rowNumber++ . '</td> <!-- Increment and display the row number -->
        <td>' . $row['first_name'] . '</td>
        <td>' . $row['last_name'] . '</td>
        <!-- Add more table data for other patient data if needed -->
    </tr>';
}
$htmlContent .= '</table></body></html>';

// Load HTML content into Dompdf
$pdf->loadHtml($htmlContent);

// Render the HTML to PDF
$pdf->render();

// Output the PDF to the browser
$pdf->stream();
?>
