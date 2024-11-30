<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: staff_login.php");
    exit;
}

if (isset($_POST['delete'])) {
 
$conn = new mysqli('162.241.148.36', 'scitafyp_scitdb','Scitnew@2008', 'scitafyp_scitdb');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $hallticket = $_POST['hallticket'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $regulation = $_POST['regulation'];
    $time =$_POST[ 'submission_time'];

    // Prepare and execute SQL statement to delete the record
    $sql = "DELETE FROM reg WHERE hallTicketNumber = '$hallticket' AND YEAR = '$year' AND SEM = '$semester' AND regulation = '$regulation' AND submission_time = '$time'";

    if ($conn->query($sql) === TRUE) {
        echo 'Deleted sucessfully';
        echo '<br>';
        echo '<br>';
        echo '<input type="button" value="Back" onclick="window.history.back();" />';
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>


