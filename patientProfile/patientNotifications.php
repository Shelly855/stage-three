<?php
session_start();
$db = new SQLite3('C:\xampp\data\stage_3.db');

if (!$db) {
    die("Failed to connect to the database.");
}
//check appointment
$patient = $_SESSION['patient_id'];
$query = "SELECT * FROM appointments WHERE patient_id='$patient' AND date >= date('now') ORDER BY date LIMIT 1";
$res = $db->query($query);
$appointment = $res->fetchArray(SQLITE3_ASSOC);

//check poa assigned
$queryPOA = "SELECT * FROM poa_questionnaire WHERE patient_id='$patient' AND assigned=1";
$resPOA = $db->query($queryPOA);
$assignedPoa = $resPOA->fetchArray(SQLITE3_ASSOC);
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
            if ($appointment) {
                echo '<div class="notification">';
                echo '<h2>Upcoming Appointment</h2>';
                echo '<p> You have an appointment on ' . $appointment['date'] . 'at' . $appointment['time'] . '</p>';
                echo '</div>';
            } 
            else {
                echo '<h2>You have no upcoming appointments.</h2>';
            }
            ?>
            <?php 
            if ($assignedPoa){
                echo '<div class="notification">';
                echo '<h2>POA Assessment </h2>';
                echo '<p>The Doctor has assigned a pre-opeative assessment to you.</p>';
                echo '</div>';
            }
            else {
                echo '<h2> You have not been assigned the pre-operative assessment</h2>';
            }
           ?>
        </main>
        <?php include("../includes/footer.php"); ?>
    </div>
</body>
</html>

<?php
$db->close();
?>