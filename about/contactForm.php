<?php

if(isset($_POST['send'])) {
    $fullName = $_POST['name'];
    $subject = $_POST['subject'];
    $mailFrom = $_POST['email'];
    $message = $_POST['message'];

    if(empty($fullName) || empty($subject) || empty($mailFrom) || empty($message)) {
        header("Location: about.php?error");
    } else {
        $mailTo = "obesityproj@gmail.com";
        $headers = "From: ".$mailFrom;
        $txt = "You have received a e-mail from: ".$fulltName.".\n\n".$message;
    
    
        mail($mailTo, $subject, $txt, $headers);
        header("Location: about.php?succes");
    }
} else {
    header("Location: about.php");
}


?>
