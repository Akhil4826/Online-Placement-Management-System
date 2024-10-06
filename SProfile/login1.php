<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if ($username && $password) {
    $connect = new mysqli("localhost", "root", "root@123", "placement");

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Prepare and execute the query
    $stmt = $connect->prepare("SELECT USN, PASSWORD FROM slogin WHERE USN = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows != 0) {
        $stmt->bind_result($dbusername, $dbpassword);
        $stmt->fetch();

        if ($username == $dbusername && $password == $dbpassword) {
            echo "<center>Login Successful..!! <br/>Redirecting you to HomePage! <br/>If not, go to <a href='index.php'>Here</a></center>";
            echo "<meta http-equiv='refresh' content='3; url=index.php'>";
            $_SESSION['username'] = $username;
        } else {
            $message = "Username and/or Password incorrect.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            echo "<center>Redirecting you back to Login Page! If not, go to <a href='index.php'>Here</a></center>";
            echo "<meta http-equiv='refresh' content='1; url=index.php'>";
        }
    } else {
        die("User does not exist");
    }

    // Close statement and connection
    $stmt->close();
    $connect->close();
} else {
    die("Please enter USN and Password");
}
?>
