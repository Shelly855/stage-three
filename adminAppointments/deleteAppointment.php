<?php
include '../includes/dbConnection.php';

if (isset($_POST['delete'])) {
    $stmt = $db->prepare("DELETE FROM appointments WHERE appointment_id = :aid");
    $stmt->bindValue(':aid', $_POST['aid']);
    $result = $stmt->execute();
    if ($result) {
        header("Location: ../adminAppointments/deleteAppointmentSuccess.php?deleted=true");
        exit();
    } else {
        echo "Error deleting appointment.";
    }
}

$sql = "SELECT a.date, a.time, u_patient.first_name AS patient_first_name, u_patient.surname AS patient_last_name
        FROM appointments AS a 
        JOIN patients AS p ON a.patient_id = p.patient_id
        JOIN users AS u_patient ON p.user_id = u_patient.user_id
        WHERE a.appointment_id = :aid";
$stmt = $db->prepare($sql);
$stmt->bindValue(':aid', $_GET['aid']);
$result = $stmt->execute();
$appointment = $result->fetchArray(SQLITE3_ASSOC);

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
                <label><?php echo $appointment['date'] ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Time:</label>
                <label><?php echo $appointment['time']?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Patient First Name:</label>
                <label><?php echo $appointment['patient_first_name'] ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Patient Last Name:</label>
                <label><?php echo $appointment['patient_last_name'] ?></label><br>
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
