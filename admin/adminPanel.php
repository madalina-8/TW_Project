<?php
    session_start();
    if(!isset($_SESSION['AdminLoginId'])) {
        header("location: admin.php");
    }

?>

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


</body>
</html>