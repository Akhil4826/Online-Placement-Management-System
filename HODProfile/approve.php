<?php
session_start();

if (!isset($_SESSION['husername'])) {
    header("Location: index.php");
    exit();
}

$id = $_POST["id"];
$dob = $_POST["DOB"];

$link = mysqli_connect("localhost", "root", "root@123", "details");

if ($link === false) {
    die("Error: " . mysqli_connect_error());
}

// Use prepared statements to prevent SQL injection
$sql = "UPDATE `basicdetails` SET Approve = 1, ApprovalDate = ? WHERE USN = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("ss", $dob, $id);

if ($stmt->execute()) {
    echo "Record with USN $id approved.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
mysqli_close($link);
?>
