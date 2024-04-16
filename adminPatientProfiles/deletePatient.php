<?php
session_start();

include '../includes/dbConnection.php';

if (isset($_POST['delete'])) {
    if (isset($_POST['pid'])) {
        $patientId = $_POST['pid'];

        $stmt_user_id = $db->prepare('SELECT user_id FROM patients WHERE patient_id = :pid');
        $stmt_user_id->bindValue(':pid', $patientId);
        $result_user_id = $stmt_user_id->execute();
        $row = $result_user_id->fetchArray(SQLITE3_ASSOC);
        $userId = $row['user_id'];

        $stmt_user_info = $db->prepare('SELECT first_name, surname FROM users WHERE user_id = :uid');
        $stmt_user_info->bindValue(':uid', $userId);
        $result_user_info = $stmt_user_info->execute();
        $user_info = $result_user_info->fetchArray(SQLITE3_ASSOC);
        $firstName = $user_info['first_name'];
        $surname = $user_info['surname'];

        $stmt_patient_delete = $db->prepare("DELETE FROM patients WHERE patient_id = :pid");
        $stmt_patient_delete->bindValue(':pid', $patientId);
        $result_patient_delete = $stmt_patient_delete->execute();

        $stmt_user_delete = $db->prepare("DELETE FROM users WHERE user_id = :uid");
        $stmt_user_delete->bindValue(':uid', $userId);
        $result_user_delete = $stmt_user_delete->execute();

        if ($result_patient_delete && $result_user_delete) {
            header("Location: ../adminPatientProfiles/deletePatientSuccess.php?deleted=true");
            exit();
        } else {
            echo "Error deleting patient.";
        }
    }
}

if (isset($_GET['pid'])) {
    $stmt = $db->prepare('SELECT patients.*, users.first_name, users.surname FROM patients INNER JOIN users ON patients.user_id = users.user_id WHERE patients.patient_id = :pid');
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
        <?php include("../includes/adminHeader.php"); ?>
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
                <label class="delete-label">Email:</label>
                <label><?php echo $patient['email']; ?></label>
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
