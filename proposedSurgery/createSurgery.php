<?php
$errorpatient = $errorsurgery = "";
$allFields = true;

if (isset($_POST['submit'])) {
    include '../includes/dbConnection.php';

    if (empty($_POST['patient_id']) || $_POST['patient_id'] == 0) {
        $errorpatient = "Please select a patient.";
        $allFields = false;
    }
    if (empty($_POST['surgery'])) {
        $errorsurgery = "Surgery Name is mandatory";
        $allFields = false;
    }

    if ($allFields) {
        $stmt = $db->prepare('SELECT patients.patient_id, users.first_name, users.surname FROM patients JOIN users ON patients.user_id = users.user_id WHERE patients.patient_id = :pid');
        $stmt->bindValue(':pid', $_POST['patient_id'], SQLITE3_INTEGER);
        $result = $stmt->execute();
        $patientDetails = $result->fetchArray(SQLITE3_ASSOC);

        if ($patientDetails) {
            $stmt = $db->prepare('INSERT INTO surgery (patient_id, surgery_name) VALUES (:pid, :surgery)');
            $stmt->bindValue(':pid', $patientDetails['patient_id'], SQLITE3_INTEGER);
            $stmt->bindValue(':surgery', $_POST['surgery'], SQLITE3_TEXT);
                
            $result = $stmt->execute();
        
            if ($result) {
                header("Location: ../proposedSurgery/createSurgerySuccess.php?createSurgery=success");
                exit();
            } else {
                echo "Error creating surgery.";
            }
        } else {
            echo "Error fetching patient details.";
        }
    }
}

include '../includes/dbConnection.php';
$stmt_patients = $db->prepare('SELECT patients.patient_id, users.first_name, users.surname FROM patients JOIN users ON patients.user_id = users.user_id');
$result_patients = $stmt_patients->execute();
    
$patients = array();
    
while ($row = $result_patients->fetchArray(SQLITE3_ASSOC)) {
    $patients[] = array(
        'patient_id' => $row['patient_id'],
        'full_name' => $row['first_name'] . ' ' . $row['surname']
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Propose Surgery</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/doctorHeader.php");
        ?>  
        <main>
            <h1>Propose Surgery</h1>
            <form method="post">
                <label for="patient_id">Select Patient:</label>
                <select name="patient_id" id="patient_id">
                    <option value="0">Select Patient</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo $patient['patient_id']; ?>">
                            <?php echo $patient['full_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="blank-error"><?php echo $errorpatient; ?></span>

                <label>Surgery Name</label>
                <input type="text" name="surgery" value="<?php echo isset($_POST['surgery']) ? $_POST['surgery'] : ''; ?>">
                <span class="blank-error"><?php echo $errorsurgery; ?></span>

                <input type="submit" value="Propose Surgery" name="submit">
                <a href="../proposedSurgery/proposedSurgery.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
