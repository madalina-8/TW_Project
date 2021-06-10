<?php 
    require("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bad7801a4d.js" crossorigin="anonymous"></script>
    <title>Obesity visualizer</title>
</head>
<body>

<nav class="navbar">
    <div class="logo">
       <a href="#"> 
           <img src="logo.png" width="200"> 
        </a>
    </div>
    <a href="#" class="toggle-button">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </a>
    <div class="navbar-links">
        <ul>
           <li><a href="../home/home.php">Home</a></li>
            <li><a href="../compare/compare.php">Compare</a></li>
            <li><a href="../about/about.php">About</a></li>
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </div>
</nav>

<div class="login-form">
    <div id="middle">
        <h2> ADMIN LOGIN PANEL </h2>
        <form method="POST">
            <div class="input-field">
                <i class="fa fa-user" aria-hidden="true"></i>
                <input type="text" placeholder="Admin Name" name="AdminName">
            </div>

            <div class="input-field">
                <i class="fa fa-lock" aria-hidden="true"></i>
                <input type="password" placeholder="Password" name="AdminPassword">
            </div>

            <button type="submit" name="SignIn">Sign In</button>

        </form>
    </div>
    <div id="right"></div>
</div>

<?php 
        if(isset($_POST['SignIn'])) {
            $query="SELECT * FROM `admin_login` WHERE `Admin_Name`='$_POST[AdminName]' AND `Admin_Password`='$_POST[AdminPassword]'";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result)==1) {
                session_start();
                $_SESSION['AdminLoginId']=$_POST['AdminName']; //set session variables
                header("location: adminPanel.php");
            } else {
                echo "<script>alert('Incorrect name or password!')</script>";
            }
        }


    ?>



<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-column">
                <h4>Navigate</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Compare</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Associated websites</h4>
                <ul>
                    <li><a href="https://www.worldobesity.org/">World Obesity</a></li>
                    <li><a href="https://www.cdc.gov/obesity/">CDC's Obesity</a></li>
                    <li><a href="https://vizhub.healthdata.org/obesity/">Healthdata</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Follow us</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="https://github.com/madalina-8/TW_Project"><i class="fab fa-github fa-lg"></i></a>
                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>
        </div>
    </div>       
</footer>
<script src="script.js"> </script>
</body>
</html> 
