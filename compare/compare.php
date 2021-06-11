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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js"></script>
    <script src="../view/UpdateHandler.js"></script>
    <script type="module" src="compareChart.js"></script>
    <script type="module" src="../cookies/cookieUtils.js"></script>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <title>Obesity visualizer</title>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <a href="#">
            <img src="../about/logo.png" width="200" alt="Logo">
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
             <li><a href="compare.php">Compare</a></li>
             <li><a href="../about/about.php">About</a></li>
             <li><a href="../admin/admin.php">Admin</a></li>
        </ul>
    </div>
</nav>

<?php include '../admin/process.php';

$mysqli = new mysqli("localhost","root","","project") or die(mysqli_error($mysqli));
$result = $mysqli->query("SELECT * FROM modify_status1") or die($mysqli->error);


$status_year = $mysqli->query("SELECT Status FROM modify_status1 WHERE Field='Year'") or die($mysqli->error);
$status_sex = $mysqli->query("SELECT Status FROM modify_status1 WHERE Field='Sex'") or die($mysqli->error);
$status_country = $mysqli->query("SELECT Status FROM modify_status1 WHERE Field='Country'") or die($mysqli->error);
$status_region = $mysqli->query("SELECT Status FROM modify_status1 WHERE Field='Region'") or die($mysqli->error);

$st_year = $status_year->fetch_assoc();
$st_sex = $status_sex->fetch_assoc();
$st_country = $status_country->fetch_assoc();
$st_region = $status_region->fetch_assoc();

?>

<div class="container">
    <div class="row">
        <div class="body-column">
            <form method="post" action="submitFormCompare.php">
                <div class="filterContainer">
                    <label for="year1" class="filterTitle">Select year:</label>
                    <?php if($st_year['Status'] == 0): ?>
                        <select class=choiceBox disabled></select>
                    <?php else: ?>
                        <br/>
                        <select id="year1" class="choiceBox" onchange="updateSelection('year1', 'year')">
                            <script type="module">
                                import { viewHandler, chartData } from './compareChart.js'
                                viewHandler.addOptionsForParameter(chartData.columnYear, 'year1')
                            </script>
                        </select>
                        <br/>
                        <input type="text" id="year" name="year" class="textInput">
                        <br/>
                        <label for="yearCompare">Should compare year:</label>
                        <input type="checkbox" name="yearCompare" id="yearCompare">
                    <?php endif; ?>
                </div>
                <div class="filterContainer">
                    <label for="sex1" class="filterTitle">Select sex:</label>
                    <?php if($st_sex['Status'] == 0): ?>
                        <select disabled></select>
                    <?php else: ?>
                        <br/>
                        <div class="form-group">
                            <select id="sex1" class="choiceBox" onchange="updateSelection('sex1', 'sex')">
                                <!--https://github.com/harvesthq/chosen for better choicebox-->
                                <option value="-">-</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Both sexes">Both sexes</option>
                            </select>
                            <input type="text" id="sex" name="sex" class="textInput" >
                            <br/>
                            <label for="sexCompare">Should compare sex:</label>
                            <input type="checkbox" name="sexCompare" id="sexCompare">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="filterContainer">
                    <label for="country1" class="filterTitle">Select country</label>
                    <?php if($st_country['Status'] == 0): ?>
                        <select disabled></select>
                    <?php else: ?>
                        <br/>
                        <div class="form-group">
                            <select id="country1" class="choiceBox" onchange="updateSelection('country1', 'country')">
                                <script type="module">
                                    import { viewHandler, chartData} from './compareChart.js'
                                    viewHandler.addOptionsForParameter(chartData.columnCountry, 'country1')
                                </script>
                            </select>
                            <input type="text" id="country" name="country" class="textInput">
                            <br/>
                            <label for="countryCompare">Should compare country:</label>
                            <input type="checkbox" name="countryCompare" id="countryCompare">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="filterContainer">
                    <label for="region1" class="filterTitle">Select region</label>
                    <?php if($st_region['Status'] == 0): ?>
                        <select disabled></select>
                    <?php else: ?>
                    <br/>
                    <div class="form-group">
                        <select id="region1" class="choiceBox" onchange="updateSelection('region1', 'region')">
                            <script type="module">
                                import { viewHandler, chartData} from './compareChart.js'
                                viewHandler.addOptionsForParameter(chartData.columnRegion, 'region1')
                            </script>
                        </select>
                        <input type="text" id="region" name="region" class="textInput">
                        <br/>
                        <label for="regionCompare">Should compare region:</label>
                        <input type="checkbox" name="regionCompare" id="regionCompare">
                    </div>
                    <?php endif; ?>
                </div>
                <div class="filterContainer">
                    <label for="grouped" class="filterTitle">Group data: </label>
                    <input id="grouped" type="checkbox" name="grouped"/>
                    <br/>
                    <p>Should graph data be averaged?</p>
                </div>
                <div class="filterContainer">
                    <input id="filterButton" style="font-size: 30px;" type="submit" value="Filter" />
                </div>
            </form>
        </div>

        <div class="compareTable">
            <?php
                importFiltersFromCookies();
                generateCompareTable();
            ?>
        </div>
    </div>

    <div class="row">
        <label for="shareLink" class="linkShare">Share with others</label>
        <textarea disabled="disabled" id="shareLink"><?php
            $link = getShareLink();
            $prefix = "http://localhost:63342/TW_Project/compare/compare.php?";
            echo $prefix . $link; ?></textarea>
    </div>
</div>



<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-column">
                <h4>Navigate</h4>
                <ul>
                    <li><a href="../home/home.php">Home</a></li>
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

<script>
    const toggleButton = document.getElementsByClassName('toggle-button')[0]
    const navbarLinks = document.getElementsByClassName('navbar-links')[0]

    toggleButton.addEventListener('click', () => {
        navbarLinks.classList.toggle('active')
    })
</script>

<script type="module">
    import {updateUIValueFromCookie, updateUICheckBoxFromCookie} from '../cookies/cookieUtils.js';
    <?php if($st_year['Status'] == 1): ?>
        updateUIValueFromCookie("year");
    <?php endif; ?>
    <?php if($st_sex['Status'] == 1): ?>
        updateUIValueFromCookie("sex");
    <?php endif; ?>
    <?php if($st_region['Status'] == 1): ?>
        updateUIValueFromCookie("region");
    <?php endif; ?>
    <?php if($st_country['Status'] == 1): ?>
        updateUIValueFromCookie("country");
    <?php endif; ?>
    updateUICheckBoxFromCookie("grouped");
</script>
</body>
</html>
