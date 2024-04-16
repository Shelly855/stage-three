<?php
session_start();

include '../includes/dbConnection.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login/logout.php");
    exit();
}

if (!isset($_SESSION['surgery_id'])) {
    echo "Surgery ID not found in session.";
    exit();
}

$surgeryId = $_SESSION['surgery_id'];

$stmt = $db->prepare('SELECT pq.* 
                      FROM POA_questionnaire pq
                      INNER JOIN surgery s ON pq.surgery_id = s.surgery_id
                      WHERE s.patient_id = :patient_id');
$stmt->bindValue(':patient_id', $_SESSION['patient_id'], SQLITE3_INTEGER);
$result = $stmt->execute();

if ($result) {
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if (!$row) {
        echo "No data found for the patient.";
        exit();
    }
} else {
    echo "Error executing the query.";
    exit();
}
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
                    <a href="../questionnaire/questionnaireInput.php?section=basic&surgery_id=<?php echo $surgeryId; ?>">Basic Details</a><br>
                    <a href="../questionnaire/questionnaireInput.php?section=medical&surgery_id=<?php echo $surgeryId; ?>">Medical History</a><br>
                    <a href="../questionnaire/questionnaireInput.php?section=additional&surgery_id=<?php echo $surgeryId; ?>">Additional Details</a>
                </div>
            </div>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
