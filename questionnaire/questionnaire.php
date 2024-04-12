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

$totalFields = 27;
$overallFilledFields = 0;
if ($row) {
    foreach ($row as $key => $value) {
        if ($value !== null && $key !== 'surgery_id' && $key !== 'percentage_completed' && $key !== 'assigned' && $key !== 'completed' && $key !== 'poa_form_id') {
            $overallFilledFields++;
        }
    }
}
$overallPercentage = ($overallFilledFields / $totalFields) * 100;

$basicDetailsFields = 11;
$medicalHistoryFields = 13;
$additionalDetailsFields = 3;

$basicDetailsFilledFields = count(array_filter($_SESSION['form_values'] ?? [], function($key) {
    return in_array($key, ['poadate', 'surname', 'fname', 'address', 'dob', 'sex', 'age', 'phone', 'occupation', 'religion', 'emergency']);
}, ARRAY_FILTER_USE_KEY));
$medicalHistoryFilledMandatoryFields = count(array_filter($_SESSION['form_values'] ?? [], function($key) {
    return in_array($key, ['heart', 'aMI', 'hypertension', 'angina', 'dvt', 'stroke', 'diabetes', 'epilepsy', 'jaundice', 'sickle', 'kidney', 'arthritis', 'asthma']);
}, ARRAY_FILTER_USE_KEY));
$additionalDetailsFilledFields = count(array_filter($_SESSION['form_values'] ?? [], function($key) {
    return in_array($key, ['pregnant', 'medication']);
}, ARRAY_FILTER_USE_KEY));

$medicalHistoryFilledFields = $medicalHistoryFilledMandatoryFields;

$basicDetailsPercentage = ($basicDetailsFilledFields / $basicDetailsFields) * 100;
$medicalHistoryPercentage = ($medicalHistoryFilledFields / $medicalHistoryFields) * 100;
$additionalDetailsPercentage = ($additionalDetailsFilledFields / $additionalDetailsFields) * 100;
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
                    <a href="../questionnaire/basicDetails.php">
                        Basic Details 
                        <?php echo round($basicDetailsPercentage, 2); ?>%
                    </a><br>
                    <a href="../questionnaire/medicalHistory.php">
                        Medical History 
                        <?php echo round($medicalHistoryPercentage, 2); ?>%
                    </a><br>
                    <a href="../questionnaire/additionalDetails.php">
                        Additional Details 
                        <?php echo round($additionalDetailsPercentage, 2); ?>%
                    </a> 
                </div>
            </div>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
