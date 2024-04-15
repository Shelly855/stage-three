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
        include("../includes/doctorHeader.php");
        
        $db = new SQLITE3('C:\xampp\data\stage_3.db');
        $sql = "SELECT * FROM appointments WHERE appointment_id = :aid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':aid', $_GET['aid'], SQLITE3_TEXT);
        $result= $stmt->execute();
        $arrayResult = [];
        
        while($row=$result->fetchArray(SQLITE3_NUM)){
            $arrayResult [] = $row;
        }
        

        if (isset($_POST['submit'])) {

            if ($allFields) {

                $stmt = $db->prepare("UPDATE appointments SET clinical_notes = :notes WHERE appointment_id = :aid");
                $stmt->bindValue(':notes', $_POST['notes']);
                $stmt->bindValue(':aid', $_GET['aid']);

                $result = $stmt->execute();

                if ($result) {
                    header('Location: ../doctorAppointments/doctorAppointments.php');
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

                <label>Clinical Notes</label>
                <input type="text" name="notes" value="<?php echo $arrayResult[0][3]; ?>">

                <input type="submit" name="submit" value="Update"><a href="../doctorAppointments/doctorAppointments.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
