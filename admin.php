<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: staff_login.php");
    exit;
}
?>
<?php

$conn = new mysqli('162.241.148.36', 'scitafyp_scitdb','Scitnew@2008', 'scitafyp_scitdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle approval logic when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];
    $updateSql = "UPDATE user_login SET status = 'approved' WHERE User_name = '$user_id'";
    $conn->query($updateSql);
}

// Handle delete logic when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user_id"])) {
    $delete_user_id = $_POST["delete_user_id"];
    $deleteSql = "DELETE FROM user_login WHERE User_name = '$delete_user_id'";
    $conn->query($deleteSql);
}

// Handle search logic
$searchTerm = isset($_GET["search"]) ? $_GET["search"] : "";
$searchCondition = "WHERE User_name LIKE '%$searchTerm%' OR Name LIKE '%$searchTerm%'";

// Retrieve records with search condition
$sql = "SELECT * FROM user_login $searchCondition ORDER BY status='pending' DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Interface</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
   
<style>
body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    form {
        margin-top: 20px;
        text-align: center;
    }

    label {
        margin-right: 10px;
    }

    #search {
        padding: 8px;
        width: 200px;
    }

    input[type="submit"] {
        padding: 8px;
        background-color: #4caf50;
        color: white;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #4caf50;
        color: white;
    }

    .approved {
        color: green;
        font-weight: bold;
    }
    .delete-icon {
        color: #e74c3c; /* Red color for delete icon */
        cursor: pointer;
    }
     nav {
            text-align: center;
            margin-bottom: 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            padding: 10px 0;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav img {
            max-width: 2000px;
            height: auto;
        }

        nav a {
            text-decoration: none;
            color: blue;
        }

        nav a:hover {
            text-decoration: underline;
        }
</style>
<body>
    <nav>
    <img src="logo.png" alt="" srcset="">
</nav><br><br><br><br><br><br>

    <h2>Admin Interface - Registrations</h2>

    <!-- Search form -->
    <form method="get" action="">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" value="<?php echo $searchTerm; ?>"><br><br>
        <input type="submit" value="Search">
    </form>

    <table>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Mobile Number</th>
            <th>Status</th>
            <th>Action</th>
            <th>Delete</th> <!-- New column for delete action -->
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['Name']}</td>
                    <td>{$row['User_name']}</td>
                    <td>{$row['Mob_no']}</td>
                    <td>";

            if ($row['status'] == 'pending') {
                echo "Pending";
            } else {
                echo "<span class='approved'>Approved</span>";
            }

            echo "</td>
                    <td>";

            if ($row['status'] == 'pending') {
                echo "<form method='post' action='addmin_approve.php'>
                            <input type='hidden' name='user_id' value='{$row['User_name']}'>
                            <input type='submit' value='Approve'>
                        </form>";
            }

            echo "</td>
                    <td>";

            // Add the delete form
            echo " <form method='post' action=''>
        <input type='hidden' name='delete_user_id' value='{$row['User_name']}'>
        <button type='submit' class='delete-icon'><i class='fas fa-trash'></i></button>
    </form>";

            echo "</td>
                </tr>";
        }
        ?>
    </table>
    <br><br><br><br>
   <a href="try.php" style="display: block; text-align: center;">Go Back</a>
   

</body>
</html>

<?php
$conn->close();
?>
