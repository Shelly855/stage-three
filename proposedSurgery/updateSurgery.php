<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');
$errorpatient = $errorsurgery = "";
$allFields = true;

if (isset($_GET['sid'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');
    $surgery_id = $_GET['sid'];
    $stmt = $db->prepare("SELECT * FROM surgery WHERE surgery_id = :sid");
    $stmt->bindValue(':sid', $surgery_id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $surgery = $result->fetchArray(SQLITE3_ASSOC);
}

$query = $db->query("SELECT * FROM patients");
$patients = [];
while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
    $patients[] = $row;
}

if (isset($_POST['submit'])) {

    if (empty($_POST['patient_id']) || $_POST['patient_id'] == 0) {
        $errorpatient = "Please select a patient.";
        $allFields = false;
    }
    if (empty($_POST['surgery'])) {
        $errorsurgery = "Surgery Name is mandatory";
        $allFields = false;
    }

    $eligibility_value = ($_POST['eligible'] == 'yes') ? 1 : 0;

    if ($allFields) {

        $stmt = $db->prepare('SELECT patients.patient_id, users.first_name, users.surname FROM patients JOIN users ON patients.user_id = users.user_id WHERE patients.patient_id = :pid');
        $stmt->bindValue(':pid', $_POST['patient_id'], SQLITE3_INTEGER);
        $result = $stmt->execute();
        $patientDetails = $result->fetchArray(SQLITE3_ASSOC);

        if ($patientDetails) {
            $stmt = $db->prepare("UPDATE surgery SET patient_id = :pid, surgery_name = :surgery, eligible = :eligible WHERE surgery_id = :sid");
            $stmt->bindValue(':sid', $_POST['surgery_id'], SQLITE3_INTEGER);
            $stmt->bindValue(':pid', $patientDetails['patient_id'], SQLITE3_INTEGER);
            $stmt->bindValue(':surgery', $_POST['surgery'], SQLITE3_TEXT);
            $stmt->bindValue(':eligible', $eligibility_value, SQLITE3_INTEGER);
                
            $result = $stmt->execute();
        
            if ($result) {
                header("Location: ../proposedSurgery/updateSurgerySuccess.php?updated=true");
                exit();
            } else {
                echo "Error updating surgery.";
            }
        } else {
            echo "Error fetching patient details.";
        }
    }
}

$db = new SQLITE3('C:\xampp\data\stage_3.db');
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
    <title>Update Surgery</title>
</head>
<body>
<div class="container">
    <?php
        include("../includes/doctorHeader.php");
    ?>  
    <main>
        <h1>Update Surgery</h1>
        <form method="post">
        <?php if (isset($surgery)): ?>
            <input type="hidden" name="surgery_id" value="<?php echo $surgery['surgery_id']; ?>">
        <?php endif; ?>

        <label for="patient_id">Select Patient:</label>
        <select name="patient_id" id="patient_id">
            <option value="0">Select Patient</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?php echo $patient['patient_id']; ?>" <?php echo (isset($surgery) && $surgery['patient_id'] == $patient['patient_id']) || (isset($_POST['patient_id']) && $_POST['patient_id'] == $patient['patient_id']) ? 'selected' : ''; ?>>
                    <?php echo $patient['full_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="blank-error"><?php echo $errorpatient; ?></span>


            <label for="surgery">Surgery Name</label>
            <input type="text" id="surgery" name="surgery" value="<?php echo isset($_POST['surgery']) ? $_POST['surgery'] : (isset($surgery) ? $surgery['surgery_name'] : ''); ?>">
            <span class="blank-error"><?php echo $errorsurgery; ?></span>

            <label>Is patient eligible for this surgery?</label>
            <select name="eligible">
                <option value="">Select Option</option>
                <option value="yes" <?php echo (isset($surgery['eligible']) && $surgery['eligible'] == "yes") ? "selected" : ""; ?>>Yes</option>
                <option value="no" <?php echo (isset($surgery['eligible']) && $surgery['eligible'] == "no") ? "selected" : ""; ?>>No</option>
            </select>

            <input type="submit" value="Update Surgery" name="submit">
            <a href="../proposedSurgery/proposedSurgery.php" class="back-button">Back</a>
        </form>
    </main>
    <?php
        include("../includes/footer.php");
    ?>
    </div>
</body>
</html>
