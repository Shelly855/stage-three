<?php
session_start();
include '../includes/dbConnection.php';

if (!$db) {
    die("Failed to connect to the database.");
}

$patientId = $_SESSION['patient_id'];

$sqlSurgery = "SELECT * FROM surgery WHERE patient_id = $patientId AND eligible = 1";
$resultSurgery = $db->query($sqlSurgery);
$surgery = $resultSurgery->fetchArray() ? true : false;

$sqlPOA = "SELECT * FROM POA_questionnaire WHERE patient_id = $patientId AND assigned = 1";
$resultPOA = $db->query($sqlPOA);
$poa = $resultPOA->fetchArray() ? true : false;

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
        <?php include("../includes/patientHeader.php"); ?>  
        <main> 
            <h1>Notifications</h1>
            <?php 
            
        if ($surgery){
           echo '<section class="outcomeNotifications">';
           echo '<h2>Your Questionnaire Outcome</h2>';
           echo '<p class="assigned">Surgery Assigned: Yes</p>';
           echo '<p>The doctor has assigned a surgery for you. Click <a href="">here</a> to view your surgery details.</p>';
           echo '</section>';
        }
        else{
            echo '<section class="outcomeNotifications">';
            echo '<h2>Your Questionnaire Outcome</h2>';
            echo '<p class="assigned">Surgery Assigned: No</p>';
            echo '<p>The doctor has not assigned a surgery for you. </p>';   
            echo '</section>';
        }
        ?>
        <?php
        if ($poa) {
            echo '<section class="poaDecision">';
            echo '<h2>Pre Operative Assessment Decision</h2>';   
            echo '<p class="assigned">POA Assigned: Yes</p>';   
            echo '<p>The doctor has assigned a Pre-Operative Assessment for you. Click <a href="">here</a>  to start the Questionnaire.</p>';   
            echo '</section>';
        }
        else{
            echo '<section class="poaDecision">';
            echo '<h2>Pre Operative Assessment Decision</h2>';   
            echo '<p class="assigned">POA Assigned: No</p>';    
            echo '<p>The doctor has not assigned a Pre-Operative Assessment for you. </p>';    
            echo '</section>';
        }
        ?>       
        </main>
        <?php include("../includes/footer.php"); ?>
    </div>
</body>
</html>
