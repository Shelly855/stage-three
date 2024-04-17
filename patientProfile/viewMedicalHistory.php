<?php
session_start();
include '../includes/dbConnection.php';

if (!$db) {
    die("Failed to connect to the database.");
}

$patient = $_SESSION['patient_id'];
$query = "SELECT * FROM patients WHERE patient_id='$patient'";
$res = $db->query($query);

if ($res) {
    $row = $res->fetchArray(SQLITE3_ASSOC);

    if ($row !== false) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>My Medical History</title>
</head>
<body>
    <div class="container"> 
        <?php 
            include("../includes/patientHeader.php"); 
        ?>  
        <main> 
            <h1>Medical History</h1>
            <table class="detailsTable">
                <tr> 
                    <td>Patient ID</td>
                    <td><?php echo $row['patient_id']; ?></td>
                </tr>
                <tr> 
                    <td>Medical Conditions</td>
                    <td><?php echo $row['medical_conditions']; ?></td>
                </tr>            
                <tr> 
                    <td>Previous Medical Conditions</td>
                    <td><?php echo $row['previous_medical_conditions']; ?></td>
                </tr>
                <tr> 
            </table>  
            <?php
            } 
           else {
                echo "You have no medical history recorded.";
           }
           } 
           else {
                echo "Error.";
           }
           ?>
        </main>
        <?php 
            include("../includes/footer.php"); 
        ?>
    </div>
</body>
</html>

