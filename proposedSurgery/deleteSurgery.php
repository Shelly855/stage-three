<?php
include '../includes/dbConnection.php';

if (isset($_POST['delete'])) {
    $surgeryId = $_POST['sid'];

    $stmtDeleteQuestionnaire = $db->prepare("DELETE FROM POA_questionnaire WHERE surgery_id = :sid");
    $stmtDeleteQuestionnaire->bindValue(':sid', $surgeryId);
    $resultDeleteQuestionnaire = $stmtDeleteQuestionnaire->execute();

    $stmtDeleteSurgery = $db->prepare("DELETE FROM surgery WHERE surgery_id = :sid");
    $stmtDeleteSurgery->bindValue(':sid', $surgeryId);
    $resultDeleteSurgery = $stmtDeleteSurgery->execute();

    if ($resultDeleteSurgery && $resultDeleteQuestionnaire) {
        header("Location: ../proposedSurgery/deleteSurgerySuccess.php?deleted=true");
        exit();
    } else {
        echo "Error deleting surgery.";
    }
}

$sql = "SELECT surgery_name, patient_id FROM surgery WHERE surgery_id=:sid";
$stmt = $db->prepare($sql);
$stmt->bindValue(':sid', $_GET['sid']);
$result = $stmt->execute();
$surgery = $result->fetchArray(SQLITE3_ASSOC);

$userSql = "SELECT u.first_name, u.surname 
            FROM users u 
            JOIN patients p ON u.user_id = p.user_id 
            WHERE p.patient_id=:pid";
$stmtUserInfo = $db->prepare($userSql);
$stmtUserInfo->bindValue(':pid', $surgery['patient_id']);
$resultUserInfo = $stmtUserInfo->execute();
$userInfo = $resultUserInfo->fetchArray(SQLITE3_ASSOC);

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Delete Surgery</title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/doctorHeader.php");
        ?>  
        <main>
            <h2>Delete Surgery</h2><br>
            <div class="confirm">Are you sure you want to delete this surgery?</div>
            <?php if(isset($surgery) && isset($userInfo)): ?>
                <div class="delete-data">
                    <label class="delete-label">First Name:</label>
                    <label><?php echo $userInfo['first_name']; ?></label>
                </div>
                <div class="delete-data">
                    <label class="delete-label">Surname:</label>
                    <label><?php echo $userInfo['surname']; ?></label>
                </div>
                <div class="delete-data">
                    <label class="delete-label">Surgery Name:</label>
                    <label><?php echo $surgery['surgery_name']; ?></label>
                </div>
                <form method="post">
                    <input type="hidden" name="sid" value="<?php echo $_GET['sid'] ?>"><br>
                    <input type="submit" value="Delete" name="delete"><a href="../proposedSurgery/proposedSurgery.php" class="back-button">Back</a>
                </form>
            <?php else: ?>
                <p>Surgery or user information not found.</p>
            <?php endif; ?>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
