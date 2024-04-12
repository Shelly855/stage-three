<?php
$db = new SQLITE3('C:\xampp\data\stage_3.db');

if (isset($_POST['assign'])) {
    $sql = "INSERT INTO POA_questionnaire (surgery_id, assigned, completed, percentage_completed) VALUES (:sid, 1, 0, 0)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':sid', $_POST['sid']);
    $result = $stmt->execute();

    if ($result) {
        header("Location: ../proposedSurgery/assignQuestionnaireSuccess.php?assigned=true");
        exit();
    } else {
        echo "Error assigning questionnaire.";
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
    <title>Confirm Questionnaire Assignment</title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/doctorHeader.php");
        ?>
        <main>
        <h2>Confirm Questionnaire Assignment</h2>
        <div class="confirm">Are you sure you want to assign a questionnaire to the following surgery for this patient?</div>
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
            <input type="submit" value="Assign" name="assign">
            <a href="../proposedSurgery/proposedSurgery.php" class="back-button">Cancel</a>
        </form>
        <?php endif; ?>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>