<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');
$errormc = $errorpmc = "";
$allFields = true;

if (isset($_POST['submit'])) {

    if (empty($_POST['medical_conditions'])) {
        $errormc = "Medical Conditions must be filled out";
        $allFields = false;
    }
    if (empty($_POST['previous_medical_conditions'])) {
        $errorpmc = "Previous Medical Conditions must be filled out";
        $allFields = false;
    }


    if ($allFields) {

        $stmt = $db->prepare("UPDATE patients SET medical_conditions = :medical_conditions, previous_medical_conditions = :previous_medical_conditions WHERE patient_id = :pid");
        $stmt->bindValue(':medical_conditions', $_POST['medical_conditions'], SQLITE3_TEXT);
        $stmt->bindValue(':previous_medical_conditions', $_POST['previous_medical_conditions'], SQLITE3_TEXT);
        $stmt->bindValue(':pid', $_POST['patient_id'], SQLITE3_INTEGER);

        $result = $stmt->execute();

        if ($result) {
            header('Location: ../doctorProfile/updateMedicalConditionsSuccess.php?updated=true');
            exit;
        } else {
            echo "Error updating patient.";
        }
    }
    }

if (isset($_GET['pid'])) {
    $stmt = $db->prepare('SELECT * FROM patients WHERE patient_id = :pid');
    $stmt->bindParam(':pid', $_GET['pid'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $patient = $result->fetchArray(SQLITE3_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Update Patient</title>
</head>

<body>
    <div class="container">
        <?php
        include ("../includes/doctorHeader.php");
        ?>
        <main>
            <h1>Update Patient Medical Details</h1>
            <form method="post">
                <?php if (isset($patient)): ?>
                    <input type="hidden" name="patient_id" value="<?php echo $patient['patient_id']; ?>">
                <?php endif; ?>

                <label>Medical Conditions</label>
                <input type="text" name="medical_conditions"
                    value="<?php echo isset($patient['medical_conditions']) ? $patient['medical_conditions'] : ''; ?>">
                <span class="blank-error"><?php echo $errormc; ?></span>

                <label>Previous Medical Conditions</label>
                <input type="text" name="previous_medical_conditions"
                    value="<?php echo isset($patient['previous_medical_conditions']) ? $patient['previous_medical_conditions'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpmc; ?></span>

                <input type="submit" value="Update Patient" name="submit">
                <a href="../doctorProfile/viewPatients.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
        include ("../includes/footer.php");
        ?>
    </div>
</body>

</html>
