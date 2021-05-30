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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/bad7801a4d.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js"></script>
    <script src="homeChart.js"></script>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <script type="text/javascript" src="jquery.amsify.suggestags.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery.amsify.suggestags.css">
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
            <li><a href="compare.php">Compare</a></li>
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
                    <div class="form-group">
                        <input type="text" class="form-control" name="year" id="year"/>
                        <script>
                            viewHandler.updateUIValueFromCookie(chartData.idYear)
                            $('input[name="year"]').amsifySuggestags({
                                type : 'bootstrap',
                                //suggestions: getSuggestionsForColumn(columnCountry),
                                suggestions: ["1970", "2015", "2016"],
                                whiteList: true
                            });
                        </script>
                    </div>
                </div>
                <div>
                    <label for="sex">Select sex:</label>
                    <div class="form-group">
                        <input type="text" class="form-control"  name="sex" id="sex"/>
                        <script>
                            viewHandler.updateUIValueFromCookie(chartData.idSex)
                            $('input[name="sex"]').amsifySuggestags({
                                type : 'bootstrap',
                                //suggestions: getSuggestionsForColumn(columnCountry),
                                suggestions: ["Male", "Female", "Both sexes"],
                                whiteList: true
                            });
                        </script>
                    </div>
                </div>
                <div>
                    <label for="country">Select country</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="country" id="country"/>
                        <script>
                            viewHandler.updateUIValueFromCookie(chartData.idCountry)
                            $('input[name="country"]').amsifySuggestags({
                                type : 'bootstrap',
                                //suggestions: chartHandler.getSuggestionsForColumn(chartData.columnCountry),
                                suggestions: ["Romania", "Bulgaria", "China", "Germany", "Afghanistan"],
                                whiteList: true
                            })
                        </script>
                    </div>
                </div>
                <div>
                    <label for="region">Select region</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="region" id="region"/>
                        <script>
                            viewHandler.updateUIValueFromCookie(chartData.idRegion)
                            $('input[name="region"]').amsifySuggestags({
                                type : 'bootstrap',
                                //suggestions: getSuggestionsForColumn(columnCountry),
                                suggestions: ["Europe", "Africa", "Americas"],
                                whiteList: true
                            });
                        </script>
                    </div>
                </div>
                <button id="filterButton" onclick="filter()">Filter</button>
            </form>
        </div>

        <div class="body-column graph">
            <canvas id="mainChart">
                <script>
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
<script src="script.js"></script>
</body>
</html>