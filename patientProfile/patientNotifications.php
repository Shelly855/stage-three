<?php
session_start();
include '../includes/dbConnection.php';

if (!$db) {
    die("Failed to connect to the database.");
}

$patientId = $_SESSION['patient_id'];
$query = "SELECT COUNT(*) AS count FROM surgery WHERE patient_id = $patientId";
$res = $db->query($query);
$row = $res->fetchArray(SQLITE3_ASSOC);

if ($row['count'] > 0) {
    $surgeryMessage = '<section class="outcomeNotifications">
                            <h2>Your Questionnaire Outcome</h2>
                            <p class="assigned">Surgery Assigned: Yes </p>
                            <p> The doctor has assigned a surgery for you. Click <a href="surgeryDetails.php">here</a> to view your surgery details. </p>
                        </section>';
} 
else {
    $surgeryMessage = '<section class="outcomeNotifications">
                            <h2>Your Questionnaire Outcome</h2>
                            <p class="assigned">Surgery Assigned: No</p>
                            <p>The doctor has not assigned a surgery for you. </p>
                        </section>';
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
        ?>  
        <main> 
            <h1>Notifications</h1>
            <?php 
                echo $surgeryMessage; 
            ?>
        </main>
        <?php 
             include("../includes/footer.php"); 
        ?>    
    </div>
</body>
</html>
