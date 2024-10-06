<?php
session_start();

$branch = $_POST['Branch'];
$husername = $_POST['username'];
$password = $_POST['password'];

if ($husername && $password && $branch) {
    // Connect to the database
    $connect = new mysqli("localhost", "root", "root@123", "placement");

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Prepare and execute the query
    $stmt = $connect->prepare("SELECT Branch, Username, Password FROM hlogin WHERE Username = ?");
    $stmt->bind_param("s", $husername);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbbranch, $dbusername, $dbpassword);
        $stmt->fetch();

        // Verify credentials
        if ($branch == $dbbranch && $husername == $dbusername && $password == $dbpassword) {
            echo "<center>Login Successful..!! <br/>Redirecting you to HomePage! <br/>If not, go to <a href='index.php'>Here</a></center>";
            echo "<meta http-equiv='refresh' content='3; url=index.php'>";
            $_SESSION['husername'] = $husername;
            $_SESSION['department'] = $branch;
        } else {
            $message = "Username and/or Password and/or Department are/is incorrect.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            echo "<center>Redirecting you back to Login Page! If not, go to <a href='index.php'>Here</a></center>";
            echo "<meta http-equiv='refresh' content='1; url=index.php'>";
        }
    } else {
        echo "User does not exist";
    }

    // Close statement and connection
    $stmt->close();
    $connect->close();
} else {
    $message = "Field can't be left blank";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<center>Redirecting you back to Login Page! If not, go to <a href='index.php'>Here</a></center>";
    echo "<meta http-equiv='refresh' content='1; url=index.php'>";
}
?>
