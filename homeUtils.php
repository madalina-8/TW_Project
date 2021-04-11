<?php
//when changing 'formNames' change its value in script.js too
$formNames = array("age", "sex", "country");

function getShareLink() {
    global $formNames;
    $data = array();
    foreach ($formNames as $name) {
        if (isset($_COOKIE[$name])) {
            $value = $_COOKIE[$name];
            $data[$name] = $value;
        }
    }
    return http_build_query($data);
}

function addCookie($name, $value) {
    setcookie($name, $value);
}

function submitForm() {
    global $formNames;
    foreach ($formNames as $name) {
        if (isset($_POST[$name])) {
            $value = $_POST[$name];
            addCookie($name, $value);
        }
    }

    header("Location: ./home.php");
}

function checkGETAndRedirect() {
    global $formNames;

    $shouldExit = false;

    foreach ($formNames as $name) {
        if (isset($_GET[$name])) {
            $value = $_GET[$name];
            addCookie($name, $value);
            $shouldExit = true;
        }
    }

    return $shouldExit;
}