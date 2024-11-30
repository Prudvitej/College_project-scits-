
<!DOCTYPE html>
<html>
<head>
    <title>Staff Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
        .logout   {
            display: inline-block;
            padding: 10px 20px;
            background-color: red;
            color: white;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <nav>
        <img src="logo.png" alt="Logo">
        <a href="index.html">Home</a>
        
    </nav>
    <br><br><br>
    <h2 style="color:red">WELCOME TO SCITS STAFF PORTAL</span></h2>
    <br><br>
    <div>
        <a href="import.php" class="button">Student End-Exam Registration Check</a><br><br><br>
        <a href="admin.php" class="button">Admin Approve</a><br><br><br><br><br><br>
        <a href="logout.php" class="logout">Logout</a><br><br><br><br>
         <input type="button" value="Back" onclick="window.history.back();" />
    </div>
</body>
</html>
