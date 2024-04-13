<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login/logout.php");
    exit();
}

$stmt = $db->prepare('SELECT * FROM POA_questionnaire WHERE surgery_id = :patient_id');
$stmt->bindValue(':patient_id', $_SESSION['patient_id'], SQLITE3_INTEGER);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Pre-operative Assessment</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main> 
            <h1>Pre-operative Assessment</h1>
            <div class="dashboardBoxes">
                <div class="pageLinks">
                    <p class="headings">Pre-operative Assessment</p>
                    <a href="../questionnaire/basicDetails.php">Basic Details</a><br>
                    <a href="../questionnaire/medicalHistory.php">Medical History</a><br>
                    <a href="../questionnaire/additionalDetails.php">Additional Details</a> 
                </div>
            </div>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
