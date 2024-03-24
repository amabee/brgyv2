<!DOCTYPE html>
<html>
<head>
    <title>Dompdf Example</title>
</head>
<body>
    <h1>Dompdf PDF Generator</h1>

    <form method="POST" action="generate-pdf.php">
        <label for="htmlContent">HTML Content:</label><br>
        <textarea name="htmlContent" rows="6" cols="50"></textarea><br>
        <input type="submit" value="Generate PDF">
    </form>

    <br>

    <a href="generate-pdf.php?preview=1" target="_blank">Preview PDF</a>
</body>
</html>
