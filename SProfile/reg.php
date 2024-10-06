<?php
$connect = new mysqli("localhost", "root", "root@123", "placement");

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if (isset($_POST['submit'])) { 
    $Name = $_POST['Fullname'];
    $USN = $_POST['USN'];
    $password = $_POST['PASSWORD'];
    $repassword = $_POST['repassword'];
    $Email = $_POST['Email'];
    $Question = $_POST['Question'];
    $Answer = $_POST['Answer'];

    // Check if the USN already exists
    $stmt = $connect->prepare("SELECT * FROM slogin WHERE USN = ?");
    $stmt->bind_param("s", $USN);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        if ($repassword == $password) {
            // Insert new user into slogin table
            $insert_stmt = $connect->prepare("INSERT INTO slogin (Name, USN, PASSWORD, Email, Question, Answer) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("ssssss", $Name, $USN, $password, $Email, $Question, $Answer);

            if ($insert_stmt->execute()) {
                echo "<center>You have registered successfully...!! Go back to </center>";
                echo "<center><a href='index.php'>Login here</a></center>";
            } else {
                echo "<center>Registration failed. Please try again.</center>";
            }

            $insert_stmt->close();
        } else {
            echo "<center>Your passwords do not match</center>";
        }
    } else {
        echo "<center>This USN already exists</center>";
    }

    $stmt->close();
}

$connect->close();
?>
