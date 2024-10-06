<?php
session_start();

// Establishing Connection with Server
$connect = new mysqli("localhost", "root", "root@123", "placement");

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$USN = $_POST['USN'];
$Question = $_POST['Question'];
$Answer = $_POST['Answer'];

// Prepare and execute the query
$stmt = $connect->prepare("SELECT Question, Answer FROM hlogin WHERE Username = ?");
$stmt->bind_param("s", $USN);
$stmt->execute();
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($dbQuestion, $dbAnswer);
    $stmt->fetch();

    // Verify security question and answer
    if ($dbQuestion == $Question && $dbAnswer == $Answer) {
        $_SESSION['reset'] = $USN;
        header("location: Reset password.php");
    } else {
        echo "<center>Failed! Incorrect Credentials</center>";
    }
} else {
    echo "<center> Enter Something Correctly!!! </center>";
}

// Close statement and connection
$stmt->close();
$connect->close();
?>
