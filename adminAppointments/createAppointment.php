<!-- can't have patient or staff id, confirm details from notifications and press button for appointment -->

<?php
function checkAppointmentIdExists($aid, $db) {
    $stmt = $db->prepare("SELECT appointment_id FROM appointments WHERE appointment_id = :aid");
    $stmt->bindValue(':aid', $aid, SQLITE3_INTEGER);
    $result = $stmt->execute();
    return $result->fetchArray() !== false;
}

$erroraid = $errordate = $errortime = $errorpid = $errorsid = "";
$allFields = true;

if (isset($_POST['submit'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (empty($_POST['aid'])) {
        $erroraid = "Appointment ID is mandatory";
        $allFields = false;
    }
    if (empty($_POST['date'])) {
        $errordate = "Date is mandatory";
        $allFields = false;
    }
    if (empty($_POST['time'])) {
        $errortime = "Time is mandatory";
        $allFields = false;
    }
    if (empty($_POST['pid'])) {
        $errorpid = "Patient ID is mandatory";
        $allFields = false;
    }
    if (empty($_POST['sid'])) {
        $errorsid = "Staff ID is mandatory";
        $allFields = false;
    }

    if ($allFields) {
        if (checkAppointmentIdExists($_POST['aid'], $db)) {
            $erroraid = "Appointment ID already exists";
        } else {
            $stmt = $db->prepare('INSERT INTO appointments (appointment_id, date, time, patient_id, staff_id) VALUES (:aid, :date, :time, :pid, :sid)');
            $stmt->bindValue(':aid', $_POST['aid'], SQLITE3_INTEGER);
            $stmt->bindValue(':date', $_POST['date'], SQLITE3_TEXT);
            $stmt->bindValue(':time', $_POST['time'], SQLITE3_TEXT);
            $stmt->bindValue(':pid', $_POST['pid'], SQLITE3_TEXT);
            $stmt->bindValue(':sid', $_POST['sid'], SQLITE3_TEXT);
            
            $result = $stmt->execute();
    
            if ($result) {
                header("Location: ../adminAppointments/createAppointmentSuccess.php?createAppointment=success");
                exit();
            } else {
                echo "Error creating appointment";
            }
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
    <title>Create Appointment</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/adminHeader.php");
        ?>  
        <main>
            <h1>Create Appointment</h1>
            <form method="post">
                <label>Appointment ID</label>
                <input type="number" name="aid" value="<?php echo isset($_POST['aid']) ? $_POST['aid'] : ''; ?>">
                <span class="blank-error"><?php echo $erroraid; ?></span>

                <label>Date</label>
                <input type="date" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
                <span class="blank-error"><?php echo $errordate; ?></span>

                <label>Time</label>
                <input type="time" name="time" value="<?php echo isset($_POST['time']) ? $_POST['time'] : ''; ?>">
                <span class="blank-error"><?php echo $errortime; ?></span>

                <label>Patient ID</label>
                <input type="number" name="pid" value="<?php echo isset($_POST['pid']) ? $_POST['pid'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpid; ?></span>

                <label>Staff ID</label>
                <input type="number" name="sid" value="<?php echo isset($_POST['sid']) ? $_POST['sid'] : ''; ?>">
                <span class="blank-error"><?php echo $errorsid; ?></span>

                <input type="submit" value="Create Appointment" name="submit">
                <a href="../adminAppointments/adminAppointments.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
