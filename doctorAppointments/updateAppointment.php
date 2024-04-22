<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Update Appointment</title>
</head>
<body>
    <div class="container">
        <?php
        include ("../includes/doctorHeader.php");
        include '../includes/dbConnection.php';

        $sql = "SELECT * FROM appointments WHERE appointment_id = :aid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':aid', $_GET['aid'], SQLITE3_TEXT);
        $result = $stmt->execute();
        $appointment = $result->fetchArray(SQLITE3_ASSOC);
        $arrayResult = [];

        while ($row = $result->fetchArray(SQLITE3_NUM)) {
            $arrayResult[] = $row;
        }

        $erroraid = $errordate = $errortime = "";
        $allFields = true;

        $patient_name = getPatientName($db, $appointment['patient_id']);

        function getPatientName($db, $patient_id)
        {
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
            if ($allFields) {
                $stmt = $db->prepare("UPDATE appointments SET clinical_notes = :notes WHERE appointment_id = :aid");
                
                $stmt->bindValue(':notes', $_POST['notes']);
                $stmt->bindValue(':aid', $_GET['aid']);

                $result = $stmt->execute();

                if ($result) {
                    header('Location: ../doctorAppointments/updateAppointmentSuccess.php?updated=true');
                    exit;
                } else {
                    echo "Error updating appointment.";
                }
            }
        }
        ?>
        <main>
            <h1>Update Appointment</h1>
            <form method="post">
                <?php if (isset($patient)): ?>
                    <input type="hidden" name="patient_id" value="<?php echo $patient['patient_id']; ?>">
                <?php endif; ?>
                <div id="patient-update">
                    <label>Patient Name:</label>
                    <span><?php echo isset($patient_name) ? $patient_name : ''; ?></span>
                </div>
                
                <label>Clinical Notes</label>
                <input type="text" name="notes" value="<?php echo $appointment['clinical_notes']; ?>">

                <input type="submit" name="submit" value="Update"><a href="../doctorAppointments/doctorAppointments.php"
                    class="back-button">Back</a>
            </form>
        </main>
        <?php
        include ("../includes/footer.php");
        ?>
    </div>
</body>
</html>
