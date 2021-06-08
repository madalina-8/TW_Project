<?php
    include 'homeUtils.php';
    if (checkGETAndRedirect()) {
        header('Location: ./home.php');
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
    <!--<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script> --><script src="https://kit.fontawesome.com/bad7801a4d.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js"></script>
    <script type="module" src="homeChart.js"></script>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
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
            <li><a href="home.php">Home</a></li>
            <li><a href="compare/compare.php">Compare</a></li>
            <li><a href="about/about.html">About</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="body-column">
            <form method="post" action="submitFormHome.php">
                <div>
                    <label for="year">Select year:</label>
                    <select name="year" id="year" class=choiceBox onchange="viewHandler.updateSelection(chartData.idYear, 'yearSelections')">
                        <script type="module">
                            import { viewHandler, chartData} from './homeChart.js'
                            viewHandler.addOptionsForParameter(chartData.columnYear, chartData.idYear)
                        </script>
                    </select>
                    <select id="yearSelections" class="choiceBox" onchange="viewHandler.removeCurrentChoice('yearSelections')"></select>
                </div>
                <div>
                    <label for="sex">Select sex:</label>
                    <select name="sex" id="sex" class="choiceBox" onchange="viewHandler.updateSelection(chartData.idSex, 'sexSelections')">
                        <!--https://github.com/harvesthq/chosen for better choicebox-->
                        <option value="-">-</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Both sexes">Both sexes</option>
                    </select>
                    <select id="sexSelections" class="choiceBox" onchange="viewHandler.removeCurrentChoice('sexSelections')"></select>
                </div>
                <div>
                    <label for="country">Select country</label>
                    <select name="country" id="country" class="choiceBox" onchange="viewHandler.updateSelection(chartData.idCountry, 'countrySelections')">
                        <script type="module">
                            import { viewHandler, chartData} from './homeChart.js'
                            viewHandler.addOptionsForParameter(chartData.columnCountry, chartData.idCountry)
                        </script>
                    </select>
                    <select id="countrySelections" class="choiceBox" onchange="viewHandler.removeCurrentChoice('countrySelections')"></select>
                </div>
                <div>
                    <label for="region">Select region</label>
                    <select name="region" id="region" class="choiceBox" onchange="viewHandler.updateSelection(chartData.idRegion, 'regionSelections')">
                        <script type="module">
                            import { viewHandler, chartData} from './homeChart.js'
                            viewHandler.addOptionsForParameter(chartData.columnRegion, chartData.idRegion)
                        </script>
                    </select>
                    <select id="regionSelections" class="choiceBox" onchange="viewHandler.removeCurrentChoice('regionSelections')"></select>
                </div>
                <button id="filterButton" onclick="filter()">Filter</button>
            </form>
        </div>

        <div class="body-column graph">
            <canvas id="mainChart">
                <script type="module">
                    import { viewHandler, misc } from './homeChart.js';
                    viewHandler.updateDataFromCookies()
                    viewHandler.generateChart(misc.mainChartNameId)
                </script>
            </canvas>
            <label for="imageFormat">Select format:</label>
            <select name="imageFormat" id="imageFormat" class="choiceBox" onchange="updateType(this)">
                <option value="PNG">PNG</option>
                <option value="CSV">CSV</option>
                <option value="SVG">SVG</option>
            </select>
            <button id="saveButton" onclick="chartHandler.saveChart()">Save chart image</button>
        </div>
    </div>
</div>

<div></div>

<div>
    <label for="shareLink" class="linkShare">Share with others</label>
    <textarea disabled="disabled" id="shareLink"><?php
        $link = getShareLink();
        $prefix = 'http://localhost:63342/TW_Project/home.php?';
        echo $prefix . $link; ?></textarea>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-column">
                <h4>Navigate</h4>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="compare/compare.php">Compare</a></li>
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
<script src="script.js"></script>
</body>
</html>