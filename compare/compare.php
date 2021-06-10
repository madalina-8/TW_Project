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

<div class="container">
    <div class="row">
        <div class="body-column">
            <form method="post" action="submitFormCompare.php">
                <div>
                    <label for="year1" id="abc">Select year:</label>
                    <div class="form-group">
                        <select id="year1" class=choiceBox onchange="updateSelection('year1', 'year')">
                            <script type="module">
                                import { viewHandler, chartData } from './compareChart.js'
                                viewHandler.addOptionsForParameter(chartData.columnYear, 'year1')
                            </script>
                        </select>
                        <input type="text" id="year" name="year" class="form-control" disabled="disabled">
                        <label for="yearCompare">Should compare:</label>
                        <input type="checkbox" class="form-control" name="yearCompare" id="yearCompare">
                    </div>
                </div>
                <div>
                    <label for="sex1">Select sex:</label>
                    <div class="form-group">
                        <select id="sex1" class="choiceBox" onchange="updateSelection('sex1', 'sex')">
                            <!--https://github.com/harvesthq/chosen for better choicebox-->
                            <option value="-">-</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Both sexes">Both sexes</option>
                        </select>
                        <input type="text" id="sex" name="sex" class="form-control" disabled="disabled">
                        <label for="sexCompare">Should compare:</label>
                        <input type="checkbox" class="form-control" name="sexCompare" id="sexCompare">
                    </div>
                </div>
                <div>
                    <label for="country1">Select country</label>
                    <div class="form-group">
                        <select id="country1" class="choiceBox" onchange="updateSelection('country1', 'country')">
                            <script type="module">
                                import { viewHandler, chartData} from './compareChart.js'
                                viewHandler.addOptionsForParameter(chartData.columnCountry, 'country1')
                            </script>
                        </select>
                        <input type="text" id="country" name="country" class="form-control" disabled="disabled">
                        <label for="countryCompare">Should compare:</label>
                        <input type="checkbox" class="form-control" name="countryCompare" id="countryCompare">
                    </div>
                </div>
                <div>
                    <label for="region1">Select region</label>
                    <div class="form-group">
                        <select id="region1" class="choiceBox" onchange="updateSelection('region1', 'region')">
                            <script type="module">
                                import { viewHandler, chartData} from './compareChart.js'
                                viewHandler.addOptionsForParameter(chartData.columnRegion, 'region1')
                            </script>
                        </select>
                        <input type="text" id="region" name="region" class="form-control" disabled="disabled">
                        <label for="regionCompare">Should compare:</label>
                        <input type="checkbox" class="form-control" name="regionCompare" id="regionCompare">
                    </div>
                </div>
                <div>
                    <label for="grouped">Group data: </label>
                    <input id="grouped" type="checkbox" name="grouped"/>
                </div>
                <input id="filterButton" type="submit" value="Filter" />
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
        $prefix = "http://localhost:63342/TW_Project/compare/compare.php?";
        echo $prefix . $link; ?></textarea>
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
    updateUIValueFromCookie("year");
    updateUIValueFromCookie("sex");
    updateUIValueFromCookie("region");
    updateUIValueFromCookie("country");
    updateUICheckBoxFromCookie("grouped");
</script>
</body>
</html>
