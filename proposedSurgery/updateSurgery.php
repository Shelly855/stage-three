<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');
$errorpatient = $errorsurgery = "";
$allFields = true;

if (isset($_POST['submit'])) {

    if (empty($_POST['patient_id']) || $_POST['patient_id'] == 0) {
        $errorpatient = "Please select a patient.";
        $allFields = false;
    }
    if (empty($_POST['surgery'])) {
        $errorsurgery = "Surgery Name is mandatory";
        $allFields = false;
    }

    if ($allFields) {

        $stmt = $db->prepare("UPDATE surgery SET patient_id = :pid, surgery_name = :surgery WHERE surgery_id = :sid");
        $stmt->bindValue(':sid', $_POST['sid'], SQLITE3_INTEGER);
        $stmt->bindValue(':pid', $_POST['pid'], SQLITE3_INTEGER);
        $stmt->bindValue(':surgery', $_POST['surgery'], SQLITE3_TEXT);

        $result = $stmt->execute();

        if ($result) {
            header('Location: updateSurgerySuccess.php?updated=true');
            exit;
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
                <option value="<?php echo $patient['patient_id']; ?>" <?php echo (isset($_POST['patient_id']) && $_POST['patient_id'] == $patient['patient_id']) ? 'selected' : ''; ?>>
                    <?php echo $patient['full_name']; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <span class="blank-error"><?php echo $errorpatient; ?></span>

            <label for="surgery">Surgery Name</label>
            <input type="text" id="surgery" name="surgery" value="<?php echo isset($_POST['surgery_name']) ? $_POST['surgery_name'] : ''; ?>">
            <span class="blank-error"><?php echo $errorsurgery; ?></span>

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

