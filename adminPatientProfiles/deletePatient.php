<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');

if (isset($_POST['delete'])) {
    if (isset($_POST['pid'])) {
        $patientId = $_POST['pid'];

        $stmt = $db->prepare("DELETE FROM patients WHERE patient_id = :pid");
        $stmt->bindValue(':pid', $patientId);
        $result = $stmt->execute();

        if ($result) {
            header("Location: ../adminPatientProfiles/deletePatientSuccess.php?deleted=true");
            exit();
        } else {
            echo "Error deleting patient.";
        }
    }
}

if (isset($_GET['pid'])) {
    $stmt = $db->prepare('SELECT * FROM patients WHERE patient_id = :pid');
    $stmt->bindParam(':pid', $_GET['pid'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $patient = $result->fetchArray(SQLITE3_ASSOC);
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Delete Patient</title>
</head>
<body>
    <div class="container">
        <?php include("../includes/header.php"); ?>
        <main>
            <h2>Delete Patient</h2>
            <div class="confirm">Are you sure you want to delete this patient?</div>
            <?php if(isset($patient)): ?>
            <div class="delete-data">
                <label class="delete-label">First Name:</label>
                <label><?php echo $patient['first_name']; ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Surname:</label>
                <label><?php echo $patient['surname']; ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Date of Birth:</label>
                <label><?php echo $patient['date_of_birth']; ?></label>
            </div>
            <?php endif; ?>
            <form method="post">
                <input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>">
                <input type="submit" value="Delete" name="delete">
                <a href="../adminPatientProfiles/adminPatientProfiles.php" class="back-button">Back</a>
            </form>
        </main>
        <?php include("../includes/footer.php"); ?>
    </div>
</body>
</html>
