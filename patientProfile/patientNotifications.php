<?php
session_start();
include '../includes/dbConnection.php';

if (!$db) {
    die("Failed to connect to the database.");
}

$patient = $_SESSION['patient_id'];
$query = "SELECT COUNT(*) AS count FROM POA_questionnaire WHERE surname='$patient'";
$res = $db->query($query);
$row = $res->fetchArray(SQLITE3_ASSOC);

if ($row['count'] > 0) {
    $poaMessage = '<section class="poaDecision">
                        <h2>Pre Operative Assessment Decision</h2>
                        <p class="assigned">POA Assigned: Yes</p>  
                        <p>The doctor has assigned a Pre-Operative Assessment for you. Click <a href="">here</a>  to start the Questionnaire.</p>
                    </section>';
} else {
    $poaMessage = '<section class="poaDecision">
                        <h2>Pre Operative Assessment Decision</h2>
                        <p class="assigned">POA Assigned: No</p>
                        <p>The doctor has not assigned a Pre-Operative Assessment for you. </p>
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
    <title>Pre Operative Assessment</title>
</head>
<body>
    <div class="container"> 
        <?php include("../includes/patientHeader.php"); ?>  
        <main> 
            <?php echo $poaMessage; ?>
        </main>
        <?php include("../includes/footer.php"); ?>    
    </div>
</body>
</html>
