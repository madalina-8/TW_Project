<?php

$mysqli = new mysqli("localhost","root","","project") or die(mysqli_error($mysqli));

if(isset($_GET['enable'])) {
    $id = $_GET['enable'];
    $mysqli->query("UPDATE modify_status1 SET Status = 1 WHERE id='$id'") or die($mysqli->error());
} //the variable we pass through url

if(isset($_GET['disable'])) {
    $id = $_GET['disable'];
    $mysqli->query("UPDATE modify_status1 SET Status = 0 WHERE id='$id'") or die($mysqli->error());
} 

?>

