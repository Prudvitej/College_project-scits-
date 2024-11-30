<?php
// Start a session if not already started
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: staff_login.php");
    exit;
}

// Function to sanitize data for Excel output
function sanitizeForExcel($data) {
    // If data is numeric, return as is
    if (is_numeric($data)) {
        return $data;
    }
    // Otherwise, escape special characters and enclose in double quotes
    return '"' . htmlspecialchars($data, ENT_QUOTES) . '"';
}

$conn = new mysqli('162.241.148.36', 'scitafyp_scitdb','Scitnew@2008', 'scitafyp_scitdb');

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT * FROM reg";
$result = $conn->query($sql);

// Set headers for Excel download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="student_data.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// Open file handle for writing
$output = fopen('php://output', 'w');

// Write column headers
fputcsv($output, array('Hall Ticket Number', 'Program', 'Course', 'Type of semester', 'Regulation', 'Name', 'Year', 'Semester', 'Subject Names', 'Lab Names', 'Mobile number', 'Registration form Number', 'Submitted On', 'No of Subjects', 'No of Labs'));

// Fetch and write data rows
while ($row = $result->fetch_assoc()) {
    $rowData = array(
        $row['hallTicketNumber'],
        $row['program'],
        $row['course'],
        $row['SEM_TYPE'],
        $row['regulation'],
        $row['Name'],
        $row['YEAR'],
        $row['SEM'],
        $row['subject_Name'],
        $row['Lab_Names'],
        $row['MOB_NO'],
        $row['REG_FORM_NUMBER'],
        $row['submission_time'],
        $row['subapp'],
        $row['lab_count']
    );
    // Sanitize data for Excel output
    $rowData = array_map('sanitizeForExcel', $rowData);
    // Write row to CSV file
    fputcsv($output, $rowData);
}

// Close file handle
fclose($output);

// Close database connection
$conn->close();
?>
