<?php
session_start();
if (!isset($_SESSION['husername'])) {
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--favicon-->
    <link rel="shortcut icon" href="favicon.ico" type="image/icon">
    <link rel="icon" href="favicon.ico" type="image/icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Manage Students</title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>  
    <!-- Left column -->
    <div class="templatemo-flex-row">
        <div class="templatemo-sidebar">
            <header class="templatemo-site-header">
                <div class="square"></div>
                <?php
                $Welcome = "Welcome";
                echo "<h1>" . $Welcome . "<br>" . $_SESSION['husername'] . "</h1>";
                echo "<br>";
                echo "<h1>(</h1>";
                echo "<h1>" . $_SESSION['department'] . "</h1>";
                echo "<h1>)</h1>";
                ?>
            </header>
            <div class="profile-photo-container">
                <img src="images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">  
                <div class="profile-photo-overlay"></div>
            </div>      
            <!-- Search box -->
            <form class="templatemo-search-form" role="search">
                <div class="input-group">
                    <button type="submit" class="fa fa-search"></button>
                    <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">           
                </div>
            </form>
            <div class="mobile-menu-icon">
                <i class="fa fa-bars"></i>
            </div>
            <nav class="templatemo-left-nav">          
                <ul>
                    <li><a href="login.php"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                    <li><a href="#" class="active"><i class="fa fa-users fa-fw"></i>Manage Students</a></li>
                    <li><a href="preferences.php"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
                    <li><a href="logout.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
                </ul>  
            </nav>
        </div>
        <!-- Main content --> 
        <div class="templatemo-content col-1 light-gray-bg">
            <div class="templatemo-top-nav-container">
                <div class="row">
                    <nav class="templatemo-top-nav col-lg-12 col-md-12">
                        <ul class="text-uppercase">
                            <li><a href="../../Homepage/index.php">Home CIT-PMS</a></li>
                            <li><a href="../../Drives/index.php">Drives</a></li>
                            <li><a href="Notif.php">Notification</a></li>
                            <li><a href="Change Password.php">Change Password</a></li>
                        </ul>  
                    </nav> 
                </div>
            </div>
            <div class="templatemo-content-container">
                <div class="templatemo-content-widget no-padding">
                    <div class="panel panel-default table-responsive">
                        <table class="table table-striped table-bordered templatemo-user-table">
                            <thead>
                                <tr>
                                    <td><a class="white-text templatemo-sort-by">Full Name</a></td>
                                    <td><a class="white-text templatemo-sort-by">USN</a></td>
                                    <td><a class="white-text templatemo-sort-by">Mobile</a></td>
                                    <td><a class="white-text templatemo-sort-by">Email</a></td>
                                    <td><a class="white-text templatemo-sort-by">DOB</a></td>
                                    <td><a class="white-text templatemo-sort-by">Current Sem</a></td>               
                                    <td><a class="white-text templatemo-sort-by">Branch</a></td>
                                    <td><a class="white-text templatemo-sort-by">SSLC Percentage</a></td>
                                    <td><a class="white-text templatemo-sort-by">PU Percentage</a></td>
                                    <td><a class="white-text templatemo-sort-by">BE Aggregate</a></td>
                                    <td><a class="white-text templatemo-sort-by">Current Backlogs</a></td>
                                    <td><a class="white-text templatemo-sort-by">History of Backlogs</a></td>
                                    <td><a class="white-text templatemo-sort-by">Detain Years</a></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $p = $_SESSION['department'];
                                $num_rec_per_page = 15;
                                $mysqli = new mysqli('localhost', 'root', 'root@123', 'details');

                                // Check connection
                                if ($mysqli->connect_error) {
                                    die("Connection failed: " . $mysqli->connect_error);
                                }

                                // Get current page number
                                $currentpage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                if ($currentpage < 1) $currentpage = 1;

                                $start_from = ($currentpage - 1) * $num_rec_per_page;

                                // Fetch records for current page
                                $sql = "SELECT * FROM basicdetails WHERE Branch = ? LIMIT ?, ?";
                                $stmt = $mysqli->prepare($sql);
                                $stmt->bind_param("sii", $p, $start_from, $num_rec_per_page);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['FullName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['USN']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Mobile']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['DOB']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Sem']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Branch']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['SSLC']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['PU/Dip']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['BE']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Backlogs']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['HofBacklogs']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['DetainYears']) . "</td>";
                                    echo "</tr>";
                                }

                                $stmt->close();

                                // Pagination
                                $sql = "SELECT COUNT(*) FROM basicdetails WHERE Branch = ?";
                                $stmt = $mysqli->prepare($sql);
                                $stmt->bind_param("s", $p);
                                $stmt->execute();
                                $stmt->bind_result($total_records);
                                $stmt->fetch();
                                $stmt->close();

                                $totalpage = ceil($total_records / $num_rec_per_page);

                                echo '<div class="pagination-wrap">';
                                echo '<a href="approve2.php" class="templatemo-edit-btn">Approve</a>';
                                echo '</div>';
                                echo '<div class="pagination-wrap">';
                                echo '<ul class="pagination">';

                                // Previous button
                                if ($currentpage > 1) {
                                    $prev = $currentpage - 1;
                                    echo "<li><a href='manage-users1.php?page=$prev&branch=$p'>&lt;</a></li>";
                                }

                                // Page numbers
                                for ($i = max(1, $currentpage - 2); $i <= min($totalpage, $currentpage + 2); $i++) {
                                    echo "<li><a href='manage-users1.php?page=$i&branch=$p'>$i</a></li>";
                                }

                                // Next button
                                if ($currentpage < $totalpage) {
                                    $nxt = $currentpage + 1;
                                    echo "<li><a href='manage-users1.php?page=$nxt&branch=$p'>&gt;</a></li>";
                                }

                                echo "<li><a>Total Pages: $totalpage</a></li>";
                                echo '</ul>';
                                echo '</div>';

                                $mysqli->close();
                                ?>
                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>
            <br><br>
            <center>
                <label class="control-label" for="inputNote">
                    <h2>OR</h2>
                    <br><br>To View All Students Click Link below:
                </label>
                <br><br>
                <a href="manage-users1.php" class="templatemo-blue-button">View All</a>
            </center>
            <footer class="text-right">
                <br>
                <p>Copyright &copy; 2018 PW-PMS | Developed by
                    <a href="http://PROJECTWORLDS.IN" target="_parent">Projectworlds Technologies</a>
                </p>
                <br>
            </footer>
        </div>
    </div>
    
    <!-- JS -->
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script> <!-- jQuery -->
    <script type="text/javascript" src="js/templatemo-script.js"></script> <!-- Templatemo Script -->
    <script>
    $(document).ready(function(){
        // Content widget with background image
        var imageUrl = $('img.content-bg-img').attr('src');
        $('.templatemo-content-img-bg').css('background-image', 'url(' + imageUrl + ')');
        $('img.content-bg-img').hide();        
    });
    </script>
</body>
</html>
