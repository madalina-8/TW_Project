
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="about.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bad7801a4d.js" crossorigin="anonymous"></script>
    <title>Obesity visualizer</title>
</head>
<body>
    
<header>
<nav class="navbar">
    <div class="logo">
       <a href="#"> 
           <img src="logo.png" alt="logo" width="200"> 
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
            <li><a href="about.php">About</a></li>
            <li><a href="../admin/admin.php">Admin</a></li>

        </ul>
    </div>
</nav>
</header>


<section>
<div class="card-container">
    <div class="card">
      <div class="content">
          <h2>01</h2>
          <h3>Our mission</h3>
          <p>We provide visual statistics, different filters and relevant information about obesity around the world.
          </p>
      </div>
    </div>
    <div class="card">
        <div class="content">
            <h2>02</h2>
            <h3>Who are we?</h3>
            <p>We're a creative team of three students who started their journey into the web-technology field.
            </p>
            <div class="imgBox"><img src="lorin.jpg" alt="lorin"></div>
            <div class="imgBox"><img src="mada.jpg" alt="mada"></div>
            <div class="imgBox"><img src="tudor.jpg" alt="tudor"></div>
            <div class="names">
                <p>Lorin Budacă Mădălina Dulhac Tudor Crăciun</p>
            </div>
        </div>
      </div>
      <div class="card">
        <div class="content">
            <h2>03</h2>
            <h3>Website features</h3>
            <p>You can visualize the obesity statistics in many forms, you can apply filters, export the data in different formats,
                visit similar websites and even keep in touch with us!
            </p>
        </div>
      </div>
</div>

<div class="form-container"> 
    <div class="form">
        <div class="contact-info">
            <h3 class="title">Get in touch with us!</h3>
            <p>You're a click away from connecting with us!
                If you enjoyed our work so far, please give us a feedback
                by using the form on the right side of the page.
                If you notice any kind of irregularity, let us know! 
            </p>
            <p>We truly appreciate you for visiting our website
                and we do our best to deliver good services!
            </p>
        </div>


        <div class="contact-form">

        <?php

        if(isset($_GET['error'])) {
            echo "<script>alert('Please fill in the blanks!')</script>";
        }

        if(isset($_GET['succes'])) {
            echo "<script>alert('Message succesfully sent!!')</script>";
        }
        ?>
            <form action="contactForm.php" method="post">
                <h3 class="title">Contact us</h3>  
                <div class="input-container">
                <input type="text" name="name" class="input">
                <label>Full name</label>
                <span>Full name</span>
                </div>
                <div class="input-container">
                    <input type="email" name="email" class="input">
                    <label>Email</label>
                    <span>Email</span>
                </div>
                <div class="input-container">
                    <input type="text" name="subject" class="input">
                    <label>Subject</label>
                    <span>Subject</span>
                </div>
                <div class="input-container textarea">
                    <textarea name="message" class="input"></textarea>
                    <label>Message</label>
                    <span>Message</span>
                </div>
                <input type="submit" value="Send" class="btn" name="send">
         
            </form>
        </div>
    </div>
</div>    


<script src="form.js"></script>
</section>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-column">
                <h4>Navigate</h4>
                <ul>
                    <li><a href="../home/home.php">Home</a></li>
                    <li><a href="../compare/compare.php">Compare</a></li>
                    <li><a href="about.php">About</a></li>
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
<script src="script.js"></script>
</body>
</html>
