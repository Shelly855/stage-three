<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Update Appointment</title>
</head>
<body>
    <div class="container">
        <?php
        include("includes/header.php");
        
        $db = new SQLITE3('C:\xampp\data\stage_3.db');
        $sql = "SELECT * FROM appointments WHERE appointment_id = :aid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':aid', $_GET['aid'], SQLITE3_TEXT);
        $result= $stmt->execute();
        $arrayResult = [];
        
        while($row=$result->fetchArray(SQLITE3_NUM)){
            $arrayResult [] = $row;
        }
        

        $erroraid = $errordate = $errornotes = $errormedhistory = $errorpid = $errorsid = "";
        $allFields = true;

        if (isset($_POST['submit'])) {

            if (empty($_POST['date'])) {
                $errordate = "Date is mandatory";
                $allFields = false;
            }
            if (empty($_POST['notes'])) {
                $errornotes = "Notes is mandatory";
                $allFields = false;
            }
            if (empty($_POST['medhistory'])) {
                $errormedhistory = "Medical History is mandatory";
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

                $stmt = $db->prepare("UPDATE appointments SET date = :date, clinical_notes = :notes, medical_history = :medhistory, patient_id = :pid, staff_id = :sid WHERE appointment_id = :aid");
                $stmt->bindValue(':date', $_POST['date']);
                $stmt->bindValue(':notes', $_POST['notes']);
                $stmt->bindValue(':medhistory', $_POST['medhistory']);
                $stmt->bindValue(':pid', $_POST['pid']);
                $stmt->bindValue(':sid', $_POST['sid']);
                $stmt->bindValue(':aid', $_GET['aid']);

                $result = $stmt->execute();

                if ($result) {
                    header('Location: appointments.php');
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
                <label>Date</label>
                <input type="date" name="date" value="<?php echo $arrayResult[0][1]; ?>">
                <span class="blank-error"><?php echo $errordate; ?></span>

                <label>Clinical Notes</label>
                <input type="text" name="notes" value="<?php echo $arrayResult[0][2]; ?>">
                <span class="blank-error"><?php echo $errornotes; ?></span>

                <label>Medical History</label>
                <input type="text" name="medhistory" value="<?php echo $arrayResult[0][3]; ?>">
                <span class="blank-error"><?php echo $errormedhistory; ?></span>

                <label>Patient ID</label>
                <input type="number" name="pid" value="<?php echo $arrayResult[0][4]; ?>">
                <span class="blank-error"><?php echo $errorpid; ?></span>

                <label>Staff ID</label>
                <input type="number" name="sid" value="<?php echo $arrayResult[0][5]; ?>">
                <span class="blank-error"><?php echo $errorsid; ?></span>

                <input type="submit" name="submit" value="Update"><a href="appointments.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
            include("includes/footer.php");
        ?>
    </div>
</body>
</html>
