<?php

$conn = new mysqli('162.241.148.36', 'scitafyp_scitdb','Scitnew@2008', 'scitafyp_scitdb');


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "user_id" key is set in the $_POST array
    if(isset($_POST["user_id"])) {
        $user_id = $conn->real_escape_string($_POST["user_id"]);

        // Update the user status to 'approved'
        $updateSql = "UPDATE user_login SET status = 'approved' WHERE User_name = '$user_id'";

        if ($conn->query($updateSql) === TRUE) {
            echo "Approval successful!";
            header("Refresh: 3; URL=admin.php"); 
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "User ID not set in the POST data.";
    }
}

$conn->close();
?>
