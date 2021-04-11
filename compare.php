<?php
include 'compareUtils.php';
if (checkGETAndRedirect()) {
    header('Location: ./compare.php');
    exit(0);
}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="homeChart.js"></script>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <title>Obesity visualizer</title>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <a href="#">
            <img src="about/logo.png" width="200">
        </a>
    </div>
    <a href="#" class="toggle-button">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </a>
    <div class="navbar-links">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="compare.php">Compare</a></li>
            <li><a href="about/about.html">About</a></li>
        </ul>
    </div>
</nav>

<div class="container">

    <label for="firstRow"><h1>First chart</h1></label>
    <form method="post" action="submitFormCompare.php">
        <div class="row" id="firstRow">
            <div class="body-column">
                <div>
                    <label for="age">Select age:</label>
                    <select name="age" id="age" class=choiceBox>
                        <option value="0-9">0-9</option>
                        <option value="10-19">10-19</option>
                        <option value="20-29">20-29</option>
                        <option value="30-39">30-39</option>
                        <option value="40-49">40-49</option>
                    </select>
                </div>
                <div>
                    <label for="sex">Select sex:</label>
                    <select name="sex" id="sex" class="choiceBox">
                        <option value="M">M</option>
                        <option value="F">F</option>
                    </select>
                </div>
                <div>
                    <label for="country">Select country</label>
                    <select name="country" id="country" class="choiceBox">
                        <option value="ro">Romania</option>
                        <option value="usa">USA</option>
                        <option value="de">Germany</option>
                    </select>
                </div>
            </div>

            <div class="body-column">
                <canvas id="firstChart"></canvas>
            </div>
        </div>

        <label for="secondRow"><h1>Second chart</h1></label>
        <div class="row" id="secondRow">
            <div class="body-column">
                <div>
                    <label for="age2">Select age:</label>
                    <select name="age2" id="age2" class=choiceBox>
                        <option value="0-9">0-9</option>
                        <option value="10-19">10-19</option>
                        <option value="20-29">20-29</option>
                        <option value="30-39">30-39</option>
                        <option value="40-49">40-49</option>
                    </select>
                </div>
                <div>
                    <label for="sex2">Select sex:</label>
                    <select name="sex2" id="sex2" class="choiceBox">
                        <option value="M">M</option>
                        <option value="F">F</option>
                    </select>
                </div>
                <div>
                    <label for="country2">Select country</label>
                    <select name="country2" id="country2" class="choiceBox">
                        <option value="ro">Romania</option>
                        <option value="usa">USA</option>
                        <option value="de">Germany</option>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Filter" class="choiceBox">
                </div>
            </div>

            <div class="body-column">
                <canvas id="secondChart"></canvas>
            </div>
        </div>
    </form>
    <script>
        generateChart("firstChart");
        generateChart("secondChart")
    </script>
</div>

<div>
    <label for="shareLink" class="linkShare">Share with others</label>
    <textarea disabled="disabled" id="shareLink"><?php
        $link = getShareLink();
        $prefix = 'http://localhost:63342/TW_Project/compare.php?';
        echo $prefix . $link; ?></textarea>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-column">
                <h4>Navigate</h4>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="compare.php">Compare</a></li>
                    <li><a href="about/about.html">About</a></li>
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
<script src="scriptCompare.js"></script>
</body>
</html>