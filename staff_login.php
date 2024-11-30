<?php
session_start();

$conn = new mysqli('162.241.148.36', 'scitafyp_scitdb','Scitnew@2008', 'scitafyp_scitdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_username = $_POST["username"];
    $entered_password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM user_login WHERE User_name = ?");
    $stmt->bind_param("s", $entered_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["Password"] === $entered_password) {
            if ($row["status"] == "approved") {
                $_SESSION["logged_in"] = true;
                header("Location: try.php");
                exit();
            } elseif ($row["status"] == "pending" || empty($row["status"])) {
                echo '<script>alert("Your account is pending approval. Please contact the exam branch to get approval.");</script>';
            }
        } else {
            echo '<script>alert("Username or password is incorrect.");</script>';
        }
    } else {
        echo '<script>alert("Username or password is incorrect.");</script>';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
     <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column; /* Centering items vertically */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        td {
            padding: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        h1 {
            color: red;
            text-align: center;
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
        @media only screen and (max-width: 600px) {
        button {
          width: 50%;
        }
        #logo {
          width: 450px;
        }
         form {
                width: 90%; /* Adjust form width for mobile */
            }
    }
    </style>
</head>
<body>
    <nav>
        <img src="logo.png" alt="Logo"><br><br><br>
        <a href="index.html" >Home</a>
    </nav><br><br><br><br><br><br>
    
    <form method="post">
        <table>
            <tr>
                <td colspan="2"><h1>Login Form</h1></td>
            </tr>
            <tr>
                <td><label for="username">Username:</label></td>
                <td><input type="text" id="username" name="username" required></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td> <input type="password" id="password" name="password" required>
        <span toggle="#password" class="eye" onclick="togglePasswordVisibility()"></span>
    </td>
            </tr>   
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Login"></td>
            </tr>
            <tr>
                <td></td>
                <td>Not a User? <a href="registration.php">Register</a></td>
            </tr>
        </table>
        
         <input type="button" value="Back" onclick="window.history.back();" />
    </form>
     <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.querySelector(".eye");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>
</html>
