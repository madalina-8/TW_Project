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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/bad7801a4d.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js"></script>
    <script src="./compareChart.js"></script>
    <script type="module" src="cookieUtils.js"></script>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <script type="text/javascript" src="../jquery.amsify.suggestags.js"></script>
    <link rel="stylesheet" type="text/css" href="../jquery.amsify.suggestags.css">
    <title>Obesity visualizer</title>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <a href="#">
            <img src="../about/logo.png" width="200">
        </a>
    </div>
    <a href="#" class="toggle-button">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </a>
    <div class="navbar-links">
        <ul>
            <li><a href="../home.php">Home</a></li>
            <li><a href="compare.php">Compare</a></li>
            <li><a href="../about/about.php">About</a></li>
        </ul>
    </div>
</nav>


<div class="container">
    <div class="row">
        <div class="body-column">
            <form method="post" action="submitFormCompare.php">
                <div>
                    <label for="year" id="abc">Select year:</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="year" id="year"/>
                        <label for="yearCompare">Should compare:</label>
                        <input type="checkbox" class="form-control" name="yearCompare" id="regionCompare">
                    </div>
                </div>
                <div>
                    <label for="sex">Select sex:</label>
                    <div class="form-group">
                        <input type="text" class="form-control"  name="sex" id="sex"/>
                        <label for="sexCompare">Should compare:</label>
                        <input type="checkbox" class="form-control" name="sexCompare" id="regionCompare">
                    </div>
                </div>
                <div>
                    <label for="country">Select country</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="country" id="country"/>
                        <label for="countryCompare">Should compare:</label>
                        <input type="checkbox" class="form-control" name="countryCompare" id="regionCompare">
                    </div>
                </div>
                <div>
                    <label for="region">Select region</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="region" id="region"/>
                        <label for="regionCompare">Should compare:</label>
                        <input type="checkbox" class="form-control" name="regionCompare" id="regionCompare">
                    </div>
                </div>
                <button id="filterButton" onclick="filter()">Filter</button>
            </form>
        </div>

        <div class="body-column table">
            <?php
                importFiltersFromCookies();
                generateCompareTable();
            ?>
        </div>
    </div>
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
                    <li><a href="../home.php">Home</a></li>
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
<script type="module" src="scriptCompare.js"></script>
<script type="module">
    import updateUIValueFromCookie from './cookieUtils.js';
    updateUIValueFromCookie("year");
    updateUIValueFromCookie("sex");
    updateUIValueFromCookie("region");
    updateUIValueFromCookie("country");
</script>
</body>
</html>