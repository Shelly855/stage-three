<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');
$errorsurgery = "";
$allFields = true;

if (isset($_GET['sid'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');
    $surgery_id = $_GET['sid'];
    $stmt = $db->prepare("SELECT * FROM surgery WHERE surgery_id = :sid");
    $stmt->bindValue(':sid', $surgery_id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $surgery = $result->fetchArray(SQLITE3_ASSOC);
    
    $patient_name = getPatientName($db, $surgery['patient_id']);
}

function getPatientName($db, $patient_id) {
    $stmt = $db->prepare("SELECT u.first_name, u.surname FROM patients p JOIN users u ON p.user_id = u.user_id WHERE p.patient_id = :pid");
    $stmt->bindValue(':pid', $patient_id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $patient = $result->fetchArray(SQLITE3_ASSOC);
    
    if ($patient) {
        return $patient['first_name'] . ' ' . $patient['surname'];
    } else {
        return 'Unknown';
    }
}

if (isset($_POST['submit'])) {

    if (empty($_POST['surgery'])) {
        $errorsurgery = "Surgery Name is mandatory";
        $allFields = false;
    }

    if ($_POST['eligible'] == 'yes' || $_POST['eligible'] == 'no') {
        $eligibility_value = ($_POST['eligible'] == 'yes') ? 1 : 0;
    } else {
        $eligibility_value = null;
    }

    if ($allFields) {

        $stmt = $db->prepare("UPDATE surgery SET surgery_name = :surgery, eligible = :eligible WHERE surgery_id = :sid");
        $stmt->bindValue(':sid', $_POST['surgery_id'], SQLITE3_INTEGER);
        $stmt->bindValue(':surgery', $_POST['surgery'], SQLITE3_TEXT);
        if ($eligibility_value !== null) {
            $stmt->bindValue(':eligible', $eligibility_value, SQLITE3_INTEGER);
        } else {
            $stmt->bindValue(':eligible', null, SQLITE3_NULL);
        }
                
        $result = $stmt->execute();
        
        if ($result) {
            header("Location: ../proposedSurgery/updateSurgerySuccess.php?updated=true");
            exit();
        } else {
            echo "Error updating surgery.";
        }
    }
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
    <?php include("../includes/doctorHeader.php"); ?>  
    <main>
        <h1>Update Surgery</h1>
        <form method="post">
            <?php if (isset($surgery)): ?>
                <input type="hidden" name="surgery_id" value="<?php echo $surgery['surgery_id']; ?>">
            <?php endif; ?>

            <div id="surgery-update">
                <label>Patient Name:</label>
                <span><?php echo isset($patient_name) ? $patient_name : ''; ?></span>
            </div>

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
    <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>
