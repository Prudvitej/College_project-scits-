
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sree Chaitanya Institute of Technological Sciences | END EXAM Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 80%;
            margin: 50px auto;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
        }

        input {
            padding: 8px;
            margin-bottom: 15px;
            width: 80%;
        }

        button {
             /* padding: 10px; */
    background-color: transparent;
    color: white;
    border: none;
    cursor: pointer;
    width: 20%;
    margin: 0 auto;
    display: block;
        }
        #back{
            width: 20%;
            align-items: center;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            margin-top: 20px;
            overflow-x: auto;
        }


        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        th {
            border: 1px solid #ddd;
            text-align: center;
        }
 .success {
    color: #4CAF50;
    font-weight: bold;
    text-align: center;
    margin-top: 20px;
    font-size: 20px;
}
.success a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.success a:hover {
    background-color: #45a049;
}
        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
            }

            form {
                width: 95%;
            }

            button {
                width: 50%;
            }
              nav {
        text-align: center;
        padding: 10px;
    }
     table {
            width: 100%;
            margin: 10px 0;
        }

        th, td {
            padding: 8px;
            font-size: 12px;
        }

        h2 {
            font-size: 14px;
            margin-right: 5px;
        }

    nav img {
        max-width: 100%;
        height: auto;
    }
        }
    </style>
</head>
<nav>
    <img src="logo.png" alt="" srcset="">
</nav>

<body>
    <?php
require('fpdf/fpdf.php');

$conn = new mysqli('162.241.148.36', 'scitafyp_scitdb','Scitnew@2008', 'scitafyp_scitdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $reg_form = mysqli_real_escape_string($conn, $_POST["reg_form"]);
    $hallticket = mysqli_real_escape_string($conn, $_POST["hallticket"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $year = mysqli_real_escape_string($conn, $_POST["year"]);
    $regulation = mysqli_real_escape_string($conn, $_POST["regulation"]);

    $semesters = $_POST['sem'];
    $semesterTypes = $_POST['reg-sup'];
    $subjects = $_POST['subject'];
    $mobno = $_POST['mobno'];
    $amounts = $_POST['amount'];
    $fines = $_POST['fine'];
    $labs = $_POST['lab'];
    $subappCounts = $_POST['subapp'];
    $labnames = $_POST['labname'];
    $program = $_POST['program'];
    $course = $_POST['course'];

    $insertSql = $conn->prepare("INSERT INTO reg (hallTicketNumber, subject_Name, submission_time,YEAR, SEM,regulation, SEM_TYPE, AMOUNT,FINE,TOTAL_AMOUNT,Name,subapp,lab_count,REG_FORM_NUMBER,MOB_NO,Lab_Names,program,course) VALUES (?, ?, NOW(),?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");

    if (!$insertSql) {
        die("Error preparing statement: " . $conn->error);
    }

    foreach ($semesters as $key => $semester) {
        $subject = $subjects[$key];
        $amount = $amounts[$key];
        $fine = $fines[$key];
        $labCount = $labs[$key];
        $subappCount = $subappCounts[$key];
        $labname = $labnames[$key];
        $totalAmount = floatval($amount) + floatval($fine);

        $semesterType = isset($semesterTypes[$key]) ? $semesterTypes[$key] : 'Regular';

        $insertSql->bind_param("ssssssssssdssssss", $hallticket, $subject, $year, $semester, $regulation, $semesterType, $amount, $fine, $totalAmount, $name, $subappCount, $labCount, $reg_form, $mobno, $labname, $program, $course);

        if (!$insertSql->execute()) {
            echo "<p class='error'>Error inserting data: " . $conn->error . "</p>";
            exit();
        }
        echo '<table border="1">
        <tr>
            <th>Hall Ticket Number</th>
            <th>Year</th>
            <th>Semester</th>
            <th>Subject</th>
            <th>Lab Name</th>
            <th>No. of Subjects</th>
            <th>No. of Labs</th>
            <th>Amount</th>
            <th>Fine</th>
            <th>Total Amount</th>
        </tr>';
        echo '<tr>
            <td>' . $hallticket . '</td>
            <td>' . $year . '</td>
            <td>' . $semester . '</td>
            <td>' . $subject . '</td>
            <td>' . $labname . '</td>
            <td>' . $subappCount . '</td>
            <td>' . $labCount . '</td>
            <td>' . $amount . '</td>
            <td>' . $fine . '</td>
            <td>' . $totalAmount . '</td>
        </tr>';
    echo '</table>';
     echo '<h2 style="color:red"> Note : It is mandatory to Download or Take a screenshot and reverify at the time of end examination payment ....</h2>';
    echo '<h2 style="text-align:right; margin-right : 40px;">-EXAM BRANCH</h2>';
    }
    

    $insertSql->close();

    // Generate receipt content
    $receiptContent = "Receipt for Hall Ticket Number: $hallticket\n";
    $receiptContent .= "Name: $name\n";
    $receiptContent .= "Total Amount: $totalAmount\n";
    $receiptContent .= "Semester Information:\n";

    foreach ($semesters as $key => $semester) {
        $subject = $subjects[$key];
        $amount = $amounts[$key];
        $fine = $fines[$key];
        $labCount = $labs[$key];
        $subappCount = $subappCounts[$key];
        $labname = $labnames[$key];
        $semesterType = isset($semesterTypes[$key]) ? $semesterTypes[$key] : 'Regular';

        $receiptContent .= "Semester: $semester, Type: $semesterType\n";
        $receiptContent .= "Subject Names: $subject\n";
        $receiptContent .= "Lab Names: $labname\n";
        $receiptContent .= "Number of Subjects: $subappCount\n";
        $receiptContent .= "Number of Labs: $labCount\n";
    }
    $receiptsDirectory = "receipts";
    if (!is_dir($receiptsDirectory)) {
        mkdir($receiptsDirectory, 0777, true);
    }

    $receiptFileName = "receipt_" . $hallticket . ".txt";
    $receiptFilePath = $receiptsDirectory . "/" . $receiptFileName;
    file_put_contents($receiptFilePath, $receiptContent);

   $pdf = new FPDF('L');
$pdf->AddPage();
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Image('logo.png', 10, 10, 310);

$pdf->Cell(0, 10, '', 0, 8, 'C');
$pdf->Cell(0, 10, '', 0, 8, 'C');
$pdf->Cell(0, 10, '', 0, 8, 'C');
$pdf->Cell(0, 10, 'Hall Ticket Number: ' . $hallticket, 0, 1, 'C');
$pdf->Ln();
$pdf->Cell(0, 10, 'Name: ' . $name, 0, 1, 'C');
$pdf->Ln();
$pdf->Cell(0, 10, 'Total amount : ' . $totalAmount, 0, 1, 'C');


$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'Year', 1);
$pdf->Cell(25, 10, 'Semester', 1);
$pdf->Cell(70, 10, 'Subject', 1);
$pdf->Cell(50, 10, 'Lab Name', 1); 
$pdf->Cell(33, 10, 'No. of Subjects', 1);
$pdf->Cell(30, 10, 'No. of Labs', 1);

$pdf->Ln();

foreach ($semesters as $key => $semester) {
    $subject = $subjects[$key];
    $labname = $labnames[$key];
    $subappCount = $subappCounts[$key];
    $labCount = $labs[$key];

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 10, substr($year, 0, 5), 1);
    $pdf->Cell(25, 10, substr($semester, 0, 8), 1);
    $pdf->Cell(70, 10, $subject, 1); 
    $pdf->Cell(50, 10, $labname, 1);
    $pdf->Cell(33, 10, substr($subappCount, 0, 15), 1);
    $pdf->Cell(30, 10, substr($labCount, 0, 10), 1);
    $pdf->Ln();
}

$pdf->Cell(0, 10, 'Total amount : ' . $totalAmount, 0, 1, 'C');

$pdf->Cell(0, 10, '-EXAM BRANCH', 0, 1, 'R');
$pdf->Cell(0, 10, '', 0, 1, 'R');
$pdf->Cell(0, 10, '', 0, 1, 'R'); 
$pdf->Cell(0, 10, '', 0, 1, 'R'); 
$pdf->Cell(0, 10, '', 0, 1, 'R'); 
$pdf->Cell(0, 10, '', 0, 1, 'R'); 
$pdf->Cell(0, 10, '', 0, 1, 'R'); 
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(0, 6, 'BY @ POODARI PRUDVI TEJA-', 0, 1, 'R');


$pdfFileName = "receipt_" . $hallticket . ".pdf";
$pdfFilePath = $receiptsDirectory . "/" . $pdfFileName;
$pdf->Output('F', $pdfFilePath);

    echo '<p class="success">Registration successful!<br> <br><br> <a href="' . $pdfFilePath . '" download>Download Receipt</a></p>';
    echo ' <input type="button" value="Back" id="back" onclick="window.history.back();" />';
    exit();
} else {
    // echo "<p class='error'>Please fill in all the required details.</p>";
}

$conn->close();
?>


    <div class="container">
        <!-- <h2 style="color: red; font-weight: bold; text-align:center">SREE CHAITANYA INSTITUTE OF TECHNOLOGICAL SCIENCES <br>B-TECH / MBA END EXAM REGISTRATION</h2> -->
        <form method="post" onsubmit="return validateForm();">
            <table>
                <tr>
                                <td colspan="2" style="text-align: center;color:maroon"><h1><b>End Exam Registration</b></h1></td>

                </tr>
                <tr>
                    <th><label>PROGRAMME</label></th>
                    <td class="text-left">
                        <select name="program" id="program" required>
                            <option value="" selected disabled hidden >Select Program</option>
                            <option value="B.Tech">B.Tech</option>
                            <option value="MBA">MBA</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>COURSE</label></th>
                    <td class="text-left">
                        <select name="course" id="course" required>
                            <option value="" selected disabled hidden >Select Course</option>
                            <option value="CSE">CSE</option>
                            <option value="ECE">ECE</option>
                            <option value="EEE">EEE</option>
                            <option value="MBA">MBA</option>
                            <option value="AIML">AIML</option>
                            <option value="CSM">CSM</option>
                            <option value="CIVIL">CIVIL</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="hallticket">HALL TICKET NUMBER</label></th>
                    <td class="text-left"><input type="text" id="hallticket" name="hallticket" placeholder="Enter Your hallticket number" required maxlength="10"/></td>
                </tr>
                <tr>
                    <th><label for="name">NAME</label></th>
                    <td><input type="text" id="name" name="name" placeholder="Enter Your Name" required /></td>
                </tr>
                <tr>
                    <th><label for="name">Registration Form number <br> <span style="color: red;">(If your are applying For regular then use <b style="color:#45a049;">MBA - 0000 ,EEE - 2222 , ECE - 4444 , CSE - 5555 , CSM - 6666 , AIML - 7373 </b> )<br>(Applying for supply then use See top-right of Registration form )</span></label></th>
                    <td><input type="text" id="reg_form" name="reg_form" placeholder="Enter Registration Number" required maxlength="5"/></td>
                </tr>
                <tr>
                    <th><label>REGULATION</label></th>
                    <td class="text-left">
                        <select id="regulation" name="regulation" required>
                            <option value="" selected disabled hidden>Select Regulation</option>
                            <option value="r09">R09</option>
                            <option value="r12">R12</option>
                            <option value="r15">R15</option>
                            <option value="r16">R16</option>
                            <option value="r17">R17</option>
                            <option value="r18">R18</option>
                            <option value="r19">R19</option>
                            <option value="r22">R22</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="year">APPLYING FOR YEAR</label></th>
                    <td class="text-left">
                        <select id="year" name="year" required>
                            <option value="" selected disabled hidden>Select year</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </td>
                </tr>
                <!-- first set end -->
                <!-- first set -->
                <tr>
                    <th colspan="2"><label style="color: red;font-weight: bold; text-align:center">APPLY FOR SEMESTER </label></th>
                </tr>
                <tr>
                    <th><label for="sem">SEMESTER</label></th>
                    <td> 
                        <select id="sem" name="sem[]" required>
                            <option value="" selected disabled hidden >Select Semester</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="reg-sup1">TYPE OF EXAMINATION</label></th>
                    <td>
                        <select id="reg-sup" name="reg-sup[]" required>
                            <option value="" selected disabled hidden>Select Semester type</option>
                            <option value="Regular">Regular</option>
                            <option value="Supply">Supply</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="subject">SUBJECT NAMES <span style="color: red;">(ex: M1,M2,BEE,CHEM)</span></label></td>
                    <td><input type="text" id="subject" name="subject[]" placeholder="Subjects" required/></td>
                </tr>
                <tr>
                    <th><label for="lab">Lab Names<span style="color: red;">(ex: BEE LAB,CHEM LAB) <br>If No Labs Then Type (n/a)</span></label></th>
                    <td><input type="text" id="labname" name="labname[]" placeholder="Subjects" required /></td>
                </tr>
                <tr>
                    <th><label for="lab">NUMBER OF SUBJECTS APPLIED</label></th>
                    <td><input type="number" id="subapp" name="subapp[]" placeholder="Enter Number of Subject" required/></td>
                </tr>
                <tr>
                    <th><label for="lab">NUMBER OF LABS APPLIED</label></th>
                    <td><input type="number" id="lab" name="lab[]" placeholder="Enter count of lab" required/></td>
                </tr>

                <tr>
                    <th><label for="fine">FINE</label></th>
                    <td>
                        <select id="fine" name="fine[]" onchange="calculateAmount()" required>
                        <option value="" selected disabled hidden>Select Fine Type</option>
                            <option value="0">Without Fine</option>
                            <option value="100">100</option>
                            <option value="1000">1,000</option>
                            <option value="2000">2,000</option>
                            <option value="5000">5,000</option>
                            <option value="10000">10,000</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="amount">AMOUNT</label></th>
                    <td><input type="text" id="amount" name="amount[]" placeholder="Enter Amount" oninput="calculateAmount()" required/></td>
                </tr>
                <!-- first set end -->
                <!-- second set -->
                <tr>
                    <th colspan="2"><label style="color: red;font-weight: bold; text-align:center">ANOTHER SEMESTER</label></th>
                </tr>
                <tr>
                    <th><label for="sem1">SEMESTER </label></th>
                    <td>
                        <select id="sem1" name="sem[]">
                            <option value="" selected disabled hidden>Select Semester</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="reg-sup1">TYPE OF EXAMINATION</label></th>
                    <td>
                        <select id="reg-sup1" name="reg-sup[]">
                            <option value="" selected disabled hidden>Select Semester type</option>
                            <option value="Regular">Regular</option>
                            <option value="Supply">Supply</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="subject1">SUBJECT NAMES <span style="color: red;">(ex: M1,M2,BEE,CHEM)</span></label></th>
                    <td><input type="text" id="subject1" name="subject[]" placeholder="Subjects" /></td>
                </tr>
                <tr>
                    <th><label for="lab1">LAB NAMES <span style="color: red;">(ex: BEE LAB,CHEM LAB)<br> If No Labs Then Type (n/a)</span></label></th>
                    <td><input type="text" id="labname1" name="labname[]" placeholder="Subjects" /></td>
                </tr>
                <tr>
                    <th><label for="subapp1">NUMBER OF SUBJECTS APPLIED</label></th>
                    <td><input type="number" id="subapp1" name="subapp[]" placeholder="Enter count of Sub" /></td>
                </tr>
                <tr>
                    <th><label for="lab1">NUMBER OF LABS APPLIED</label></th>
                    <td><input type="number" id="lab1" name="lab[]" placeholder="Enter count of lab" /></td>
                </tr>
                <tr>
                    <th><label for="fine1">FINE</label></th>
                    <td>
                        <select id="fine1" name="fine[]" onchange="calculateAmount()">
                        <option value="" selected disabled hidden>Select Fine Type</option>
                            <option value="0">Without Fine</option>
                            <option value="100">100</option>
                            <option value="1000">1,000</option>
                            <option value="2000">2,000</option>
                            <option value="5000">5,000</option>
                            <option value="10000">10,000</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="amount1">AMOUNT</label></th>
                    <td><input type="text" id="amount1" name="amount[]" placeholder="Enter Amount" oninput="calculateAmount()" /></td>
                </tr>
                <!-- second set end -->

                <!-- Total Amount field for the second set -->
                <tr>
                    <th><label for="totalAmount">TOTAL</label></th>
                    <td><input type="text" id="totalAmount" name="totalAmount" readonly /></td>
                </tr>

                <tr>
                    <th><label for="mobile">MOBILE NUMBER</label></th>
                    <td><input type="number" id="mobno" name="mobno" maxlength="10" required/></td>
                </tr>
                
                  

            </table><br><br><br>
            <br>  <button type="submit">SUBMIT</button>
            
        </form>
    </div>

    <script>
        function validateForm() {
            var semesters = document.querySelectorAll('[name^="sem"]');
            var subjects = document.querySelectorAll('[name^="subject"]');
            var labCounts = document.querySelectorAll('[name^="lab"]');
            var subapp = document.getElementById('subapp').value;
            var amt = document.getElementById('amount').value;

            for (var i = 0; i < semesters.length; i++) {
                if (semesters[i].value !== "" && subjects[i].value !== "" && labCounts[i].value !== ""&& amt[i].value !== "") {
                    return true;
                }
            }

            alert("Please enter at least one set of semester details.");
            return false;
        }

        function calculateAmount() {
            var fineSelect = document.getElementById('fine');
            var amountInput = document.getElementById('amount');
            var fineSelect1 = document.getElementById('fine1');
            var amountInput1 = document.getElementById('amount1');
            var totalAmountInput = document.getElementById('totalAmount');

            var fineAmounts = {
               '0': 0,
                '500': 500,
                '100': 100,
                '1000': 1000,
                '2000': 2000,
                '5000': 5000,
                '10000': 10000,
            };

            var selectedFine = fineSelect.value;
            var fineAmount = fineAmounts[selectedFine] || 0;

            var selectedFine1 = fineSelect1.value;
            var fineAmount1 = fineAmounts[selectedFine1] || 0;

            var amount = amountInput.value || 0;
            var amount1 = amountInput1.value || 0;

            var totalAmount = parseFloat(amount) + parseFloat(fineAmount) + parseFloat(amount1) + parseFloat(fineAmount1);

            totalAmountInput.value = totalAmount.toFixed(2);
        }
    </script>
    <script>
        const inp=document.getElementById("hallticket");

        inp.addEventListener("input",()=>{
            inp.value=inp.value.toUpperCase();
        }
        );
    </script>
<script>
    window.onload = function () {
        // Get references to both select elements
        var semSelect1 = document.getElementById("sem");
        var semSelect2 = document.getElementById("sem1");

        // Listen for change events on the first select element
        semSelect1.addEventListener("change", function () {
            // Clear options in the second select element
            semSelect2.innerHTML = "";

            // Get the selected value from the first select element
            var selectedValue = semSelect1.value;

            // Loop through options in the first select element
            // Add options to the second select element, excluding the selected value
            for (var i = 0; i < semSelect1.options.length; i++) {
                var option = semSelect1.options[i];
                if (option.value !== selectedValue) {
                    semSelect2.appendChild(option.cloneNode(true));
                }
            }

            // Add a default option to the second select element
            var defaultOption = document.createElement("option");
            defaultOption.text = "Select Semester";
            defaultOption.value = "";
            semSelect2.insertBefore(defaultOption, semSelect2.firstChild);
        });
    };
</script>

</body>

</html>
