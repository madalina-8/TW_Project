<?php
    session_start();
    if(!isset($_SESSION['AdminLoginId'])) {
        header("location: admin.php");
    }

?>

<?php require_once 'process.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="adminPanel.css">
</head>
<body>

    <div class="header">
        <h1> WELCOME TO ADMIN PANEL - <?php echo $_SESSION['AdminLoginId']?> </h1>
        <form method="POST">
             <button name="Logout"> LOG OUT </button>
        </form>     
    </div>   

<?php 
    if(isset($_POST['Logout'])) {
        session_destroy();
        header("location: admin.php");
    }

?>     


    <?php

    $mysqli = new mysqli("localhost","root","","project") or die(mysqli_error($mysqli));
    $result = $mysqli->query("SELECT * FROM modify_status1") or die($mysqli->error);
    //create a while so I can iterate through database and display every record
    //pre_r($result->fetch_assoc()); //this function shows only the first record
    
    function pre_r( $array ) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    
    ?>


    <div class="row">
         <table class="fields">
             <thead>
                 <tr> 
                     <th> Field </th>
                     <th> Status </th>
                     <th> Action </th>
                 </tr>
            </thead>

            <?php

             while($row = $result->fetch_assoc()): ?>
             <tr> 
                 <td> <?php echo $row['Field']; ?> </td>
                 <td> <?php echo $row['Status']; ?> </td>
                 <td> 
                     <div class = "btn-group">
                         <a href="adminPanel.php?enable=<?php echo $row['id'];?>">Enable</a>  
                         <a href="adminPanel.php?disable=<?php echo $row['id'];?>">Disable</a>  
                    </div>
                 </td>
             </tr>

            <?php endwhile; ?>

         </table>
    </div>

</body>
</html>
