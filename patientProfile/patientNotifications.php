<?php
session_start();
include '../includes/dbConnection.php';
if (!$db) {
    die("Failed to connect to the database.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Notifications</title>
</head>
<body>
    <div class="container"> 
        <?php 
            include("../includes/patientHeader.php"); 
            include '../patientProfile/surgeryNotifications.php';
            include '../patientProfile/poaNotifications.php';
        ?>  
        <main> 
            <h1>Notifications</h1>
            <?php echo $surgeryNotification; ?>
            <?php echo $poaNotification; ?>
        </main>
        <?php 
             include("../includes/footer.php"); 
        ?>    
    </div>
</body>
</html>
