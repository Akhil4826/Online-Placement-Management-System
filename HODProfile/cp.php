<?php
session_start();

// Establishing Connection with Server
$connect = new mysqli("localhost", "root", "root@123", "placement");

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$Username = $_SESSION['husername'];
$Password = $_POST['Password'];
$repassword = $_POST['repassword'];
$cur = $_POST['curpassword'];

if ($Password && $repassword && $cur) {
    if ($Password == $repassword) {
        // Prepare and execute the query to select user
        $stmt = $connect->prepare("SELECT Password FROM hlogin WHERE Username = ?");
        $stmt->bind_param("s", $Username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($dbpassword);
            $stmt->fetch();

            // Verify current password
            if ($cur == $dbpassword) {
                // Prepare and execute the query to update the password
                $update_stmt = $connect->prepare("UPDATE hlogin SET Password = ? WHERE Username = ?");
                $update_stmt->bind_param("ss", $Password, $Username);

                if ($update_stmt->execute()) {
                    echo "<center>Password Changed Successfully</center>";
                } else {
                    echo "<center>Can't Be Changed! Try Again</center>";
                }

                // Close the update statement
                $update_stmt->close();
            } else {
                die("<center>Error! Please Check your Password</center>");
            }
        } else {
            die("<center>Username not Found</center>");
        }

        // Close the select statement
        $stmt->close();
    } else {
        die("<center>Passwords Do Not Match</center>");
    }
} else {
    die("<center>Enter All Fields</center>");
}

// Close the database connection
$connect->close();
?>
