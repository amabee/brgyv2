<?php
require '../../vendor/autoload.php'; // Include Dompdf's autoloader
include_once('../../config.php');

$sql = "SELECT * FROM patients"; // Update this query to match your database structure

use Dompdf\Dompdf;
use Dompdf\Options;

// Create a new Dompdf instance
$pdf = new Dompdf();

// (Optional) Set PDF options, like paper size and orientation
// Assuming you have created an instance of Dompdf as $pdf
$pdf->setPaper([0, 0, 3200, 2500], 'landscape'); // Adjust the width value (800 in this example) as needed

// Fetch patient data using MySQLi (assuming you have a $conn object)

// Fetch patient data using MySQLi (assuming you have a $conn object)
$result = $conn->query($sql);

// Initialize a variable to keep track of row colors
$evenRow = false;
$rowNumber = 1; // Initialize row number

// Generate the HTML content for the PDF
$currentMonth = date('F'); // Full month name (e.g., January)
$currentYear = date('Y'); // 4-digit year

$htmlContent = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Add CSS styles for the table */
        table {
            border-collapse: collapse;
            width: 100%; /* Set to 100% for full width */
            border: 1px solid #000; /* Border color and thickness */
        }

        td, th {
            border: 1px solid #000; /* Border for table cells */
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
         
            <td colspan="35">
                <center>
                <?php
                // Get the current month and year
              

                // Output the report header
                echo "FHSIS REPORT for the month of $currentMonth Year $currentYear";
            ?>
                    <br>
                    Name of Municipality/City: CAGAYAN DE ORO CITY
                    <br>
                    Name of Province: MISAMIS ORIENTAL
                    <br>
                    Name of Barangay: BULUA
                    <br>
                    Projected Population of the Year:32,376
                    <br>
                    For Submission to CHO
                </center>
            </td>
        </tr>
        <tr>
       
            <td colspan="35">
                Section A. Family Planning Services and Deworming for Women of Reproductive Age
            </td>
        </tr>
        
        <tr>
    <td rowspan="2" colspan="7">
        A1. Whole Column
        <br>
        (Col. 1)
    </td>
    <!-- Fix this below -->
    <td  colspan="7">
        Age
        <br>
        (Col. 2)
    </td>
    <td rowspan="2" colspan="7">
        Total for WRA 15-19 y/o <br>
        (Col. 3)
    </td>
    <td rowspan="2" colspan="7">
        Interpretation<br>
        (Col. 4)
    </td>
    <td rowspan="2" colspan="7">
        Recommendation/Action<br>
        (Col. 5)
    </td>
</tr>
<tr >
    <!-- Nested row for Age -->
    <td colspan="3">
        10-14 y/o
    </td>
    <td colspan="2">
        15-19 y/o
    </td>
    <td colspan="2">
        20-49 y/o
    </td>
</tr>
<tr>
    <td colspan="7">
    1. Proportion of WRA with unmet need for modern FP
(No.1.1/No.1.2 X 100)
    </td>
    <td colspan="3"></td>
    <td colspan="2"></td>
    <td colspan="2"></td>
    <td colspan="7"></td>
    <td colspan="7" rowspan="3"></td>
    <td colspan="7" rowspan="3"></td>
</tr >

<tr>
    <td colspan="7">
    1.1 Number of WRA with unmet need for MFP - Total
    </td>
    <td colspan="3"></td>
    <td colspan="2"></td>
    <td colspan="2"></td>
    <td colspan="7"></td>
</tr >

<tr>
    <td colspan="7">
    1.2
Total No. of Estimated WRA
(Total Population X 25.854%)
    </td>
    <td colspan="3"></td>
    <td colspan="2"></td>
    <td colspan="2"></td>
    <td colspan="7"></td>
    
</tr >
<tr>
    <td rowspan="2" colspan="5">
        A2. Use of FP Method
        <br>
        (Col. 1)
    </td>
    <!-- Fix this below -->
    <td rowspan="2" colspan="4">
        Current Users
        <br>
        (Beginning of Qtr)
        <br>
        (Col. 2)
    </td>
    <td colspan="8">
        Acceptors
    </td>
    <td rowspan="2" colspan="4">
        Drop-outs<br>
        (Present Quarter) <br>
        (Col. 5)
    </td>
    <td rowspan="2" colspan="4">
        Current Users<br>
        (End of Quarter) <br>
        (Col. 6)
    </td>
    <td rowspan="2" colspan="4">
        New Acceptors<br>
        (Last Month of Present Qtr) <br>
        (Col. 7)
    </td>
    <td rowspan="2" colspan="4">
        CPR<br>
       Col. 6/TP x 25.854% <br>
        (Col. 8)
    </td>
    <td rowspan="2" >
       Interpretation <br>
       (Col.9)
    </td>
    <td rowspan="2">Recommendation/Actions to be
        <br>
        (Col. 10)
    </td>
</tr>
<tr>
    <!-- Nested row for Age -->
    <td colspan="4">
       New(end of Qtr)
       (Col. 3)
    </td>
    <td colspan="4">
    Other(end of Qtr)
       (Col. 4)
    </td>
</tr> 
<tr>
    <td colspan="5"></td>
    <td>10-14</td>
    <td>15-19</td>
    <td>20-49</td>
    <td>Total</td>
    <td>10-14</td>
    <td>15-19</td>
    <td>20-49</td>
    <td>Total</td>
    <td>10-14</td>
    <td>15-19</td>
    <td>20-49</td>
    <td>Total</td>
    <td>10-14</td>
    <td>15-19</td>
    <td>20-49</td>
    <td>Total</td>
    <td>10-14</td>
    <td>15-19</td>
    <td>20-49</td>
    <td>Total</td>
    <td>10-14</td>
    <td>15-19</td>
    <td>20-49</td>
    <td>Total</td>
    <td>10-14</td>
    <td>15-19</td>
    <td>20-49</td>
    <td>Total</td>
    <td rowspan="18"></td>
    <td rowspan="18"></td>
    
</tr>
<tr>
    <td colspan="5">a. BTL - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5">b. NSV - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5">c. Condom - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5">d. Pill - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5"> d.1 Pills-POP - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5"> d.2 Pills-COC - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5">e. Injectibles(DMPA/POI)-Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5">f. Implant - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>


<tr>
    <td colspan="5">g. IUD(IUD-I and IUD-PP) - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5"> g.1 IUD-I - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td colspan="5"> g.1 IUD-PP - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
>
</tr>

<tr>
    <td colspan="5">h. NFP-LAM - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  
</tr>


<tr>
    <td colspan="5"> i.  NFP-BBT - Total<</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  
</tr>



<tr>
    <td colspan="5"> j. NFP-CMM - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  
</tr>

<tr>
    <td colspan="5"> k. NFP-STM - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
 
</tr>

<tr>
    <td colspan="5"> l. NFP-SDM - Total</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  
</tr>

<tr>
    <td colspan="5"> m. Total Current Users</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    
</tr>
    </table>
</body>
</html>';

// Load HTML content into Dompdf
$pdf->loadHtml($htmlContent);

// Render the HTML to PDF
$pdf->render();

// Output the PDF to the browser
$pdf->stream();
?>
