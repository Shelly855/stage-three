<?php
session_start();
include '../includes/dbConnection.php';

if (!$db) {
    die("Failed to connect to the database.");
}

$patient = $_SESSION['patient_id'];
$query = "SELECT * FROM appointments WHERE patient_id='$patient'";
$res = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Upcoming Appointments</title>
</head>
<body>
    <div class="container"> 
            <?php include("../includes/patientHeader.php"); ?>  
            <main> 
                <?php
                if ($res) {
                    $row = $res->fetchArray(SQLITE3_ASSOC);
    
                    if ($row !== false) {
                ?>
                <h1>Appointments</h1>
                <table class="detailsTable">
                    <tr> 
                        <td>Patient ID</td>
                        <td><?php echo $row['patient_id']; ?></td>
                    </tr>
                    <tr> 
                        <td>Appointment ID</td>
                        <td><?php echo $row['appointment_id']; ?></td>
                    </tr>
                    <tr> 
                        <td>Appointment Date</td>
                        <td><?php echo $row['date']; ?></td>
                    </tr>            
                    <tr> 
                        <td>Appointment Time</td>
                        <td><?php echo $row['time']; ?></td>
                    </tr>
                </table>  
                <?php
                    } else {
                        echo "<h1>No Upcoming Appointments</h1>";
                    }
                } else {
                    echo "<h1>Error executing query.</h1>";
                }
                ?>
            </main>
        <?php include("../includes/footer.php"); ?>    
    </div>
</body>
</html>
