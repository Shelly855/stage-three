<?php
$errordate = $errortime = $errorpatient = $errorstaff = "";
$allFields = true;

if (isset($_POST['submit'])) {
    include '../includes/dbConnection.php';

    if (empty($_POST['patient_id']) || $_POST['patient_id'] == 0) {
        $errorpatient = "Please select a patient.";
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




    if ($allFields) {
    

        $stmt = $db->prepare('SELECT patients.patient_id, users.first_name, users.surname FROM patients JOIN users ON patients.user_id = users.user_id WHERE patients.patient_id = :pid');
        $stmt->bindValue(':pid', $_POST['patient_id'], SQLITE3_INTEGER);
        $result = $stmt->execute();
        $patientDetails = $result->fetchArray(SQLITE3_ASSOC);


        if ($patientDetails){
            $stmt = $db->prepare('INSERT INTO appointments (patient_id, date, time) VALUES (:pid, :date, :time)');
            $stmt->bindValue(':pid', $patientDetails['patient_id'], SQLITE3_INTEGER);
            $stmt->bindValue(':date', $_POST['date'], SQLITE3_TEXT);
            $stmt->bindValue(':time', $_POST['time'], SQLITE3_TEXT);

            $result = $stmt->execute();

            if ($result) {
                header("Location: ../adminAppointments/createAppointmentSuccess.php?createAppointment=success");
                exit();
            } else {
                echo "Error creating appointment.";
            }
        } else {
            echo "Error fetching patient details.";
        }



    }
}
include '../includes/dbConnection.php';
$stmt_patients = $db->prepare('SELECT patients.patient_id, users.first_name, users.surname FROM patients JOIN users ON patients.user_id = users.user_id');
$result_patients = $stmt_patients->execute();

$patients = array();

while ($row = $result_patients->fetchArray(SQLITE3_ASSOC)) {
    $patients[] = array(
        'patient_id' => $row['patient_id'],
        'full_name' => $row['first_name'] . ' ' . $row['surname']
    );
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
        include ("../includes/adminHeader.php");
        ?>
        <main>
            <h1>Create Appointment</h1>
            <form method="post">
                <label for="patient_id">Select Patient:</label>
                <select name="patient_id" id="patient_id">
                    <option value="0">Select Patient</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo $patient['patient_id']; ?>">
                            <?php echo $patient['full_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="blank-error"><?php echo $errorpatient; ?></span>

           
                <label>Date</label>
                <input type="date" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
                <span class="blank-error"><?php echo $errordate; ?></span>

                <label>Time</label>
                <input type="time" name="time" value="<?php echo isset($_POST['time']) ? $_POST['time'] : ''; ?>">
                <span class="blank-error"><?php echo $errortime; ?></span>

                <input type="submit" value="Create Appointment" name="submit">
                <a href="../adminAppointments/adminAppointments.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
        include ("../includes/footer.php");
        ?>
    </div>
</body>

</html>
