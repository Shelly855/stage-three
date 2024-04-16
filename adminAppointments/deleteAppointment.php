<?php
$db = new SQLITE3('C:\xampp\data\stage_3.db');

if (isset($_POST['delete'])) {
    $stmt = $db->prepare("DELETE FROM appointments WHERE appointment_id = :aid");
    $stmt->bindValue(':aid', $_POST['aid']);
    $result = $stmt->execute();
    if ($result) {
        header("Location: ../adminAppointments/adminAppointments.php?deleted=true");
        exit();
    } else {
        echo "Error deleting appointment.";
    }
}

$sql = "SELECT a.date, a.time, u_patient.first_name AS patient_first_name, u_user.surname AS patient_last_name, u_user.first_name AS user_first_name, u_user.surname AS user_last_name 
        FROM appointments AS a 
        JOIN users AS u_patient ON a.patient_id = u_patient.user_id 
        JOIN users AS u_user ON a.user_id = u_user.user_id 
        WHERE a.appointment_id = :aid";
$stmt = $db->prepare($sql);
$stmt->bindValue(':aid', $_GET['aid']);
$result = $stmt->execute();
$arrayResult = [];

while ($row = $result->fetchArray(SQLITE3_NUM)) {
    $arrayResult[] = $row;
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
    <title>Delete Appointment</title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/adminHeader.php");
        ?>  
        <main>
            <h2>Delete Appointment <?php echo $_GET['aid']; ?></h2><br>
            <div class="confirm">Are you sure you want to delete this appointment?</div>
            <div class="delete-data">
                <label class="delete-label">Date:</label>
                <label><?php echo $arrayResult[0][0] ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Time:</label>
                <label><?php echo $arrayResult[0][1] ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Patient First Name:</label>
                <label><?php echo $arrayResult[0][2] ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Patient Last Name:</label>
                <label><?php echo $arrayResult[0][3] ?></label><br>
            </div>
            <div class="delete-data">
                <label class="delete-label">Staff First Name:</label>
                <label><?php echo $arrayResult[0][4] ?></label><br>
            </div>
            <div class="delete-data">
                <label class="delete-label">Staff Last Name:</label>
                <label><?php echo $arrayResult[0][5] ?></label><br>
            </div>
            <form method="post">
                <input type="hidden" name="aid" value="<?php echo $_GET['aid'] ?>"><br>
                <input type="submit" value="Delete" name="delete"><a href="../adminAppointments/adminAppointments.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>

