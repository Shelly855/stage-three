<?php
session_start();
include '../includes/dbConnection.php';

$patientId = $_SESSION['patient_id'];
$surgeryId = $_SESSION['surgery_id'];

function checkFieldsBlank($db, $surgeryId) {
    $stmt = $db->prepare('SELECT * FROM POA_questionnaire WHERE surgery_id = :surgery_id');
    $stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if (!$result) {
        die("Error executing query: " . $db->lastErrorMsg());
    }

    $poaData = $result->fetchArray(SQLITE3_ASSOC);

    if (
        $poaData['date_of_poa'] !== null && $poaData['date_of_poa'] !== '' &&
        $poaData['surname'] !== null && $poaData['surname'] !== '' &&
        $poaData['first_name'] !== null && $poaData['first_name'] !== '' &&
        $poaData['address'] !== null && $poaData['address'] !== '' &&
        $poaData['date_of_birth'] !== null && $poaData['date_of_birth'] !== '' &&
        $poaData['sex'] !== null && $poaData['sex'] !== '' &&
        $poaData['age'] !== null && $poaData['age'] !== '' &&
        $poaData['telephone_number'] !== null && $poaData['telephone_number'] !== '' &&
        $poaData['occupation'] !== null && $poaData['occupation'] !== '' &&
        $poaData['religion'] !== null && $poaData['religion'] !== '' &&
        $poaData['emergency_contact_number'] !== null && $poaData['emergency_contact_number'] !== '' &&
        $poaData['heart_disease'] !== null && $poaData['heart_disease'] !== '' &&
        $poaData['MI'] !== null && $poaData['MI'] !== '' &&
        $poaData['hypertension'] !== null && $poaData['hypertension'] !== '' &&
        $poaData['angina'] !== null && $poaData['angina'] !== '' &&
        $poaData['DVT/PE'] !== null && $poaData['DVT/PE'] !== '' &&
        $poaData['stroke'] !== null && $poaData['stroke'] !== '' &&
        $poaData['diabetes'] !== null && $poaData['diabetes'] !== '' &&
        $poaData['epilepsy'] !== null && $poaData['epilepsy'] !== '' &&
        $poaData['jaundice'] !== null && $poaData['jaundice'] !== '' &&
        $poaData['sickle_cell_status'] !== null && $poaData['sickle_cell_status'] !== '' &&
        $poaData['kidney_disease'] !== null && $poaData['kidney_disease'] !== '' &&
        $poaData['arthritis'] !== null && $poaData['arthritis'] !== '' &&
        $poaData['asthma'] !== null && $poaData['asthma'] !== '' &&
        $poaData['pregnant'] !== null && $poaData['pregnant'] !== '' &&
        $poaData['other_health_conditions'] !== null && $poaData['other_health_conditions'] !== '' &&
        $poaData['previous_medication'] !== null && $poaData['previous_medication'] !== ''
    ) {
        return false;
    } else {
        return true;
    }
}

if (isset($_POST['submit'])) {
    if (!checkFieldsBlank($db, $surgeryId)) {
        $query = "UPDATE POA_questionnaire SET completed = 1, percentage_completed = 100 WHERE surgery_id = :surgery_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
        $stmt->execute();

        header("Location: ../questionnaire/submitQuestionnaireSuccess.php");
        exit();
    } else {
        header("Location: ../questionnaire/reviewAnswers.php?error=1");
        exit();
    }
}

$query = "SELECT * FROM POA_questionnaire WHERE surgery_id = :surgery_id";
$stmt = $db->prepare($query);
$stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
$result = $stmt->execute();

$row = $result->fetchArray();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Review Answers</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main>
            <h1>Review Your Answers</h1>
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <p class="blank-error">Please fill out all required fields.</p>
            <?php endif; ?>
            <div class="review-your-answers">
                <h2>Basic Details</h2>
                <p>Questionnaire Completion Date: <?php echo $row['date_of_poa']; ?></p>
                <p>Surname: <?php echo $row['surname']; ?></p>
                <p>First Name: <?php echo $row['first_name']; ?></p>
                <p>Address: <?php echo $row['address']; ?></p>
                <p>Date of Birth: <?php echo $row['date_of_birth']; ?></p>
                <p>Sex: <?php echo $row['sex']; ?></p>
                <p>Age: <?php echo $row['age']; ?></p>
                <p>Telephone Number: <?php echo $row['telephone_number']; ?></p>
                <p>Occupation: <?php echo $row['occupation']; ?></p>
                <p>Religion: <?php echo $row['religion']; ?></p>
                <p>Emergency Contact Number: <?php echo $row['emergency_contact_number']; ?></p>
            </div>
            <div class="review-your-answers">
                <h2>Medical History</h2>
                <h3>Do you currently have or have you ever been diagnosed with:</h3>
                <p>Heart Disease incl pacemaker: <?php echo $row['heart_disease'] ? 'Yes' : 'No'; ?></p>
                <p>MI(heart attack): <?php echo $row['MI'] ? 'Yes' : 'No'; ?></p>
                <p>Hypertension(high blood pressure): <?php echo $row['hypertension'] ? 'Yes' : 'No'; ?></p>
                <p>Angina(chest pain): <?php echo $row['angina'] ? 'Yes' : 'No'; ?></p>
                <p>DVT/PE(blood clots): <?php echo $row['DVT/PE'] ? 'Yes' : 'No'; ?></p>
                <p>Stroke(CVA/TIA): <?php echo $row['stroke'] ? 'Yes' : 'No'; ?></p>
                <p>Diabetes Type 1 / 2: <?php echo $row['diabetes'] ? 'Yes' : 'No'; ?></p>
                <p>Epilepsy: <?php echo $row['epilepsy'] ? 'Yes' : 'No'; ?></p>
                <p>Jaundice: <?php echo $row['jaundice'] ? 'Yes' : 'No'; ?></p>
                <p>Sickle Cell Disease: <?php echo $row['sickle_cell_status'] ? 'Yes' : 'No'; ?></p>
                <p>Kidney Disease: <?php echo $row['kidney_disease'] ? 'Yes' : 'No'; ?></p>
                <p>Arthritis: <?php echo $row['arthritis'] ? 'Yes' : 'No'; ?></p>
                <p>Asthma: <?php echo $row['asthma'] ? 'Yes' : 'No'; ?></p>
            </div>
            <div class="review-your-answers">
                <h2>Additional Details</h2>
                <p>Are you currently or is there a possibility you are pregnant?: <?php echo $row['pregnant'] ? 'Yes' : 'No'; ?></p>
                <p>Other Health Conditions: <?php echo $row['other_health_conditions']; ?></p>
                <p>Previous Medication: <?php echo $row['previous_medication']; ?></p>
            </div>
            <form action="../questionnaire/reviewAnswers.php" method="post">
                <input type="submit" name="submit" value="Submit Answers">
            </form>
            <form id="questionnaire-back-button">
            <a href="../questionnaire/questionnaire.php">Back to Questionnaire</a> 
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
