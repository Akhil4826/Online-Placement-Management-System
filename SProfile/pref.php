<?php
session_start();
if (isset($_SESSION["username"])) {
    echo "Welcome, " . $_SESSION['username'] . "!";
} else {
    header("location: index.php");
    exit();
}
?>
<?php
$connect = new mysqli("localhost", "root", "root@123", "details");

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
if (isset($_POST['submit'])) {
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $USN = $_POST['USN'];
    $sun = $_SESSION["username"];
    $phno = $_POST['Num'];
    $email = $_POST['Email'];
    $date = $_POST['DOB'];
    $cursem = $_POST['Cursem'];
    $branch = $_POST['Branch'];
    $per = $_POST['Percentage'];
    $puagg = $_POST['Puagg'];
    $beaggregate = $_POST['Beagg'];
    $back = $_POST['Backlogs'];
    $hisofbk = $_POST['History'];  // Assume 'Y' or 'N'
    $detyear = $_POST['Dety'];
    $approve = '0';

    // Convert 'Y' to 1 and 'N' to 0
    $hisofbk = ($hisofbk === 'Y') ? 1 : 0;

    if ($USN != '' && $email != '') {
        if ($USN == $sun) {
            $stmt = $connect->prepare("INSERT INTO basicdetails (FullName, USN, Mobile, Email, DOB, Sem, Branch, SSLC, `PU/Dip`, BE, Backlogs, HofBacklogs, DetainYears, Approve) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // Concatenate first and last name for FullName
            $fullName = $fname . ' ' . $lname;
            
            $stmt->bind_param("ssssssssssssss", $fullName, $USN, $phno, $email, $date, $cursem, $branch, $per, $puagg, $beaggregate, $back, $hisofbk, $detyear, $approve);
            
            if ($stmt->execute()) {
                echo "<center>Details have been received successfully...!!</center>";
            } else {
                echo "<center>FAILED</center>";
            }
            
            $stmt->close();
        } else {
            echo "<center>Enter your USN only...!!</center>";
        }
    }
}
if (isset($_POST['update'])) {
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $USN = $_POST['USN'];
    $sun = $_SESSION["username"];
    $phno = $_POST['Num'];
    $email = $_POST['Email'];
    $date = $_POST['DOB'];
    $cursem = $_POST['Cursem'];
    $branch = $_POST['Branch'];
    $per = $_POST['Percentage'];
    $puagg = $_POST['Puagg'];
    $beaggregate = $_POST['Beagg'];
    $back = $_POST['Backlogs'];
    $hisofbk = $_POST['History'];  // Assume 'Y' or 'N'
    $detyear = $_POST['Dety'];
    $approve = '0';

    // Convert 'Y' to 1 and 'N' to 0
    $hisofbk = ($hisofbk === 'Y') ? 1 : 0;

    if ($USN != '' && $email != '') {
        if ($USN == $sun) {
            $stmt = $connect->prepare("SELECT * FROM basicdetails WHERE USN = ?");
            $stmt->bind_param("s", $USN);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
                $stmt->close();
                
                $update_stmt = $connect->prepare("UPDATE basicdetails SET FullName = ?, Mobile = ?, Email = ?, DOB = ?, Sem = ?, Branch = ?, SSLC = ?, `PU/Dip` = ?, BE = ?, Backlogs = ?, HofBacklogs = ?, DetainYears = ?, Approve = ? WHERE USN = ?");
                
                // Concatenate first and last name for FullName
                $fullName = $fname . ' ' . $lname;
                
                $update_stmt->bind_param("ssssssssssssss", $fullName, $phno, $email, $date, $cursem, $branch, $per, $puagg, $beaggregate, $back, $hisofbk, $detyear, $approve, $USN);
                
                if ($update_stmt->execute()) {
                    echo "<center>Data Updated successfully...!!</center>";
                } else {
                    echo "<center>FAILED</center>";
                }
                
                $update_stmt->close();
            } else {
                echo "<center>NO record found for update</center>";
            }
        } else {
            echo "<center>Enter your USN only</center>";
        }
    }
}


$connect->close();
?>
